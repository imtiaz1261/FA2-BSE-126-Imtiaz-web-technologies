import mongoose from "mongoose";
import { Booking } from "../models/Booking.js";
import { Gig } from "../models/Gig.js";
import { Notification } from "../models/Notification.js";
import { computeFees } from "../utils/money.js";
import {
  bookingCreateSchema,
  bookingStatusSchema,
  cancelSchema
} from "../utils/validators.js";

const CANCEL_WINDOW_MS = 30 * 60 * 1000;

export async function createBooking(req, res, next) {
  try {
    const { gigId, scheduledAt } = await bookingCreateSchema.validateAsync(req.body, { abortEarly: true });
    if (!mongoose.isValidObjectId(gigId)) return res.status(400).json({ message: "Invalid gigId" });

    const gig = await Gig.findById(gigId);
    if (!gig || !gig.isActive) return res.status(404).json({ message: "Gig not found" });

    const { gross, platformFee, net } = computeFees(gig.price);
    const booking = await Booking.create({
      gigId: gig._id,
      customerId: req.user._id,
      sellerId: gig.sellerId,
      scheduledAt: new Date(scheduledAt),
      status: "Pending",
      bookedAt: new Date(),
      amount: gross,
      platformFee,
      netAmount: net
    });

    await Notification.create({
      userId: gig.sellerId,
      type: "BOOKING_CREATED",
      title: "New booking request",
      body: `A customer requested "${gig.title}".`
    });

    res.status(201).json({ booking });
  } catch (e) {
    next(e);
  }
}

export async function getBooking(req, res, next) {
  try {
    const booking = await Booking.findById(req.params.bookingId)
      .populate("gigId")
      .populate("customerId", "email")
      .populate("sellerId", "email sellerProfile");
    if (!booking) return res.status(404).json({ message: "Booking not found" });
    const isOwner =
      booking.customerId?._id?.toString() === req.user._id.toString() ||
      booking.sellerId?._id?.toString() === req.user._id.toString();
    if (!isOwner) return res.status(403).json({ message: "Forbidden" });

    res.json({ booking, canCancel: canCancelBooking(booking) });
  } catch (e) {
    next(e);
  }
}

export async function listMyBookings(req, res, next) {
  try {
    const filter = req.user.role === "worker" ? { sellerId: req.user._id } : { customerId: req.user._id };
    const bookings = await Booking.find(filter)
      .sort({ createdAt: -1 })
      .limit(200)
      .populate("gigId", "title category price")
      .populate("sellerId", "sellerProfile")
      .populate("customerId", "email");
    res.json({
      bookings: bookings.map((b) => ({
        ...b.toObject(),
        canCancel: canCancelBooking(b)
      }))
    });
  } catch (e) {
    next(e);
  }
}

export async function updateBookingStatus(req, res, next) {
  try {
    const { status } = await bookingStatusSchema.validateAsync(req.body, { abortEarly: true });
    const booking = await Booking.findOne({ _id: req.params.bookingId, sellerId: req.user._id });
    if (!booking) return res.status(404).json({ message: "Booking not found" });
    if (booking.status === "Cancelled") return res.status(400).json({ message: "Cancelled booking cannot be updated" });

    booking.status = status;
    await booking.save();

    await Notification.create({
      userId: booking.customerId,
      type: "BOOKING_CONFIRMED",
      title: "Booking updated",
      body: `Your booking is now "${booking.status}".`
    });

    res.json({ booking });
  } catch (e) {
    next(e);
  }
}

export async function cancelBooking(req, res, next) {
  try {
    const { reason } = await cancelSchema.validateAsync(req.body, { abortEarly: true });
    const booking = await Booking.findById(req.params.bookingId);
    if (!booking) return res.status(404).json({ message: "Booking not found" });

    if (booking.customerId.toString() !== req.user._id.toString()) {
      return res.status(403).json({ message: "Only the customer can cancel" });
    }
    if (booking.status === "Cancelled") return res.status(400).json({ message: "Already cancelled" });
    if (!canCancelBooking(booking)) {
      return res.status(400).json({ message: "Cancellation window expired (30 minutes)" });
    }

    booking.status = "Cancelled";
    booking.cancelledAt = new Date();
    booking.cancelReason = reason ?? "";
    await booking.save();

    await Notification.create({
      userId: booking.sellerId,
      type: "BOOKING_CANCELLED",
      title: "Booking cancelled",
      body: "A customer cancelled a booking."
    });

    res.json({ booking, canCancel: false });
  } catch (e) {
    next(e);
  }
}

function canCancelBooking(booking) {
  if (!booking) return false;
  if (String(booking.status) === "Cancelled") return false;
  const bookedAt = booking.bookedAt ? new Date(booking.bookedAt).getTime() : 0;
  return Date.now() - bookedAt <= CANCEL_WINDOW_MS;
}


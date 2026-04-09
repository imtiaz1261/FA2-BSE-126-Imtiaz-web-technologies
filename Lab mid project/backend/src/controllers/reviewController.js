import mongoose from "mongoose";
import { Booking } from "../models/Booking.js";
import { Review } from "../models/Review.js";
import { reviewCreateSchema } from "../utils/validators.js";

export async function createReview(req, res, next) {
  try {
    const { bookingId, rating, comment } = await reviewCreateSchema.validateAsync(req.body, { abortEarly: true });
    if (!mongoose.isValidObjectId(bookingId)) return res.status(400).json({ message: "Invalid bookingId" });

    const booking = await Booking.findById(bookingId);
    if (!booking) return res.status(404).json({ message: "Booking not found" });
    if (booking.customerId.toString() !== req.user._id.toString()) {
      return res.status(403).json({ message: "Forbidden" });
    }
    if (booking.status !== "Completed") {
      return res.status(400).json({ message: "You can review only completed bookings" });
    }

    const review = await Review.create({
      gigId: booking.gigId,
      bookingId: booking._id,
      customerId: booking.customerId,
      sellerId: booking.sellerId,
      rating,
      comment: comment ?? ""
    });
    res.status(201).json({ review });
  } catch (e) {
    if (e?.code === 11000) return res.status(409).json({ message: "Review already exists for this booking" });
    next(e);
  }
}

export async function listGigReviews(req, res, next) {
  try {
    const gigId = req.params.gigId;
    if (!mongoose.isValidObjectId(gigId)) return res.status(400).json({ message: "Invalid gigId" });
    const reviews = await Review.find({ gigId }).sort({ createdAt: -1 }).limit(200);
    res.json({ reviews });
  } catch (e) {
    next(e);
  }
}


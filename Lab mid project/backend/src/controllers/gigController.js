import mongoose from "mongoose";
import { Gig } from "../models/Gig.js";
import { gigCreateSchema } from "../utils/validators.js";

export async function createGig(req, res, next) {
  try {
    const payload = await gigCreateSchema.validateAsync(req.body, { abortEarly: true });
    const gig = await Gig.create({ ...payload, sellerId: req.user._id });
    res.status(201).json({ gig });
  } catch (e) {
    next(e);
  }
}

export async function updateGig(req, res, next) {
  try {
    const payload = await gigCreateSchema.validateAsync(req.body, { abortEarly: true });
    const gig = await Gig.findOneAndUpdate(
      { _id: req.params.gigId, sellerId: req.user._id },
      { $set: payload },
      { new: true }
    );
    if (!gig) return res.status(404).json({ message: "Gig not found" });
    res.json({ gig });
  } catch (e) {
    next(e);
  }
}

export async function deleteGig(req, res, next) {
  try {
    const gig = await Gig.findOneAndDelete({ _id: req.params.gigId, sellerId: req.user._id });
    if (!gig) return res.status(404).json({ message: "Gig not found" });
    res.json({ ok: true });
  } catch (e) {
    next(e);
  }
}

export async function getGig(req, res, next) {
  try {
    const gig = await Gig.findById(req.params.gigId).populate("sellerId", "email role roles sellerProfile");
    if (!gig) return res.status(404).json({ message: "Gig not found" });
    res.json({ gig });
  } catch (e) {
    next(e);
  }
}

export async function listGigs(req, res, next) {
  try {
    const { q, category, minPrice, maxPrice, sellerId } = req.query;
    const filter = { isActive: true };
    if (category) filter.category = category;
    if (sellerId && mongoose.isValidObjectId(String(sellerId))) filter.sellerId = sellerId;

    if (minPrice || maxPrice) {
      filter.price = {};
      if (minPrice) filter.price.$gte = Number(minPrice);
      if (maxPrice) filter.price.$lte = Number(maxPrice);
    }

    let query = Gig.find(filter).sort({ createdAt: -1 });
    if (q && String(q).trim()) {
      query = query.find({ $text: { $search: String(q).trim() } }, { score: { $meta: "textScore" } }).sort({
        score: { $meta: "textScore" },
        createdAt: -1
      });
    }

    const gigs = await query.limit(60).populate("sellerId", "sellerProfile");
    res.json({ gigs });
  } catch (e) {
    next(e);
  }
}

export async function myGigs(req, res, next) {
  try {
    const gigs = await Gig.find({ sellerId: req.user._id }).sort({ createdAt: -1 });
    res.json({ gigs });
  } catch (e) {
    next(e);
  }
}


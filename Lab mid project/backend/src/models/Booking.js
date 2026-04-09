import mongoose from "mongoose";

const BookingSchema = new mongoose.Schema(
  {
    gigId: { type: mongoose.Schema.Types.ObjectId, ref: "Gig", required: true, index: true },
    customerId: { type: mongoose.Schema.Types.ObjectId, ref: "User", required: true, index: true },
    sellerId: { type: mongoose.Schema.Types.ObjectId, ref: "User", required: true, index: true },
    scheduledAt: { type: Date, required: true },
    status: {
      type: String,
      enum: ["Pending", "Confirmed", "Completed", "Cancelled"],
      default: "Pending",
      index: true
    },
    bookedAt: { type: Date, required: true, default: Date.now, index: true },
    cancelledAt: { type: Date, default: null },
    cancelReason: { type: String, trim: true, default: null },

    amount: { type: Number, required: true, min: 0 }, // price at booking time
    platformFee: { type: Number, required: true, min: 0 },
    netAmount: { type: Number, required: true, min: 0 }
  },
  { timestamps: true }
);

export const Booking = mongoose.model("Booking", BookingSchema);


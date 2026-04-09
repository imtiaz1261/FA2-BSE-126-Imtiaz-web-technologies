import mongoose from "mongoose";

const GigSchema = new mongoose.Schema(
  {
    sellerId: { type: mongoose.Schema.Types.ObjectId, ref: "User", required: true, index: true },
    title: { type: String, required: true, trim: true, maxlength: 120 },
    description: { type: String, required: true, trim: true, maxlength: 3000 },
    category: {
      type: String,
      required: true,
      enum: ["Cleaning", "Plumbing", "Electrical", "Painting", "Gardening", "AC Repair", "Other"],
      index: true
    },
    price: { type: Number, required: true, min: 0 },
    experienceLevel: { type: String, enum: ["Beginner", "Intermediate", "Expert"], default: "Intermediate" },
    isActive: { type: Boolean, default: true }
  },
  { timestamps: true }
);

GigSchema.index({ title: "text", description: "text" });

export const Gig = mongoose.model("Gig", GigSchema);


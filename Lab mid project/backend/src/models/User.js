import mongoose from "mongoose";

const SellerProfileSchema = new mongoose.Schema(
  {
    name: { type: String, trim: true },
    skills: [{ type: String, trim: true }],
    experienceYears: { type: Number, min: 0, default: 0 },
    serviceArea: { type: String, trim: true },
    profileImageUrl: { type: String, trim: true }
  },
  { _id: false }
);

const UserSchema = new mongoose.Schema(
  {
    email: { type: String, required: true, unique: true, lowercase: true, trim: true },
    passwordHash: { type: String, required: true },
    role: { type: String, enum: ["customer", "worker"], required: true },
    roles: { type: [String], enum: ["customer", "worker"], default: [] },
    sellerProfile: { type: SellerProfileSchema, default: null }
  },
  { timestamps: true }
);

UserSchema.index({ email: 1 }, { unique: true });

export const User = mongoose.model("User", UserSchema);


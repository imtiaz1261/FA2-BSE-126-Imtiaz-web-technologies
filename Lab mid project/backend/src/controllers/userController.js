import { User } from "../models/User.js";
import { sellerProfileSchema } from "../utils/validators.js";

export async function updateSellerProfile(req, res, next) {
  try {
    const payload = await sellerProfileSchema.validateAsync(req.body, { abortEarly: true });
    const user = await User.findById(req.user._id);
    if (!user) return res.status(404).json({ message: "User not found" });

    user.sellerProfile = payload;
    if (!user.roles?.includes("worker")) user.roles = [...(user.roles ?? []), "worker"];
    user.role = "worker";
    await user.save();

    const safe = await User.findById(user._id).select("-passwordHash");
    res.json({ user: safe });
  } catch (e) {
    next(e);
  }
}


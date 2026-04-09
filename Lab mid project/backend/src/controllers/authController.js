import bcrypt from "bcryptjs";
import { User } from "../models/User.js";
import { signJwt } from "../utils/auth.js";
import { loginSchema, registerSchema, switchRoleSchema } from "../utils/validators.js";

export async function register(req, res, next) {
  try {
    const { email, password, role } = await registerSchema.validateAsync(req.body, { abortEarly: true });
    const exists = await User.findOne({ email });
    if (exists) return res.status(409).json({ message: "Email already in use" });

    const passwordHash = await bcrypt.hash(password, 12);
    const user = await User.create({
      email,
      passwordHash,
      role,
      roles: [role]
    });

    const token = signJwt({ userId: user._id.toString() });
    const safe = await User.findById(user._id).select("-passwordHash");
    res.status(201).json({ token, user: safe });
  } catch (e) {
    next(e);
  }
}

export async function login(req, res, next) {
  try {
    const { email, password } = await loginSchema.validateAsync(req.body, { abortEarly: true });
    const user = await User.findOne({ email });
    if (!user) return res.status(401).json({ message: "Invalid email or password" });

    const ok = await bcrypt.compare(password, user.passwordHash);
    if (!ok) return res.status(401).json({ message: "Invalid email or password" });

    const token = signJwt({ userId: user._id.toString() });
    const safe = await User.findById(user._id).select("-passwordHash");
    res.json({ token, user: safe });
  } catch (e) {
    next(e);
  }
}

export async function me(req, res) {
  res.json({ user: req.user });
}

export async function switchRole(req, res, next) {
  try {
    const { role } = await switchRoleSchema.validateAsync(req.body, { abortEarly: true });
    const user = await User.findById(req.user._id);
    if (!user) return res.status(404).json({ message: "User not found" });

    const roles = new Set([...(user.roles ?? []), role]);
    user.roles = Array.from(roles);
    user.role = role;
    await user.save();

    const safe = await User.findById(user._id).select("-passwordHash");
    res.json({ user: safe });
  } catch (e) {
    next(e);
  }
}


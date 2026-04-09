import Joi from "joi";

export const registerSchema = Joi.object({
  email: Joi.string().email().required(),
  password: Joi.string().min(8).max(72).required(),
  role: Joi.string().valid("customer", "worker").required()
});

export const loginSchema = Joi.object({
  email: Joi.string().email().required(),
  password: Joi.string().required()
});

export const switchRoleSchema = Joi.object({
  role: Joi.string().valid("customer", "worker").required()
});

export const gigCreateSchema = Joi.object({
  title: Joi.string().max(120).required(),
  description: Joi.string().max(3000).required(),
  category: Joi.string()
    .valid("Cleaning", "Plumbing", "Electrical", "Painting", "Gardening", "AC Repair", "Other")
    .required(),
  price: Joi.number().min(0).required(),
  experienceLevel: Joi.string().valid("Beginner", "Intermediate", "Expert").optional(),
  isActive: Joi.boolean().optional()
});

export const bookingCreateSchema = Joi.object({
  gigId: Joi.string().required(),
  scheduledAt: Joi.date().iso().required()
});

export const bookingStatusSchema = Joi.object({
  status: Joi.string().valid("Confirmed", "Completed").required()
});

export const cancelSchema = Joi.object({
  reason: Joi.string().max(300).allow("").optional()
});

export const reviewCreateSchema = Joi.object({
  bookingId: Joi.string().required(),
  rating: Joi.number().min(1).max(5).required(),
  comment: Joi.string().max(2000).allow("").optional()
});

export const sellerProfileSchema = Joi.object({
  name: Joi.string().max(80).required(),
  skills: Joi.array().items(Joi.string().max(40)).max(30).default([]),
  experienceYears: Joi.number().min(0).max(60).default(0),
  serviceArea: Joi.string().max(120).allow("").default(""),
  profileImageUrl: Joi.string().uri().allow("").default("")
});


import { Router } from "express";
import { requireAuth } from "../middleware/authMiddleware.js";
import { createReview, listGigReviews } from "../controllers/reviewController.js";

const router = Router();

router.post("/", requireAuth, createReview);
router.get("/gig/:gigId", listGigReviews);

export default router;


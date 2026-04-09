import { Router } from "express";
import { requireAuth } from "../middleware/authMiddleware.js";
import { updateSellerProfile } from "../controllers/userController.js";

const router = Router();

router.put("/seller-profile", requireAuth, updateSellerProfile);

export default router;


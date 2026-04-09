import { Router } from "express";
import { requireAuth, requireRole } from "../middleware/authMiddleware.js";
import { sellerFinancialReport, sellerMetrics } from "../controllers/dashboardController.js";

const router = Router();

router.get("/seller/metrics", requireAuth, requireRole("worker"), sellerMetrics);
router.get("/seller/report", requireAuth, requireRole("worker"), sellerFinancialReport);

export default router;


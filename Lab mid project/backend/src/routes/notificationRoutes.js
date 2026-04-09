import { Router } from "express";
import { requireAuth } from "../middleware/authMiddleware.js";
import { listNotifications, markRead } from "../controllers/notificationController.js";

const router = Router();

router.get("/", requireAuth, listNotifications);
router.post("/:notificationId/read", requireAuth, markRead);

export default router;


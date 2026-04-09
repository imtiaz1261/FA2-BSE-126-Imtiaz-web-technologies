import { Router } from "express";
import { requireAuth, requireRole } from "../middleware/authMiddleware.js";
import {
  cancelBooking,
  createBooking,
  getBooking,
  listMyBookings,
  updateBookingStatus
} from "../controllers/bookingController.js";

const router = Router();

router.get("/mine", requireAuth, listMyBookings);
router.post("/", requireAuth, requireRole("customer"), createBooking);
router.get("/:bookingId", requireAuth, getBooking);
router.post("/:bookingId/cancel", requireAuth, requireRole("customer"), cancelBooking);
router.patch("/:bookingId/status", requireAuth, requireRole("worker"), updateBookingStatus);

export default router;


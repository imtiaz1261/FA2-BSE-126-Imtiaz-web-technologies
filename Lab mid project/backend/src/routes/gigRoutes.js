import { Router } from "express";
import { requireAuth, requireRole } from "../middleware/authMiddleware.js";
import { createGig, deleteGig, getGig, listGigs, myGigs, updateGig } from "../controllers/gigController.js";

const router = Router();

router.get("/", listGigs); // public search/list
router.get("/mine", requireAuth, requireRole("worker"), myGigs);
router.post("/", requireAuth, requireRole("worker"), createGig);
router.get("/:gigId", getGig);
router.put("/:gigId", requireAuth, requireRole("worker"), updateGig);
router.delete("/:gigId", requireAuth, requireRole("worker"), deleteGig);

export default router;


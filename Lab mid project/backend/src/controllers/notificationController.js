import { Notification } from "../models/Notification.js";

export async function listNotifications(req, res, next) {
  try {
    const notifications = await Notification.find({ userId: req.user._id })
      .sort({ createdAt: -1 })
      .limit(200);
    res.json({ notifications });
  } catch (e) {
    next(e);
  }
}

export async function markRead(req, res, next) {
  try {
    const n = await Notification.findOneAndUpdate(
      { _id: req.params.notificationId, userId: req.user._id },
      { $set: { isRead: true } },
      { new: true }
    );
    if (!n) return res.status(404).json({ message: "Notification not found" });
    res.json({ notification: n });
  } catch (e) {
    next(e);
  }
}


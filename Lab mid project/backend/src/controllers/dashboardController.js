import mongoose from "mongoose";
import { Booking } from "../models/Booking.js";

function startOfDay(d) {
  const x = new Date(d);
  x.setHours(0, 0, 0, 0);
  return x;
}

export async function sellerMetrics(req, res, next) {
  try {
    const sellerId = req.user._id;
    const now = new Date();
    const from30 = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);

    const [active, completed, last30, sums30, sumsAll] = await Promise.all([
      Booking.countDocuments({ sellerId, status: { $in: ["Pending", "Confirmed"] } }),
      Booking.countDocuments({ sellerId, status: "Completed" }),
      Booking.countDocuments({ sellerId, createdAt: { $gte: from30 } }),
      Booking.aggregate([
        { $match: { sellerId: new mongoose.Types.ObjectId(sellerId), status: "Completed", createdAt: { $gte: from30 } } },
        {
          $group: {
            _id: null,
            gross: { $sum: "$amount" },
            platformFee: { $sum: "$platformFee" },
            net: { $sum: "$netAmount" }
          }
        }
      ]),
      Booking.aggregate([
        { $match: { sellerId: new mongoose.Types.ObjectId(sellerId), status: "Completed" } },
        {
          $group: {
            _id: null,
            gross: { $sum: "$amount" },
            platformFee: { $sum: "$platformFee" },
            net: { $sum: "$netAmount" }
          }
        }
      ])
    ]);

    const s30 = sums30[0] ?? { gross: 0, platformFee: 0, net: 0 };
    const sall = sumsAll[0] ?? { gross: 0, platformFee: 0, net: 0 };

    res.json({
      metrics: {
        activeBookings: active,
        completedBookings: completed,
        bookingsLast30Days: last30,
        earningsLast30Days: { gross: s30.gross, platformFee: s30.platformFee, net: s30.net },
        lifetimeEarnings: { gross: sall.gross, platformFee: sall.platformFee, net: sall.net }
      }
    });
  } catch (e) {
    next(e);
  }
}

export async function sellerFinancialReport(req, res, next) {
  try {
    const sellerId = req.user._id;
    const from = req.query.from ? startOfDay(new Date(String(req.query.from))) : null;
    const to = req.query.to ? new Date(String(req.query.to)) : null;

    const match = { sellerId: new mongoose.Types.ObjectId(sellerId), status: "Completed" };
    if (from) match.createdAt = { ...(match.createdAt ?? {}), $gte: from };
    if (to) match.createdAt = { ...(match.createdAt ?? {}), $lte: to };

    const rows = await Booking.find(match)
      .sort({ createdAt: -1 })
      .limit(2000)
      .populate("gigId", "title category price");

    const totals = rows.reduce(
      (acc, b) => {
        acc.totalRevenue += b.amount;
        acc.platformFee += b.platformFee;
        acc.netIncome += b.netAmount;
        return acc;
      },
      { totalRevenue: 0, platformFee: 0, netIncome: 0 }
    );

    res.json({ totals, rows });
  } catch (e) {
    next(e);
  }
}


<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Earning;
use App\Models\WorkerActivity;
use Illuminate\Http\Request;

class WorkerBookingController extends Controller
{
    public function index(Request $request)
    {
        $worker = $request->user();

        $bookings = Booking::where('worker_id', $worker->id)
            ->with(['customer', 'service'])
            ->latest()
            ->get();

        return response()->json(['bookings' => $bookings]);
    }

    public function accept(Request $request, Booking $booking)
    {
        $this->authorizeWorker($request, $booking);

        $booking->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        WorkerActivity::create([
            'worker_id' => $request->user()->id,
            'text' => 'ACCEPTED: Booking #' . $booking->id . ' accepted.',
        ]);

        return response()->json([
            'message' => "Booking #{$booking->id} accepted.",
            'booking' => $booking->load(['customer', 'service']),
        ]);
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorizeWorker($request, $booking);

        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $data['reason'] ?? null,
        ]);

        WorkerActivity::create([
            'worker_id' => $request->user()->id,
            'text' => 'REJECTED: Booking #' . $booking->id . ' rejected.',
        ]);

        return response()->json([
            'message' => "Booking #{$booking->id} rejected.",
            'booking' => $booking->load(['customer', 'service']),
        ]);
    }

    public function complete(Request $request, Booking $booking)
    {
        $this->authorizeWorker($request, $booking);
        $worker = $request->user();

        $booking->update([
            'status' => 'completed',
            'completed_at' => now(),
            'rating' => $booking->rating ?? 4.7,
            'review' => $booking->review ?? 'Work completed successfully.',
        ]);

        $amount = (float) ($booking->service?->price ?? 0);

        if (! $booking->earning()->exists()) {
            Earning::create([
                'worker_id' => $worker->id,
                'booking_id' => $booking->id,
                'amount' => $amount,
                'status' => 'pending',
                'earned_date' => now()->toDateString(),
            ]);
        }

        $worker->increment('total_jobs');
        $worker->increment('total_earnings', $amount);

        WorkerActivity::create([
            'worker_id' => $worker->id,
            'text' => 'COMPLETED: Booking #' . $booking->id . ' marked complete.',
        ]);

        return response()->json([
            'message' => 'Job marked complete. Earnings recorded.',
            'booking' => $booking->load(['customer', 'service']),
        ]);
    }

    public function customerLocation(Request $request, Booking $booking)
    {
        $this->authorizeWorker($request, $booking);
        $booking->load(['customer', 'service']);

        return response()->json([
            'lat' => $booking->customer_lat,
            'lng' => $booking->customer_lng,
            'address' => $booking->customer_formatted_address ?: $booking->customer_address,
            'customer_name' => $booking->customer?->name,
            'service' => $booking->service?->title,
        ]);
    }

    private function authorizeWorker(Request $request, Booking $booking): void
    {
        if ($booking->worker_id !== $request->user()->id) {
            abort(403, 'You are not allowed to manage this booking.');
        }
    }
}

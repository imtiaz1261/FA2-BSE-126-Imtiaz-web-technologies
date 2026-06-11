<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Earning;
use App\Models\Service;
use App\Models\WorkerActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Booking::with(['service', 'user', 'worker']);

        if ($user->role === 'worker') {
            $query->where('worker_id', $user->id);
        } else {
            $query->where('user_id', $user->id);
        }

        return response()->json([
            'bookings' => $query->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'user') {
            return response()->json([
                'message' => 'Only users can create bookings.',
            ], 403);
        }

        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'notes' => ['nullable', 'string'],
            'customer_address' => ['required', 'string'],
        ]);

        $service = Service::findOrFail($data['service_id']);

        $booking = Booking::create([
            'user_id' => $user->id,
            'worker_id' => $service->worker_id,
            'service_id' => $service->id,
            'date' => $data['date'],
            'time' => $data['time'],
            'notes' => $data['notes'] ?? null,
            'customer_address' => $data['customer_address'],
            'status' => 'pending',
        ]);

        WorkerActivity::create([
            'worker_id' => $service->worker_id,
            'text' => 'NEW BOOKING: ' . $service->title . ' booking received.',
        ]);

        return response()->json([
            'message' => 'Booking created successfully.',
            'booking' => $booking->load(['service', 'user', 'worker']),
        ], 201);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($user->role !== 'worker' || $booking->worker_id !== $user->id) {
            return response()->json([
                'message' => 'You are not allowed to update this booking.',
            ], 403);
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['accepted', 'rejected', 'completed'])],
        ]);

        if ($booking->status === 'cancelled') {
            return response()->json([
                'message' => 'Cancelled booking cannot be updated.',
            ], 422);
        }

        $booking->status = $data['status'];

        if ($data['status'] === 'completed') {
            $booking->rating = $booking->rating ?? 4.7;
            $booking->review = $booking->review ?? 'Work completed successfully.';
            $booking->completed_at = now();

            $amount = (float) ($booking->service?->price ?? 0);
            if (! $booking->earning()->exists()) {
                Earning::create([
                    'worker_id' => $user->id,
                    'booking_id' => $booking->id,
                    'amount' => $amount,
                    'status' => 'pending',
                    'earned_date' => now()->toDateString(),
                ]);
                $user->increment('total_jobs');
                $user->increment('total_earnings', $amount);
            }
        }

        if ($data['status'] === 'accepted') {
            $booking->accepted_at = now();
        }

        if ($data['status'] === 'rejected') {
            $booking->rejected_at = now();
        }

        $booking->save();

        WorkerActivity::create([
            'worker_id' => $user->id,
            'text' => strtoupper($data['status']) . ': Booking updated.',
        ]);

        return response()->json([
            'message' => 'Booking status updated.',
            'booking' => $booking->load(['service', 'user', 'worker']),
        ]);
    }

    public function reschedule(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($user->role !== 'user' || $booking->user_id !== $user->id) {
            return response()->json([
                'message' => 'You are not allowed to reschedule this booking.',
            ], 403);
        }

        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return response()->json([
                'message' => 'This booking cannot be rescheduled.',
            ], 422);
        }

        $data = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required'],
        ]);

        $booking->update([
            'date' => $data['date'],
            'time' => $data['time'],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking rescheduled successfully.',
            'booking' => $booking->load(['service', 'user', 'worker']),
        ]);
    }

    public function cancel(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($user->role !== 'user' || $booking->user_id !== $user->id) {
            return response()->json([
                'message' => 'You are not allowed to cancel this booking.',
            ], 403);
        }

        if ($booking->status === 'completed') {
            return response()->json([
                'message' => 'Completed booking cannot be cancelled.',
            ], 422);
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'message' => 'Booking cancelled successfully.',
            'booking' => $booking->load(['service', 'user', 'worker']),
        ]);
    }
}

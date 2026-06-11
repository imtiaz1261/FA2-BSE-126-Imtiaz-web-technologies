<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Earning;
use App\Models\Message;
use App\Models\WorkerActivity;
use Illuminate\Http\Request;

class WorkerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $worker = $request->user();

        $stats = [
            'total_jobs' => Booking::where('worker_id', $worker->id)->where('status', 'completed')->count(),
            'active_jobs' => Booking::where('worker_id', $worker->id)->where('status', 'accepted')->count(),
            'pending_requests' => Booking::where('worker_id', $worker->id)->where('status', 'pending')->count(),
            'monthly_earnings' => (float) Earning::where('worker_id', $worker->id)->thisMonth()->paid()->sum('amount'),
            'pending_earnings' => (float) Earning::where('worker_id', $worker->id)->pending()->sum('amount'),
            'avg_rating' => (float) ($worker->rating ?? 0),
            'unread_messages' => Message::where('receiver_id', $worker->id)->where('is_read', false)->count(),
            'is_available' => (bool) $worker->is_available,
        ];

        $pendingRequests = Booking::where('worker_id', $worker->id)
            ->where('status', 'pending')
            ->with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        $activeJobs = Booking::where('worker_id', $worker->id)
            ->where('status', 'accepted')
            ->with(['customer', 'service'])
            ->get();

        $earningsChart = Earning::where('worker_id', $worker->id)
            ->where('earned_date', '>=', now()->subDays(29)->toDateString())
            ->selectRaw('DATE(earned_date) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('M d');
            $chartData[] = (float) ($earningsChart[$date]->total ?? 0);
        }

        $conversations = Message::where('receiver_id', $worker->id)
            ->orWhere('sender_id', $worker->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($msg) use ($worker) {
                return $msg->sender_id === $worker->id ? $msg->receiver_id : $msg->sender_id;
            })
            ->map(fn ($msgs) => $msgs->first())
            ->take(5)
            ->values();

        $recentReviews = Booking::where('worker_id', $worker->id)
            ->where('status', 'completed')
            ->whereNotNull('review')
            ->with('customer', 'service')
            ->latest()
            ->take(3)
            ->get();

        $recentActivities = WorkerActivity::where('worker_id', $worker->id)
            ->latest()
            ->take(8)
            ->get();

        return response()->json([
            'worker' => $worker,
            'stats' => $stats,
            'pending_requests' => $pendingRequests,
            'active_jobs' => $activeJobs,
            'chart_labels' => $chartLabels,
            'chart_data' => $chartData,
            'conversations' => $conversations,
            'recent_reviews' => $recentReviews,
            'recent_activities' => $recentActivities,
        ]);
    }

    public function toggleAvailability(Request $request)
    {
        $worker = $request->user();
        $worker->update(['is_available' => ! $worker->is_available]);

        $status = $worker->is_available
            ? 'You are now visible to customers.'
            : 'You are now offline.';

        return response()->json([
            'message' => $status,
            'is_available' => $worker->is_available,
        ]);
    }

    public function config()
    {
        return response()->json([
            'google_maps_api_key' => config('services.google_maps.key', ''),
        ]);
    }
}

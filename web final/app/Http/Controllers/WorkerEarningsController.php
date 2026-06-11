<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use Illuminate\Http\Request;

class WorkerEarningsController extends Controller
{
    public function index(Request $request)
    {
        $worker = $request->user();
        $thisMonth = Earning::where('worker_id', $worker->id)->thisMonth();

        $summary = [
            'this_month_total' => (float) $thisMonth->clone()->sum('amount'),
            'this_month_paid' => (float) $thisMonth->clone()->paid()->sum('amount'),
            'this_month_pending' => (float) $thisMonth->clone()->pending()->sum('amount'),
            'all_time_total' => (float) Earning::where('worker_id', $worker->id)->sum('amount'),
            'total_jobs_this_month' => $thisMonth->clone()->count(),
        ];

        $dailyEarnings = Earning::where('worker_id', $worker->id)
            ->thisMonth()
            ->selectRaw('DATE(earned_date) as date, SUM(amount) as total, COUNT(*) as jobs')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $transactions = Earning::where('worker_id', $worker->id)
            ->with(['booking.customer', 'booking.service'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'summary' => $summary,
            'daily_earnings' => $dailyEarnings,
            'transactions' => $transactions,
        ]);
    }

    public function chartData(Request $request)
    {
        $worker = $request->user();
        $range = $request->get('range', 'month');

        $startDate = match ($range) {
            'last_month' => now()->subMonth()->startOfMonth(),
            'last_3_months' => now()->subMonths(3)->startOfMonth(),
            default => now()->startOfMonth(),
        };

        $endDate = match ($range) {
            'last_month' => now()->subMonth()->endOfMonth(),
            default => now()->endOfMonth(),
        };

        $earnings = Earning::where('worker_id', $worker->id)
            ->whereBetween('earned_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->selectRaw('DATE(earned_date) as date, SUM(amount) as total, COUNT(*) as jobs')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data = [];
        $jobs = [];
        $cursor = $startDate->copy();

        while ($cursor->lte($endDate)) {
            $key = $cursor->format('Y-m-d');
            $labels[] = $cursor->format('M d');
            $data[] = (float) ($earnings[$key]->total ?? 0);
            $jobs[] = (int) ($earnings[$key]->jobs ?? 0);
            $cursor->addDay();
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'jobs' => $jobs,
        ]);
    }
}

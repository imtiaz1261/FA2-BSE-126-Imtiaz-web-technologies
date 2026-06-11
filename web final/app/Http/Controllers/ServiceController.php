<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('worker');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        return response()->json([
            'services' => $query->latest()->get(),
        ]);
    }

    public function categories()
    {
        return response()->json([
            'categories' => Service::query()
                ->select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),
        ]);
    }

    public function workerProfile($id)
    {
        $worker = User::where('role', 'worker')
            ->with('services')
            ->findOrFail($id);

        return response()->json([
            'worker' => $worker,
        ]);
    }
}

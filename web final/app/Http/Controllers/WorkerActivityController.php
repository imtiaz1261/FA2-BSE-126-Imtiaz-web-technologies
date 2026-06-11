<?php

namespace App\Http\Controllers;

use App\Models\WorkerActivity;
use Illuminate\Http\Request;

class WorkerActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activities = WorkerActivity::where('worker_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return response()->json(['activities' => $activities]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkerActivity $workerActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkerActivity $workerActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkerActivity $workerActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkerActivity $workerActivity)
    {
        //
    }
}

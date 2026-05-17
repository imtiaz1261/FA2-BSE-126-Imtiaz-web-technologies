<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    private const STATUS_IN_PROGRESS = 'In Progress';

    public function index(Request $request): View
    {
        $today = Carbon::today();

        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $inProgressTasks = Task::where('status', self::STATUS_IN_PROGRESS)->count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $overdueTasks = Task::whereDate('due_date', '<', $today)
            ->whereIn('status', ['Pending', self::STATUS_IN_PROGRESS])
            ->count();

        $tasks = Task::latest()->limit(5)->get();

        $weeklyLabels = collect(range(6, 0))->map(function (int $daysAgo): string {
            return Carbon::today()->subDays($daysAgo)->format('D');
        })->all();

        $weeklyCompletion = collect(range(6, 0))->map(function (int $daysAgo): int {
            $date = Carbon::today()->subDays($daysAgo);

            return Task::where('status', 'Completed')
                ->whereDate('updated_at', $date)
                ->count();
        })->all();

        $priorityLabels = ['High', 'Medium', 'Low'];
        $priorityCounts = [
            Task::where('priority', 'High')->count(),
            Task::where('priority', 'Medium')->count(),
            Task::where('priority', 'Low')->count(),
        ];

        $statusCounts = [
            'Completed' => $completedTasks,
            'Pending' => $pendingTasks,
            'In Progress' => $inProgressTasks,
        ];

        return view('tasks.index', [
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'pendingTasks' => $pendingTasks,
            'overdueTasks' => $overdueTasks,
            'weeklyLabels' => $weeklyLabels,
            'weeklyCompletion' => $weeklyCompletion,
            'priorityLabels' => $priorityLabels,
            'priorityCounts' => $priorityCounts,
            'statusCounts' => $statusCounts,
        ]);
    }

    public function dashboard(Request $request): View
    {
        $today = Carbon::today();

        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $inProgressTasks = Task::where('status', self::STATUS_IN_PROGRESS)->count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $overdueTasks = Task::whereDate('due_date', '<', $today)
            ->whereIn('status', ['Pending', self::STATUS_IN_PROGRESS])
            ->count();

        $tasks = Task::latest()->limit(5)->get();

        $priorityLabels = ['High', 'Medium', 'Low'];
        $priorityCounts = [
            Task::where('priority', 'High')->count(),
            Task::where('priority', 'Medium')->count(),
            Task::where('priority', 'Low')->count(),
        ];

        return view('dashboard', [
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'pendingTasks' => $pendingTasks,
            'overdueTasks' => $overdueTasks,
            'priorityLabels' => $priorityLabels,
            'priorityCounts' => $priorityCounts,
        ]);
    }

    public function completed(): View
    {
        $completedTasks = Task::where('status', 'Completed')
            ->latest()
            ->get();

        return view('tasks.completed', [
            'completedTasks' => $completedTasks,
        ]);
    }

    public function pending(): View
    {
        $pendingTasks = Task::where('status', 'Pending')
            ->latest()
            ->get();

        return view('tasks.pending', [
            'pendingTasks' => $pendingTasks,
        ]);
    }

    public function calendar(): View
    {
        $tasks = Task::orderBy('due_date')
            ->orderBy('priority')
            ->get()
            ->groupBy(function (Task $task): string {
                return $task->due_date?->format('Y-m-d') ?? 'unscheduled';
            })
            ->map(function ($group, string $dateKey) {
                $dueDate = $dateKey === 'unscheduled' ? null : Carbon::parse($dateKey);

                $state = match (true) {
                    $dueDate === null => 'upcoming',
                    $dueDate->isPast() && ! $dueDate->isToday() => 'overdue',
                    $dueDate->isToday() => 'today',
                    default => 'upcoming',
                };

                return [
                    'date' => $dueDate,
                    'state' => $state,
                    'tasks' => $group,
                ];
            })
            ->sortBy(function (array $item): int {
                if ($item['date'] === null) {
                    return PHP_INT_MAX;
                }

                return $item['date']->timestamp;
            })
            ->values();

        return view('calendar', [
            'taskGroups' => $tasks,
        ]);
    }

    public function analytics(): View
    {
        $today = Carbon::today();

        $totalTasks = Task::count();
        $completedCount = Task::where('status', 'Completed')->count();
        $pendingCount = Task::where('status', 'Pending')->count();
        $inProgressCount = Task::where('status', self::STATUS_IN_PROGRESS)->count();
        $completionPercentage = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100, 1) : 0;

        $statusChartLabels = ['Completed', 'Pending', 'In Progress'];
        $statusChartData = [$completedCount, $pendingCount, $inProgressCount];

        $priorityChartLabels = ['High', 'Medium', 'Low'];
        $priorityChartData = [
            Task::where('priority', 'High')->count(),
            Task::where('priority', 'Medium')->count(),
            Task::where('priority', 'Low')->count(),
        ];

        $weeklyProductivityLabels = collect(range(6, 0))->map(function (int $daysAgo): string {
            return Carbon::today()->subDays($daysAgo)->format('D');
        })->all();

        $weeklyProductivityData = collect(range(6, 0))->map(function (int $daysAgo): int {
            $date = Carbon::today()->subDays($daysAgo);

            return Task::where('status', 'Completed')
                ->whereDate('updated_at', $date)
                ->count();
        })->all();

        $overdueCount = Task::whereDate('due_date', '<', $today)
            ->whereIn('status', ['Pending', self::STATUS_IN_PROGRESS])
            ->count();

        return view('analytics', [
            'totalTasks' => $totalTasks,
            'completedCount' => $completedCount,
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'completionPercentage' => $completionPercentage,
            'statusChartLabels' => $statusChartLabels,
            'statusChartData' => $statusChartData,
            'priorityChartLabels' => $priorityChartLabels,
            'priorityChartData' => $priorityChartData,
            'weeklyProductivityLabels' => $weeklyProductivityLabels,
            'weeklyProductivityData' => $weeklyProductivityData,
            'overdueCount' => $overdueCount,
        ]);
    }

    public function settings(): View
    {
        $user = auth()->user();

        return view('settings', [
            'user' => $user,
            'totalTasksCreated' => Task::count(),
            'completedTasksCount' => Task::where('status', 'Completed')->count(),
            'pendingTasksCount' => Task::where('status', 'Pending')->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:Low,Medium,High'],
            'status' => ['required', 'in:Pending,' . self::STATUS_IN_PROGRESS . ',Completed'],
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully.');
    }

    public function show(int $id): View
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    public function edit(int $id): View
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:Low,Medium,High'],
            'status' => ['required', 'in:Pending,' . self::STATUS_IN_PROGRESS . ',Completed'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}

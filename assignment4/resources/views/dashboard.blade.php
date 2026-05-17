@extends('layouts.taskmaster')

@section('title', 'Dashboard')

@section('styles')
<style>
    .dashboard-wrap {
        padding: 28px;
        background: #0f172a;
        min-height: calc(100vh - 78px);
    }

    .dashboard-hero {
        margin-bottom: 32px;
    }

    .dashboard-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #f8fafc;
        margin: 0 0 8px;
        letter-spacing: -0.02em;
    }

    .dashboard-subtitle {
        font-size: 1rem;
        color: #cbd5e1;
        margin: 0;
        font-weight: 500;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 20px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .stat-card:hover {
        border-color: #475569;
        transform: translateY(-2px);
    }

    .stat-label {
        font-size: 0.875rem;
        color: #cbd5e1;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 900;
        color: #f8fafc;
        margin: 0 0 6px;
        line-height: 1;
    }

    .stat-meta {
        font-size: 0.875rem;
        color: #94a3b8;
    }

    .section-header {
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #f8fafc;
        margin: 0 0 4px;
    }

    .section-subtitle {
        font-size: 0.95rem;
        color: #cbd5e1;
        margin: 0;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .chart-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 22px;
    }

    .chart-box {
        height: 280px;
        position: relative;
        margin-top: 10px;
    }

    .recent-tasks-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        overflow: hidden;
    }

    .recent-tasks-header {
        padding: 22px;
        border-bottom: 1px solid #334155;
    }

    .task-item {
        display: grid;
        grid-template-columns: 1fr 1fr auto auto;
        gap: 16px;
        padding: 16px 22px;
        align-items: center;
        border-bottom: 1px solid #334155;
        transition: background-color 0.2s ease;
    }

    .task-item:hover {
        background: rgba(148, 163, 184, 0.05);
    }

    .task-item:last-child {
        border-bottom: 0;
    }

    .task-title {
        color: #f8fafc;
        font-weight: 600;
        word-break: break-word;
    }

    .task-description {
        color: #cbd5e1;
        font-size: 0.875rem;
    }

    .task-due {
        color: #cbd5e1;
        font-size: 0.875rem;
    }

    .priority-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .priority-high {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
    }

    .priority-medium {
        background: rgba(245, 158, 11, 0.15);
        color: #fcd34d;
    }

    .priority-low {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #fcd34d;
    }

    .status-in-progress {
        background: rgba(34, 211, 238, 0.15);
        color: #67e8f9;
    }

    .status-completed {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #cbd5e1;
    }

    .empty-icon {
        font-size: 3rem;
        color: #64748b;
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 1rem;
    }

    @media (max-width: 1399.98px) {
        .stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .task-item {
            grid-template-columns: 1fr auto;
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-wrap {
            padding: 18px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-title {
            font-size: 1.75rem;
        }

        .section-title {
            font-size: 1.25rem;
        }

        .task-item {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-wrap">
    <!-- Hero Section -->
    <div class="dashboard-hero">
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Real-time overview of your tasks and productivity.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-kanban"></i> Total Tasks
            </div>
            <div class="stat-value">{{ $totalTasks }}</div>
            <div class="stat-meta">All tasks in the system</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-check-circle"></i> Completed
            </div>
            <div class="stat-value">{{ $completedTasks }}</div>
            <div class="stat-meta">Tasks finished</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-hourglass-split"></i> Pending
            </div>
            <div class="stat-value">{{ $pendingTasks }}</div>
            <div class="stat-meta">Waiting to start</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-arrow-repeat"></i> In Progress
            </div>
            <div class="stat-value">{{ $inProgressTasks }}</div>
            <div class="stat-meta">Currently working</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-exclamation-circle"></i> Overdue
            </div>
            <div class="stat-value">{{ $overdueTasks }}</div>
            <div class="stat-meta">Past due date</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Chart 1: Task Status Distribution -->
        <div class="chart-card">
            <div class="section-header">
                <h2 class="section-title">Task Status</h2>
                <p class="section-subtitle">Completed vs Pending distribution</p>
            </div>
            <div class="chart-box">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Priority Breakdown -->
        <div class="chart-card">
            <div class="section-header">
                <h2 class="section-title">Priority Breakdown</h2>
                <p class="section-subtitle">Task distribution by priority level</p>
            </div>
            <div class="chart-box">
                <canvas id="priorityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Tasks Section -->
    <div class="recent-tasks-card">
        <div class="recent-tasks-header">
            <div class="section-header">
                <h2 class="section-title">Recent Tasks</h2>
                <p class="section-subtitle">Your 5 most recent tasks</p>
            </div>
        </div>

        @if ($tasks && count($tasks) > 0)
            @foreach ($tasks as $task)
                <div class="task-item">
                    <div>
                        <div class="task-title">{{ $task->title }}</div>
                        @if ($task->description)
                            <div class="task-description">{{ Str::limit($task->description, 50) }}</div>
                        @endif
                    </div>

                    <div class="task-due">
                        {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                    </div>

                    <div>
                        @if ($task->priority === 'High')
                            <span class="priority-badge priority-high">High</span>
                        @elseif ($task->priority === 'Medium')
                            <span class="priority-badge priority-medium">Medium</span>
                        @else
                            <span class="priority-badge priority-low">Low</span>
                        @endif
                    </div>

                    <div>
                        @if ($task->status === 'Pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif ($task->status === 'In Progress')
                            <span class="status-badge status-in-progress">In Progress</span>
                        @else
                            <span class="status-badge status-completed">Completed</span>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <div class="empty-text">No tasks yet. Create your first task to get started.</div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js" integrity="sha512-Y51n9mtKTVBh3Jbx5pZSNNDMyY+yGe77DGtBPzRlgsf/YLCh13kSZ3JmfHGzYFCmOndraf0sQgfM654b7dJ3w==" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusCanvas = document.getElementById('statusChart');
        const priorityCanvas = document.getElementById('priorityChart');

        if (!statusCanvas || !priorityCanvas) {
            return;
        }

        // Status Chart Data
        const statusCtx = statusCanvas.getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'In Progress'],
                datasets: [{
                    data: [{{ $completedTasks }}, {{ $pendingTasks }}, {{ $inProgressTasks }}],
                    backgroundColor: [
                        '#22c55e',
                        '#f59e0b',
                        '#22d3ee'
                    ],
                    borderColor: '#1e293b',
                    borderWidth: 2,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#cbd5e1',
                            font: { weight: 'bold', size: 12 },
                            padding: 15
                        }
                    }
                }
            }
        });

        // Priority Chart Data
        const priorityCtx = priorityCanvas.getContext('2d');
        new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: ['High', 'Medium', 'Low'],
                datasets: [{
                    label: 'Count',
                    data: [
                        {{ $priorityCounts[0] }},
                        {{ $priorityCounts[1] }},
                        {{ $priorityCounts[2] }}
                    ],
                    backgroundColor: [
                        '#ef4444',
                        '#f59e0b',
                        '#22c55e'
                    ],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#cbd5e1' },
                        grid: { color: 'rgba(148, 163, 184, 0.1)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#cbd5e1' },
                        grid: { color: 'rgba(148, 163, 184, 0.1)' }
                    }
                }
            }
        });
    });
</script>
@endsection

@extends('layouts.taskmaster')

@section('title', 'Analytics')

@section('styles')
<style>
    .analytics-wrap {
        padding: 30px;
        min-height: calc(100vh - 78px);
        background:
            radial-gradient(circle at top left, rgba(6, 182, 212, 0.16), transparent 24%),
            radial-gradient(circle at top right, rgba(124, 58, 237, 0.16), transparent 26%),
            linear-gradient(160deg, rgba(7, 17, 31, 0.98), rgba(11, 23, 48, 0.96));
    }

    .analytics-hero {
        margin-bottom: 24px;
    }

    .analytics-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(124, 58, 237, 0.14);
        color: #d8b4fe;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .analytics-title {
        color: #fff;
        font-size: clamp(2rem, 3vw, 3rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        margin: 0 0 10px;
    }

    .analytics-subtitle {
        color: #cbd5e1;
        font-size: 1.02rem;
        margin: 0;
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .analytics-card,
    .analytics-chart-card,
    .analytics-progress-card {
        border-radius: 28px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
        overflow: hidden;
    }

    .analytics-card {
        padding: 22px;
        min-height: 170px;
        position: relative;
        overflow: hidden;
    }

    .analytics-card::after {
        content: '';
        position: absolute;
        inset: auto -24px -30px auto;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(34, 211, 238, 0.14), transparent 70%);
        pointer-events: none;
    }

    .analytics-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .analytics-label {
        color: #bfdbfe;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.78rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .analytics-value {
        color: #fff;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        line-height: 1;
        font-weight: 900;
        margin: 8px 0 10px;
    }

    .analytics-meta {
        color: #cbd5e1;
        font-size: 0.92rem;
        margin: 0;
    }

    .analytics-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 1.45rem;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.18);
        flex-shrink: 0;
    }

    .analytics-icon.blue { background: linear-gradient(135deg, #2563eb, #22d3ee); }
    .analytics-icon.green { background: linear-gradient(135deg, #10b981, #22c55e); }
    .analytics-icon.orange { background: linear-gradient(135deg, #f59e0b, #fb7185); }
    .analytics-icon.purple { background: linear-gradient(135deg, #7c3aed, #a855f7); }
    .analytics-icon.cyan { background: linear-gradient(135deg, #06b6d4, #0ea5e9); }

    .analytics-progress-card {
        padding: 24px;
        margin-bottom: 22px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .section-title {
        color: #fff;
        font-size: 1.05rem;
        font-weight: 900;
        margin: 0;
    }

    .section-subtitle {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 4px 0 0;
    }

    .progress-track {
        width: 100%;
        height: 16px;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(148, 163, 184, 0.12);
    }

    .progress-fill {
        height: 100%;
        border-radius: 999px;
        width: {{ $completionPercentage }}%;
        background: linear-gradient(90deg, #7c3aed 0%, #06b6d4 55%, #22c55e 100%);
        box-shadow: 0 16px 24px rgba(6, 182, 212, 0.18);
    }

    .progress-meta {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 14px;
        color: #cbd5e1;
        font-weight: 700;
    }

    .analytics-charts {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .analytics-chart-card {
        padding: 24px;
        min-height: 410px;
    }

    .chart-box {
        position: relative;
        height: 320px;
        margin-top: 10px;
    }

    .chart-legend-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(148, 163, 184, 0.12);
        color: #cbd5e1;
        font-weight: 700;
        font-size: 0.84rem;
    }

    .analytics-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .analytics-back-btn,
    .analytics-create-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border-radius: 16px;
        padding: 12px 18px;
        font-weight: 800;
        text-decoration: none;
    }

    .analytics-back-btn {
        color: #e2e8f0;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: rgba(255, 255, 255, 0.03);
    }

    .analytics-create-btn {
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        box-shadow: 0 18px 36px rgba(124, 58, 237, 0.22);
    }

    @media (max-width: 1399.98px) {
        .analytics-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .analytics-charts {
            grid-template-columns: 1fr 1fr;
        }

        .analytics-charts .analytics-chart-card:last-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 991.98px) {
        .analytics-wrap {
            padding: 18px;
        }

        .analytics-grid,
        .analytics-charts {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $completionPercentage = $completionPercentage ?? 0;
@endphp

<div class="analytics-wrap">
    <div class="analytics-hero">
        <div class="analytics-kicker">
            <i class="bi bi-bar-chart-line-fill"></i>
            Analytics
        </div>

        <h1 class="analytics-title">Analytics</h1>
        <p class="analytics-subtitle">A premium overview of task performance, priorities, and weekly productivity.</p>
    </div>

    <div class="analytics-toolbar">
        <a href="{{ route('tasks.index') }}" class="analytics-back-btn">
            <i class="bi bi-arrow-left"></i>
            Back to My Tasks
        </a>

        <a href="{{ route('tasks.index') }}#add-task" class="analytics-create-btn">
            <i class="bi bi-plus-circle"></i>
            Create Task
        </a>
    </div>

    <section class="analytics-grid">
        <article class="analytics-card">
            <div class="analytics-head">
                <div>
                    <div class="analytics-label">Total</div>
                    <div class="analytics-value">{{ $totalTasks }}</div>
                    <p class="analytics-meta">All tasks in the database</p>
                </div>
                <div class="analytics-icon blue"><i class="bi bi-kanban"></i></div>
            </div>
        </article>

        <article class="analytics-card">
            <div class="analytics-head">
                <div>
                    <div class="analytics-label">Completed</div>
                    <div class="analytics-value">{{ $completedCount }}</div>
                    <p class="analytics-meta">Tasks finished successfully</p>
                </div>
                <div class="analytics-icon green"><i class="bi bi-check-circle-fill"></i></div>
            </div>
        </article>

        <article class="analytics-card">
            <div class="analytics-head">
                <div>
                    <div class="analytics-label">Pending</div>
                    <div class="analytics-value">{{ $pendingCount }}</div>
                    <p class="analytics-meta">Waiting to be started</p>
                </div>
                <div class="analytics-icon orange"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </article>

        <article class="analytics-card">
            <div class="analytics-head">
                <div>
                    <div class="analytics-label">In Progress</div>
                    <div class="analytics-value">{{ $inProgressCount }}</div>
                    <p class="analytics-meta">Currently being worked on</p>
                </div>
                <div class="analytics-icon cyan"><i class="bi bi-arrow-repeat"></i></div>
            </div>
        </article>

        <article class="analytics-card">
            <div class="analytics-head">
                <div>
                    <div class="analytics-label">Completion %</div>
                    <div class="analytics-value">{{ $completionPercentage }}%</div>
                    <p class="analytics-meta">Completion rate of all tasks</p>
                </div>
                <div class="analytics-icon purple"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
        </article>
    </section>

    <section class="analytics-progress-card">
        <div class="section-header">
            <div>
                <h2 class="section-title">Productivity Progress</h2>
                <p class="section-subtitle">Completion rate across all tasks</p>
            </div>
            <span class="chart-legend-pill">
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                {{ $completionPercentage }}% complete
            </span>
        </div>

        <div class="progress-track">
            <div class="progress-fill"></div>
        </div>

        <div class="progress-meta">
            <span>Completed: {{ $completedCount }}</span>
            <span>Pending: {{ $pendingCount }}</span>
            <span>In Progress: {{ $inProgressCount }}</span>
            <span>Overdue: {{ $overdueCount }}</span>
        </div>
    </section>

    <section class="analytics-charts">
        <article class="analytics-chart-card">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Task Status</h2>
                    <p class="section-subtitle">Doughnut chart</p>
                </div>
                <span class="chart-legend-pill">Status data</span>
            </div>

            <div class="chart-box">
                <canvas id="statusChart"></canvas>
            </div>
        </article>

        <article class="analytics-chart-card">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Priority Breakdown</h2>
                    <p class="section-subtitle">Bar chart</p>
                </div>
                <span class="chart-legend-pill">Priority data</span>
            </div>

            <div class="chart-box">
                <canvas id="priorityChart"></canvas>
            </div>
        </article>

        <article class="analytics-chart-card">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Weekly Completion</h2>
                    <p class="section-subtitle">Line chart</p>
                </div>
                <span class="chart-legend-pill">7-day trend</span>
            </div>

            <div class="chart-box">
                <canvas id="weeklyChart"></canvas>
            </div>
        </article>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js" integrity="sha512-Y51n9mtKTVBh3Jbx5pZSNNDMyY+yGe77DGtBPzRlgsf/YLCh13kSZ3JmfHGzYFCmOndraf0sQgfM654b7dJ3w==" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusCanvas = document.getElementById('statusChart');
        const priorityCanvas = document.getElementById('priorityChart');
        const weeklyCanvas = document.getElementById('weeklyChart');

        if (!statusCanvas || !priorityCanvas || !weeklyCanvas) {
            return;
        }

        const statusLabels = @json($statusChartLabels);
        const statusData = @json($statusChartData);
        const priorityLabels = @json($priorityChartLabels);
        const priorityData = @json($priorityChartData);
        const weeklyLabels = @json($weeklyProductivityLabels);
        const weeklyData = @json($weeklyProductivityData);

        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#22c55e', '#f59e0b', '#06b6d4'],
                    borderColor: '#0f172a',
                    borderWidth: 4,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#e2e8f0' }
                    }
                }
            }
        });

        new Chart(priorityCanvas, {
            type: 'bar',
            data: {
                labels: priorityLabels,
                datasets: [{
                    label: 'Tasks',
                    data: priorityData,
                    backgroundColor: ['#ef4444', '#f59e0b', '#22c55e'],
                    borderRadius: 12,
                    borderSkipped: false,
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
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(148, 163, 184, 0.08)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#94a3b8', precision: 0 },
                        grid: { color: 'rgba(148, 163, 184, 0.08)' }
                    }
                }
            }
        });

        new Chart(weeklyCanvas, {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Completed Tasks',
                    data: weeklyData,
                    borderColor: '#22d3ee',
                    backgroundColor: 'rgba(34, 211, 238, 0.16)',
                    fill: true,
                    tension: 0.42,
                    borderWidth: 3,
                    pointBackgroundColor: '#7c3aed',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#e2e8f0' }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(148, 163, 184, 0.08)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#94a3b8', precision: 0 },
                        grid: { color: 'rgba(148, 163, 184, 0.08)' }
                    }
                }
            }
        });
    });
</script>
@endsection

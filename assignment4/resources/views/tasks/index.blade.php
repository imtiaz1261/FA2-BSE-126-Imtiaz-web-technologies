@extends('layouts.taskmaster')

@section('title', 'TaskMaster Dashboard')

@section('styles')
<style>
    .tm-page-card {
        background:
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.18), transparent 26%),
            radial-gradient(circle at top right, rgba(6, 182, 212, 0.16), transparent 24%),
            linear-gradient(160deg, rgba(7, 17, 31, 0.98), rgba(10, 18, 36, 0.94));
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.2);
    }

    .tm-dashboard {
        padding: 28px;
        color: #e2e8f0;
    }

    .tm-hero {
        display: grid;
        grid-template-columns: 1.3fr 0.9fr;
        gap: 22px;
        margin-bottom: 22px;
    }

    .tm-hero-panel,
    .tm-panel {
        border-radius: 28px;
        background: rgba(15, 23, 42, 0.54);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 18px 50px rgba(2, 6, 23, 0.24);
    }

    .tm-hero-panel {
        padding: 30px;
        min-height: 250px;
    }

    .tm-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(124, 58, 237, 0.16);
        color: #c4b5fd;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .tm-hero-title {
        font-size: clamp(2rem, 4vw, 3.7rem);
        line-height: 1.02;
        font-weight: 900;
        letter-spacing: -0.05em;
        margin-bottom: 14px;
        color: #fff;
    }

    .tm-hero-title span {
        background: linear-gradient(135deg, #c084fc, #22d3ee);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .tm-hero-subtitle {
        color: #cbd5e1;
        max-width: 48rem;
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 22px;
    }

    .tm-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .tm-gradient-btn {
        border: 0;
        border-radius: 16px;
        padding: 13px 20px;
        font-weight: 800;
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 18px 35px rgba(124, 58, 237, 0.25);
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .tm-gradient-btn:hover {
        transform: translateY(-2px);
        color: #fff;
        box-shadow: 0 24px 42px rgba(6, 182, 212, 0.24);
    }

    .tm-outline-btn {
        border-radius: 16px;
        padding: 13px 20px;
        font-weight: 800;
        color: #fff;
        border: 1px solid rgba(148, 163, 184, 0.28);
        background: rgba(255, 255, 255, 0.03);
        text-decoration: none;
    }

    .tm-feature-card {
        padding: 26px;
        min-height: 250px;
        position: relative;
        overflow: hidden;
    }

    .tm-feature-card::before {
        content: '';
        position: absolute;
        inset: auto -20% -40% auto;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.28), transparent 70%);
        pointer-events: none;
    }

    .tm-feature-card h3 {
        color: #fff;
        font-weight: 900;
        margin-bottom: 16px;
    }

    .tm-feature-list {
        display: grid;
        gap: 12px;
        margin: 0;
        padding: 0;
        list-style: none;
        position: relative;
        z-index: 1;
    }

    .tm-feature-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #dbeafe;
        padding: 11px 14px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(148, 163, 184, 0.12);
    }

    .tm-feature-list i {
        color: #22d3ee;
        font-size: 1.05rem;
    }

    .tm-stats-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .tm-stat-card {
        padding: 22px;
        border-radius: 24px;
        background: rgba(15, 23, 42, 0.52);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(18px);
        box-shadow: 0 18px 50px rgba(2, 6, 23, 0.18);
        min-height: 170px;
        position: relative;
        overflow: hidden;
    }

    .tm-stat-card::after {
        content: '';
        position: absolute;
        inset: auto -28px -30px auto;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(34, 211, 238, 0.13), transparent 70%);
    }

    .tm-stat-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .tm-stat-icon {
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

    .tm-stat-icon.purple {
        background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    }

    .tm-stat-icon.cyan {
        background: linear-gradient(135deg, #06b6d4, #0ea5e9);
    }

    .tm-stat-icon.green {
        background: linear-gradient(135deg, #10b981, #22c55e);
    }

    .tm-stat-icon.orange {
        background: linear-gradient(135deg, #f59e0b, #fb7185);
    }

    .tm-stat-icon.red {
        background: linear-gradient(135deg, #ef4444, #f97316);
    }

    .tm-stat-label {
        color: #bfdbfe;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.78rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .tm-stat-value {
        color: #fff;
        font-size: clamp(1.85rem, 3vw, 2.4rem);
        line-height: 1;
        font-weight: 900;
        margin: 8px 0 10px;
    }

    .tm-stat-meta {
        color: #cbd5e1;
        font-size: 0.92rem;
        margin: 0;
    }

    .tm-stat-mini {
        margin-top: 15px;
        height: 34px;
        opacity: 0.95;
    }

    .tm-mini-line {
        width: 100%;
        height: 34px;
    }

    .tm-chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 18px;
        margin-bottom: 22px;
    }

    .tm-chart-card {
        padding: 22px;
        min-height: 360px;
        position: relative;
        overflow: hidden;
    }

    .tm-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .tm-panel-title {
        color: #fff;
        font-size: 1.05rem;
        font-weight: 900;
        margin: 0;
    }

    .tm-panel-subtitle {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 4px 0 0;
    }

    .tm-badge-soft {
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.06);
        color: #e2e8f0;
        font-weight: 700;
        font-size: 0.85rem;
        border: 1px solid rgba(148, 163, 184, 0.14);
    }

    .tm-donut-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 280px;
    }

    .tm-donut {
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: conic-gradient(
            #22c55e 0 var(--completed-angle),
            #06b6d4 var(--completed-angle) calc(var(--completed-angle) + var(--pending-angle)),
            #f59e0b calc(var(--completed-angle) + var(--pending-angle)) 100%
        );
        position: relative;
        box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.08);
    }

    .tm-donut::after {
        content: '';
        position: absolute;
        inset: 34px;
        border-radius: 50%;
        background: rgba(8, 15, 28, 0.96);
        border: 1px solid rgba(148, 163, 184, 0.12);
    }

    .tm-donut-center {
        position: absolute;
        inset: 0;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        font-weight: 900;
        font-size: 2rem;
    }

    .tm-donut-center small {
        display: block;
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 700;
        margin-top: 6px;
    }

    .tm-legend {
        display: grid;
        gap: 10px;
        margin-top: 16px;
    }

    .tm-legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #cbd5e1;
        font-weight: 700;
        font-size: 0.92rem;
    }

    .tm-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .tm-bar-chart {
        height: 250px;
        display: flex;
        align-items: end;
        gap: 14px;
        padding: 18px 8px 8px;
        border-left: 1px solid rgba(148, 163, 184, 0.14);
        border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        margin-top: 10px;
    }

    .tm-bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        height: 100%;
        justify-content: end;
    }

    .tm-bar-stack {
        width: 28px;
        display: flex;
        flex-direction: column;
        justify-content: end;
        gap: 6px;
        align-items: center;
        height: 100%;
    }

    .tm-bar {
        width: 100%;
        border-radius: 12px 12px 4px 4px;
        min-height: 8px;
        box-shadow: 0 10px 16px rgba(0, 0, 0, 0.12);
    }

    .tm-bar.high { background: linear-gradient(180deg, #f43f5e, #ef4444); }
    .tm-bar.medium { background: linear-gradient(180deg, #f59e0b, #fbbf24); }
    .tm-bar.low { background: linear-gradient(180deg, #22c55e, #14b8a6); }

    .tm-line-chart {
        height: 250px;
        width: 100%;
        border-left: 1px solid rgba(148, 163, 184, 0.14);
        border-bottom: 1px solid rgba(148, 163, 184, 0.14);
    }

    .tm-recent-card {
        padding: 24px;
    }

    .tm-table {
        color: #e2e8f0;
        margin-bottom: 0;
    }

    .tm-table thead th {
        color: #cbd5e1;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom-color: rgba(148, 163, 184, 0.12) !important;
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .tm-table tbody td {
        color: #e2e8f0;
        border-top-color: rgba(148, 163, 184, 0.1);
        vertical-align: top;
        padding-top: 18px;
        padding-bottom: 18px;
    }

    .tm-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.82rem;
    }

    .tm-pill.high { background: rgba(239, 68, 68, 0.16); color: #fca5a5; }
    .tm-pill.medium { background: rgba(245, 158, 11, 0.16); color: #fcd34d; }
    .tm-pill.low { background: rgba(34, 197, 94, 0.16); color: #86efac; }
    .tm-pill.pending { background: rgba(249, 115, 22, 0.16); color: #fdba74; }
    .tm-pill.in-progress { background: rgba(37, 99, 235, 0.16); color: #93c5fd; }
    .tm-pill.completed { background: rgba(34, 197, 94, 0.16); color: #86efac; }

    .tm-task-desc {
        color: #94a3b8;
        margin: 0;
        max-width: 38rem;
    }

    .tm-task-date {
        color: #cbd5e1;
        white-space: nowrap;
    }

    .tm-empty-state {
        padding: 40px 18px;
        text-align: center;
        color: #cbd5e1;
    }

    .tm-topbar-info {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
    }

    .tm-topbar-pill {
        padding: 10px 14px;
        border-radius: 14px;
        background: rgba(15, 23, 42, 0.05);
        border: 1px solid rgba(15, 23, 42, 0.06);
        font-weight: 700;
        color: #0f172a;
    }

    .tm-avatar-sm {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        display: grid;
        place-items: center;
        color: #fff;
        font-weight: 800;
    }

    @media (max-width: 1399.98px) {
        .tm-stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .tm-chart-grid {
            grid-template-columns: 1fr 1fr;
        }

        .tm-chart-grid .tm-panel:last-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 991.98px) {
        .tm-dashboard {
            padding: 18px;
        }

        .tm-hero {
            grid-template-columns: 1fr;
        }

        .tm-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .tm-chart-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .tm-stats-grid {
            grid-template-columns: 1fr;
        }

        .tm-hero-panel,
        .tm-chart-card,
        .tm-recent-card,
        .tm-stat-card {
            border-radius: 22px;
        }
    }
</style>
@endsection


@section('topbar')
    <div class="tm-topbar-info d-none d-md-flex flex-grow-1 me-2">
        <div class="position-relative flex-grow-1" style="max-width: 420px;">
            <input type="search" class="form-control tm-topbar-pill ps-5" placeholder="Search tasks, priorities, or statuses">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
        </div>
        <div class="tm-topbar-pill d-none d-xl-inline-flex align-items-center gap-2">
            <i class="bi bi-calendar3"></i>
            {{ now()->format('M d, Y') }}
        </div>
    </div>

    <button type="button" class="btn btn-light rounded-circle position-relative" style="width:42px;height:42px;">
        <i class="bi bi-bell"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
    </button>

    <div class="d-flex align-items-center gap-2">
        <div class="tm-avatar-sm">DU</div>
        <div class="d-none d-md-block">
            <div class="fw-bold text-dark">Demo User</div>
            <div class="text-muted small">Project Manager</div>
        </div>
        <i class="bi bi-chevron-down text-secondary"></i>
    </div>
@endsection

@section('content')
@php
    $totalTasks = $totalTasks ?? 0;
    $completedTasks = $completedTasks ?? 0;
    $inProgressTasks = $inProgressTasks ?? 0;
    $pendingTasks = $pendingTasks ?? 0;
    $overdueTasks = $overdueTasks ?? 0;

    $statusTotal = max($completedTasks + $pendingTasks + $inProgressTasks, 1);
    $completedAngle = round(($completedTasks / $statusTotal) * 100, 2) . '%';
    $pendingAngle = round(($pendingTasks / $statusTotal) * 100, 2) . '%';
    $inProgressAngle = round(($inProgressTasks / $statusTotal) * 100, 2) . '%';

    $priorityLabels = $priorityLabels ?? ['High', 'Medium', 'Low'];
    $priorityCounts = $priorityCounts ?? [0, 0, 0];
    $weeklyLabels = $weeklyLabels ?? collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo)->format('D'))->all();
    $weeklyCompletion = $weeklyCompletion ?? array_fill(0, 7, 0);
    $recentTasks = $tasks ?? collect();
@endphp

<div class="tm-dashboard">
    <div class="tm-hero">
        <section class="tm-hero-panel">
            <div class="tm-kicker">
                <i class="bi bi-lightning-charge-fill"></i>
                Database driven overview
            </div>

            <h1 class="tm-hero-title">
                Premium TaskMaster <span>dashboard</span>
            </h1>

            <p class="tm-hero-subtitle">
                Real-time task metrics, overdue tracking, completion trends, and the latest 5 tasks from your database in one premium workspace.
            </p>

            <div class="tm-hero-actions">
                <a href="{{ route('tasks.index') }}" class="tm-gradient-btn">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Open Dashboard
                </a>
                <a href="{{ route('tasks.index') }}#recent-tasks" class="tm-outline-btn">
                    <i class="bi bi-list-check"></i>
                    View Recent Tasks
                </a>
            </div>
        </section>

        <aside class="tm-panel tm-feature-card">
            <h3>Task Overview</h3>
            <ul class="tm-feature-list">
                <li><i class="bi bi-check2-circle"></i> Total Tasks: {{ $totalTasks }}</li>
                <li><i class="bi bi-check2-circle"></i> Completed Tasks: {{ $completedTasks }}</li>
                <li><i class="bi bi-check2-circle"></i> In Progress Tasks: {{ $inProgressTasks }}</li>
                <li><i class="bi bi-check2-circle"></i> Pending Tasks: {{ $pendingTasks }}</li>
                <li><i class="bi bi-check2-circle"></i> Overdue Tasks: {{ $overdueTasks }}</li>
            </ul>
        </aside>
    </div>

    <section class="tm-stats-grid">
        <article class="tm-stat-card">
            <div class="tm-stat-head">
                <div>
                    <div class="tm-stat-label">Total Tasks</div>
                    <div class="tm-stat-value">{{ $totalTasks }}</div>
                    <p class="tm-stat-meta">All tasks stored in the database</p>
                </div>
                <div class="tm-stat-icon purple"><i class="bi bi-kanban"></i></div>
            </div>
            <div class="tm-stat-mini">
                <svg class="tm-mini-line" viewBox="0 0 120 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 25 C16 20, 24 29, 36 17 C48 5, 58 16, 71 12 C84 8, 96 18, 118 8" stroke="#c084fc" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </article>

        <article class="tm-stat-card">
            <div class="tm-stat-head">
                <div>
                    <div class="tm-stat-label">Completed Tasks</div>
                    <div class="tm-stat-value">{{ $completedTasks }}</div>
                    <p class="tm-stat-meta">Tasks marked as completed</p>
                </div>
                <div class="tm-stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
            </div>
            <div class="tm-stat-mini">
                <svg class="tm-mini-line" viewBox="0 0 120 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 26 C15 24, 22 15, 34 16 C47 17, 55 9, 70 10 C85 11, 97 5, 118 4" stroke="#22c55e" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </article>

        <article class="tm-stat-card">
            <div class="tm-stat-head">
                <div>
                    <div class="tm-stat-label">In Progress Tasks</div>
                    <div class="tm-stat-value">{{ $inProgressTasks }}</div>
                    <p class="tm-stat-meta">Tasks currently in motion</p>
                </div>
                <div class="tm-stat-icon cyan"><i class="bi bi-arrow-repeat"></i></div>
            </div>
            <div class="tm-stat-mini">
                <svg class="tm-mini-line" viewBox="0 0 120 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 24 C16 14, 26 26, 38 18 C50 10, 58 21, 73 14 C87 8, 98 15, 118 7" stroke="#22d3ee" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </article>

        <article class="tm-stat-card">
            <div class="tm-stat-head">
                <div>
                    <div class="tm-stat-label">Pending Tasks</div>
                    <div class="tm-stat-value">{{ $pendingTasks }}</div>
                    <p class="tm-stat-meta">Tasks waiting to be started</p>
                </div>
                <div class="tm-stat-icon orange"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="tm-stat-mini">
                <svg class="tm-mini-line" viewBox="0 0 120 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 8 C15 10, 25 26, 36 22 C49 17, 59 8, 71 18 C84 28, 96 25, 118 14" stroke="#f59e0b" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </article>

        <article class="tm-stat-card">
            <div class="tm-stat-head">
                <div>
                    <div class="tm-stat-label">Overdue Tasks</div>
                    <div class="tm-stat-value">{{ $overdueTasks }}</div>
                    <p class="tm-stat-meta">Past due and not completed</p>
                </div>
                <div class="tm-stat-icon red"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </div>
            <div class="tm-stat-mini">
                <svg class="tm-mini-line" viewBox="0 0 120 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 28 C15 13, 28 12, 38 24 C50 31, 61 14, 75 12 C88 9, 96 22, 118 18" stroke="#fb7185" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </article>
    </section>

    <section class="tm-chart-grid" id="analytics">
        <article class="tm-panel tm-chart-card">
            <div class="tm-panel-header">
                <div>
                    <h2 class="tm-panel-title">Task Status Overview</h2>
                    <p class="tm-panel-subtitle">Completed vs Pending vs In Progress</p>
                </div>
                <div class="tm-badge-soft">Pie chart</div>
            </div>

            <div class="tm-donut-wrap">
                <div class="position-relative" style="--completed-angle: {{ $completedAngle }}; --pending-angle: {{ $pendingAngle }}; --in-progress-angle: {{ $inProgressAngle }};">
                    <div class="tm-donut">
                        <div class="tm-donut-center">
                            {{ $totalTasks }}
                            <small>Total Tasks</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tm-legend">
                <div class="tm-legend-item"><span class="tm-dot" style="background:#22c55e;"></span>Completed {{ $completedTasks }}</div>
                <div class="tm-legend-item"><span class="tm-dot" style="background:#06b6d4;"></span>In Progress {{ $inProgressTasks }}</div>
                <div class="tm-legend-item"><span class="tm-dot" style="background:#f59e0b;"></span>Pending {{ $pendingTasks }}</div>
            </div>
        </article>

        <article class="tm-panel tm-chart-card">
            <div class="tm-panel-header">
                <div>
                    <h2 class="tm-panel-title">Tasks by Priority</h2>
                    <p class="tm-panel-subtitle">High, Medium, and Low priorities</p>
                </div>
                <div class="tm-badge-soft">Bar chart</div>
            </div>

            <div class="tm-bar-chart">
                @foreach ($priorityLabels as $index => $label)
                    @php
                        $maxPriority = max($priorityCounts ?: [1]);
                        $height = $maxPriority > 0 ? round(($priorityCounts[$index] / $maxPriority) * 100) : 0;
                        $barClass = match ($label) {
                            'High' => 'high',
                            'Medium' => 'medium',
                            default => 'low',
                        };
                    @endphp

                    <div class="tm-bar-col">
                        <div class="tm-bar-stack">
                            <div class="tm-bar {{ $barClass }}" style="height: {{ max($height, 8) }}%;"></div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold text-white">{{ $priorityCounts[$index] }}</div>
                            <div class="small text-secondary">{{ $label }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="tm-panel tm-chart-card">
            <div class="tm-panel-header">
                <div>
                    <h2 class="tm-panel-title">Weekly Completion</h2>
                    <p class="tm-panel-subtitle">Tasks completed in the last 7 days</p>
                </div>
                <div class="tm-badge-soft">Line chart</div>
            </div>

            <canvas id="weeklyCompletionChart" class="tm-line-chart"></canvas>
        </article>
    </section>

    <section class="tm-panel tm-recent-card" id="recent-tasks">
        <div class="tm-panel-header">
            <div>
                <h2 class="tm-panel-title">Recent Tasks</h2>
                <p class="tm-panel-subtitle">Latest 5 tasks from your database</p>
            </div>
            <div class="tm-badge-soft">{{ $recentTasks->count() }} items</div>
        </div>

        <div class="table-responsive">
            <table class="table tm-table align-middle">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentTasks as $task)
                        <tr>
                            <td>
                                <div class="fw-bold text-white">{{ $task->title }}</div>
                                <p class="tm-task-desc">{{ \Illuminate\Support\Str::limit($task->description ?: 'No description available.', 110) }}</p>
                            </td>
                            <td>
                                @php($priorityClass = strtolower($task->priority))
                                <span class="tm-pill {{ $priorityClass }}">{{ $task->priority }}</span>
                            </td>
                            <td>
                                @php($statusClass = \Illuminate\Support\Str::slug($task->status))
                                <span class="tm-pill {{ $statusClass }}">{{ $task->status }}</span>
                            </td>
                            <td class="tm-task-date">
                                {{ $task->due_date?->format('M d, Y') ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="tm-empty-state">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No tasks found yet.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js" integrity="sha512-Y51n9mtKTVBh3Jbx5pZSNNDMyY+yGe77DGtBPzRlgsf/YLCh13kSZ3JmfHGzYFCmOndraf0sQgfM654b7dJ3w==" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const weeklyCanvas = document.getElementById('weeklyCompletionChart');

        if (!weeklyCanvas) {
            return;
        }

        const weeklyLabels = @json($weeklyLabels);
        const weeklyCompletion = @json($weeklyCompletion);

        new Chart(weeklyCanvas, {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Completed Tasks',
                    data: weeklyCompletion,
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
                        labels: {
                            color: '#e2e8f0'
                        }
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

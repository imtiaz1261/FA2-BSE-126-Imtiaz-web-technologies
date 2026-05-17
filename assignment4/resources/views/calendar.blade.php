@extends('layouts.taskmaster')

@section('title', 'Calendar')

@section('styles')
<style>
    .calendar-wrap {
        padding: 30px;
        min-height: calc(100vh - 78px);
        background:
            radial-gradient(circle at top left, rgba(6, 182, 212, 0.16), transparent 24%),
            radial-gradient(circle at top right, rgba(124, 58, 237, 0.14), transparent 26%),
            linear-gradient(160deg, rgba(7, 17, 31, 0.98), rgba(11, 23, 48, 0.96));
    }

    .calendar-hero {
        margin-bottom: 24px;
    }

    .calendar-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(6, 182, 212, 0.14);
        color: #67e8f9;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .calendar-title {
        color: #fff;
        font-size: clamp(2rem, 3vw, 3rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        margin: 0 0 10px;
    }

    .calendar-subtitle {
        color: #cbd5e1;
        font-size: 1.02rem;
        margin: 0;
    }

    .calendar-panel {
        border-radius: 30px;
        padding: 28px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
    }

    .calendar-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .calendar-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border-radius: 16px;
        padding: 12px 18px;
        font-weight: 800;
        color: #e2e8f0;
        text-decoration: none;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: rgba(255, 255, 255, 0.03);
    }

    .calendar-section {
        margin-bottom: 22px;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(6, 182, 212, 0.16);
        color: #67e8f9;
        font-weight: 900;
        letter-spacing: 0.03em;
        margin-bottom: 16px;
    }

    .state-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.82rem;
        margin-left: 10px;
    }

    .state-badge.overdue {
        background: rgba(239, 68, 68, 0.16);
        color: #fca5a5;
    }

    .state-badge.today {
        background: rgba(124, 58, 237, 0.16);
        color: #d8b4fe;
    }

    .state-badge.upcoming {
        background: rgba(6, 182, 212, 0.16);
        color: #67e8f9;
    }

    .calendar-grid {
        display: grid;
        gap: 16px;
    }

    .calendar-card {
        padding: 22px;
        border-radius: 24px;
        background: rgba(8, 15, 28, 0.72);
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 18px 40px rgba(2, 6, 23, 0.18);
        position: relative;
        overflow: hidden;
    }

    .calendar-card.overdue {
        border-color: rgba(239, 68, 68, 0.24);
        box-shadow: 0 18px 40px rgba(239, 68, 68, 0.08);
    }

    .calendar-card.today {
        border-color: rgba(124, 58, 237, 0.24);
        box-shadow: 0 18px 40px rgba(124, 58, 237, 0.08);
    }

    .calendar-card.upcoming {
        border-color: rgba(6, 182, 212, 0.18);
    }

    .calendar-card-header {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .calendar-task-title {
        color: #fff;
        font-size: 1.05rem;
        font-weight: 900;
        margin: 0;
    }

    .calendar-description {
        color: #cbd5e1;
        margin: 0 0 16px;
        line-height: 1.75;
    }

    .calendar-meta {
        display: grid;
        gap: 10px;
        margin-bottom: 16px;
    }

    .calendar-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(148, 163, 184, 0.1);
        color: #e2e8f0;
    }

    .calendar-label {
        color: #94a3b8;
        font-weight: 700;
    }

    .priority-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.82rem;
    }

    .priority-high { background: rgba(239, 68, 68, 0.16); color: #fca5a5; }
    .priority-medium { background: rgba(245, 158, 11, 0.16); color: #fcd34d; }
    .priority-low { background: rgba(34, 197, 94, 0.16); color: #86efac; }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.82rem;
    }

    .status-pending { background: rgba(245, 158, 11, 0.16); color: #fcd34d; }
    .status-in-progress { background: rgba(6, 182, 212, 0.16); color: #67e8f9; }
    .status-completed { background: rgba(34, 197, 94, 0.16); color: #86efac; }

    .calendar-empty {
        padding: 70px 22px;
        text-align: center;
        color: #cbd5e1;
        border-radius: 28px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
    }

    .calendar-empty i {
        font-size: 3rem;
        color: #67e8f9;
        margin-bottom: 14px;
    }

    .calendar-units {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .unit-chip {
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

    @media (max-width: 991.98px) {
        .calendar-wrap {
            padding: 18px;
        }
    }
</style>
@endsection

@section('content')
<div class="calendar-wrap">
    <div class="calendar-hero">
        <div class="calendar-kicker">
            <i class="bi bi-calendar3"></i>
            Calendar
        </div>

        <h1 class="calendar-title">Calendar</h1>
        <p class="calendar-subtitle">Tasks organized by due date.</p>
    </div>

    <div class="calendar-toolbar">
        <a href="{{ route('tasks.index') }}" class="calendar-back-btn">
            <i class="bi bi-arrow-left"></i>
            Back to My Tasks
        </a>

        <div class="calendar-units">
            <span class="unit-chip"><span class="dot" style="width:10px;height:10px;border-radius:50%;background:#67e8f9;"></span> Due Date</span>
            <span class="unit-chip"><span class="dot" style="width:10px;height:10px;border-radius:50%;background:#fcd34d;"></span> Priority</span>
            <span class="unit-chip"><span class="dot" style="width:10px;height:10px;border-radius:50%;background:#fca5a5;"></span> Overdue</span>
            <span class="unit-chip"><span class="dot" style="width:10px;height:10px;border-radius:50%;background:#d8b4fe;"></span> Today</span>
        </div>
    </div>

    <div class="calendar-panel">
        @if ($taskGroups->isEmpty())
            <div class="calendar-empty">
                <i class="bi bi-inbox"></i>
                <h2 class="h4 text-white fw-bold mb-2">No tasks available.</h2>
                <p class="mb-0">Add tasks to see them organized by due date here.</p>
            </div>
        @else
            <div class="calendar-grid">
                @foreach ($taskGroups as $group)
                    @php
                        $date = $group['date'];
                        $state = $group['state'];
                        $tasks = $group['tasks'];
                        $badgeLabel = $date ? $date->format('l, M d, Y') : 'Unscheduled';
                        $stateLabel = ucfirst($state);
                    @endphp

                    <section class="calendar-section">
                        <div class="d-flex align-items-center flex-wrap mb-3">
                            <div class="date-badge">
                                <i class="bi bi-calendar2-week"></i>
                                {{ $badgeLabel }}
                            </div>
                            <span class="state-badge {{ $state }}">
                                <i class="bi bi-{{ $state === 'overdue' ? 'exclamation-triangle-fill' : ($state === 'today' ? 'calendar2-check-fill' : 'arrow-right-circle-fill') }}"></i>
                                {{ $stateLabel }}
                            </span>
                        </div>

                        <div class="calendar-grid">
                            @foreach ($tasks as $task)
                                @php
                                    $priorityClass = strtolower($task->priority ?? 'medium');
                                    $statusClass = \Illuminate\Support\Str::slug($task->status);
                                @endphp

                                <article class="calendar-card {{ $state }}">
                                    <div class="calendar-card-header">
                                        <div>
                                            <h2 class="calendar-task-title">{{ $task->title }}</h2>
                                        </div>
                                        <span class="priority-pill {{ $priorityClass }}">{{ $task->priority ?? 'Medium' }}</span>
                                    </div>

                                    <p class="calendar-description">
                                        {{ $task->description ?: 'No description available.' }}
                                    </p>

                                    <div class="calendar-meta">
                                        <div class="calendar-row">
                                            <span class="calendar-label">Due Date</span>
                                            <span>{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</span>
                                        </div>
                                        <div class="calendar-row">
                                            <span class="calendar-label">Priority</span>
                                            <span>{{ $task->priority ?? 'N/A' }}</span>
                                        </div>
                                        <div class="calendar-row">
                                            <span class="calendar-label">Status</span>
                                            <span class="status-pill {{ $statusClass }}">{{ $task->status }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

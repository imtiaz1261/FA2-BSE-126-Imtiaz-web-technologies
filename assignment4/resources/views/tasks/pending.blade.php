@extends('layouts.taskmaster')

@section('title', 'Pending Tasks')

@section('styles')
<style>
    .pending-wrap {
        padding: 30px;
        min-height: calc(100vh - 78px);
        background:
            radial-gradient(circle at top left, rgba(245, 158, 11, 0.16), transparent 26%),
            radial-gradient(circle at top right, rgba(6, 182, 212, 0.12), transparent 24%),
            linear-gradient(160deg, rgba(7, 17, 31, 0.98), rgba(11, 23, 48, 0.96));
    }

    .pending-hero {
        margin-bottom: 24px;
    }

    .pending-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(245, 158, 11, 0.14);
        color: #fcd34d;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .pending-title {
        color: #fff;
        font-size: clamp(2rem, 3vw, 3rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        margin: 0 0 10px;
    }

    .pending-subtitle {
        color: #cbd5e1;
        font-size: 1.02rem;
        margin: 0;
    }

    .pending-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .pending-create-btn,
    .pending-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border-radius: 16px;
        padding: 12px 18px;
        font-weight: 800;
        text-decoration: none;
    }

    .pending-create-btn {
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        box-shadow: 0 18px 36px rgba(124, 58, 237, 0.22);
    }

    .pending-back-btn {
        color: #e2e8f0;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: rgba(255, 255, 255, 0.03);
    }

    .pending-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(245, 158, 11, 0.16);
        color: #fcd34d;
        font-weight: 800;
        font-size: 0.82rem;
    }

    .pending-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .pending-card {
        border-radius: 28px;
        padding: 24px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
        position: relative;
        overflow: hidden;
    }

    .pending-card::after {
        content: '';
        position: absolute;
        inset: auto -24px -30px auto;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.14), transparent 70%);
        pointer-events: none;
    }

    .pending-card-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 18px;
    }

    .pending-card-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 900;
        margin: 0;
    }

    .pending-description {
        color: #cbd5e1;
        margin: 0 0 18px;
        line-height: 1.75;
    }

    .pending-meta {
        display: grid;
        gap: 12px;
        margin-bottom: 18px;
    }

    .meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(148, 163, 184, 0.1);
        color: #e2e8f0;
    }

    .meta-label {
        color: #94a3b8;
        font-weight: 700;
    }

    .pending-badge-card {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(245, 158, 11, 0.16);
        color: #fcd34d;
        font-weight: 800;
        font-size: 0.82rem;
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

    .task-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .task-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 14px;
        padding: 11px 14px;
        font-weight: 800;
        text-decoration: none;
        border: 0;
    }

    .task-edit-btn {
        color: #fff;
        background: rgba(59, 130, 246, 0.18);
        border: 1px solid rgba(59, 130, 246, 0.18);
    }

    .task-complete-btn {
        color: #052e16;
        background: linear-gradient(135deg, #facc15, #fb923c);
        box-shadow: 0 14px 28px rgba(250, 204, 21, 0.18);
    }

    .task-complete-btn:hover,
    .pending-create-btn:hover,
    .pending-back-btn:hover,
    .task-edit-btn:hover {
        color: inherit;
    }

    .empty-state {
        padding: 70px 22px;
        text-align: center;
        color: #cbd5e1;
        border-radius: 28px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
    }

    .empty-state i {
        font-size: 3rem;
        color: #f59e0b;
        margin-bottom: 14px;
    }

    @media (max-width: 991.98px) {
        .pending-wrap {
            padding: 18px;
        }

        .pending-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="pending-wrap">
    <div class="pending-hero">
        <div class="pending-kicker">
            <i class="bi bi-hourglass-split"></i>
            Pending Tasks
        </div>

        <h1 class="pending-title">Pending Tasks</h1>
        <p class="pending-subtitle">Tasks that still need your attention are listed below.</p>
    </div>

    <div class="pending-toolbar">
        <a href="{{ route('tasks.index') }}" class="pending-back-btn">
            <i class="bi bi-arrow-left"></i>
            Back to My Tasks
        </a>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('tasks.index') }}#add-task" class="pending-create-btn">
                <i class="bi bi-plus-circle"></i>
                Create Task
            </a>
            <span class="pending-badge">
                <i class="bi bi-clock-history"></i>
                {{ $pendingTasks->count() }} Pending
            </span>
        </div>
    </div>

    @if ($pendingTasks->isEmpty())
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h2 class="h4 text-white fw-bold mb-2">No pending tasks found.</h2>
            <p class="mb-0">Create a task to start tracking your next priority item.</p>
        </div>
    @else
        <div class="pending-grid">
            @foreach ($pendingTasks as $task)
                @php
                    $priorityClass = strtolower($task->priority ?? 'medium');
                @endphp

                <article class="pending-card">
                    <div class="pending-card-top">
                        <div>
                            <h2 class="pending-card-title">{{ $task->title }}</h2>
                            <div class="mt-2">
                                <span class="pending-badge-card">
                                    <i class="bi bi-hourglass-split"></i>
                                    Pending
                                </span>
                            </div>
                        </div>

                        <span class="priority-pill {{ $priorityClass }}">{{ $task->priority ?? 'Medium' }}</span>
                    </div>

                    <p class="pending-description">
                        {{ $task->description ?: 'No description available.' }}
                    </p>

                    <div class="pending-meta">
                        <div class="meta-row">
                            <span class="meta-label">Category</span>
                            <span>{{ $task->category ?? 'N/A' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Due Date</span>
                            <span>{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Status</span>
                            <span>Pending</span>
                        </div>
                    </div>

                    <div class="task-actions">
                        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="task-action-btn task-edit-btn">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </a>

                        <form action="{{ route('tasks.update', ['id' => $task->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $task->title }}">
                            <input type="hidden" name="description" value="{{ $task->description }}">
                            <input type="hidden" name="category" value="{{ $task->category ?? '' }}">
                            <input type="hidden" name="priority" value="{{ $task->priority }}">
                            <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                            <input type="hidden" name="status" value="Completed">
                            <button type="submit" class="task-action-btn task-complete-btn">
                                <i class="bi bi-check2-circle"></i>
                                Mark Completed
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.taskmaster')

@section('title', 'Completed Tasks')

@section('styles')
<style>
    .completed-wrap {
        padding: 30px;
        min-height: calc(100vh - 78px);
        background:
            radial-gradient(circle at top left, rgba(34, 197, 94, 0.16), transparent 26%),
            radial-gradient(circle at top right, rgba(6, 182, 212, 0.12), transparent 24%),
            linear-gradient(160deg, rgba(7, 17, 31, 0.98), rgba(11, 23, 48, 0.96));
    }

    .completed-hero {
        margin-bottom: 24px;
    }

    .completed-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.14);
        color: #86efac;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .completed-title {
        color: #fff;
        font-size: clamp(2rem, 3vw, 3rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        margin: 0 0 10px;
    }

    .completed-subtitle {
        color: #cbd5e1;
        font-size: 1.02rem;
        margin: 0;
    }

    .completed-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .completed-back-btn {
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

    .completed-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .completed-card {
        border-radius: 28px;
        padding: 24px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
        position: relative;
        overflow: hidden;
    }

    .completed-card::after {
        content: '';
        position: absolute;
        inset: auto -24px -30px auto;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(34, 197, 94, 0.14), transparent 70%);
        pointer-events: none;
    }

    .completed-card-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 18px;
    }

    .completed-card-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 900;
        margin: 0;
        text-decoration: line-through;
        text-decoration-thickness: 2px;
        text-decoration-color: rgba(255, 255, 255, 0.55);
    }

    .completed-description {
        color: #cbd5e1;
        margin: 0 0 18px;
        line-height: 1.75;
    }

    .completed-meta {
        display: grid;
        gap: 12px;
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

    .completed-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.16);
        color: #86efac;
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
        color: #22c55e;
        margin-bottom: 14px;
    }

    @media (max-width: 991.98px) {
        .completed-wrap {
            padding: 18px;
        }

        .completed-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection


@section('content')
<div class="completed-wrap">
    <div class="completed-hero">
        <div class="completed-kicker">
            <i class="bi bi-check2-circle"></i>
            Completed Tasks
        </div>

        <h1 class="completed-title">Completed Tasks</h1>
        <p class="completed-subtitle">A focused view of finished work from your TaskMaster database.</p>
    </div>

    <div class="completed-toolbar">
        <a href="{{ route('tasks.index') }}" class="completed-back-btn">
            <i class="bi bi-arrow-left"></i>
            Back to My Tasks
        </a>

        <div class="completed-badge">
            <i class="bi bi-check2"></i>
            {{ $completedTasks->count() }} Completed
        </div>
    </div>

    @if ($completedTasks->isEmpty())
        <div class="empty-state">
            <i class="bi bi-emoji-smile"></i>
            <h2 class="h4 text-white fw-bold mb-2">No completed tasks yet.</h2>
            <p class="mb-0">Completed items will appear here once you finish them.</p>
        </div>
    @else
        <div class="completed-grid">
            @foreach ($completedTasks as $task)
                @php
                    $priorityClass = strtolower($task->priority ?? 'medium');
                @endphp

                <article class="completed-card">
                    <div class="completed-card-top">
                        <div>
                            <h2 class="completed-card-title">{{ $task->title }}</h2>
                            <div class="mt-2">
                                <span class="completed-badge">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Completed
                                </span>
                            </div>
                        </div>

                        <span class="priority-pill {{ $priorityClass }}">{{ $task->priority ?? 'Medium' }}</span>
                    </div>

                    <p class="completed-description">
                        {{ $task->description ?: 'No description available.' }}
                    </p>

                    <div class="completed-meta">
                        <div class="meta-row">
                            <span class="meta-label">Category</span>
                            <span>{{ $task->category ?? 'N/A' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Priority</span>
                            <span>{{ $task->priority ?? 'N/A' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Due Date</span>
                            <span>{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection

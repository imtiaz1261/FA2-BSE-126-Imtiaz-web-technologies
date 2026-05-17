@extends('layouts.taskmaster')

@section('title', 'Edit Task')

@section('styles')
<style>
    .task-create-wrap {
        padding: 30px;
        min-height: calc(100vh - 78px);
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.22), transparent 26%),
            radial-gradient(circle at top right, rgba(6, 182, 212, 0.18), transparent 28%),
            linear-gradient(160deg, rgba(7, 17, 31, 0.98), rgba(11, 23, 48, 0.96));
    }

    .task-create-card {
        width: 100%;
        max-width: 920px;
        border-radius: 30px;
        padding: 34px;
        background: rgba(15, 23, 42, 0.58);
        border: 1px solid rgba(148, 163, 184, 0.16);
        backdrop-filter: blur(24px);
        box-shadow: 0 28px 70px rgba(2, 6, 23, 0.28);
    }

    .task-create-hero {
        margin-bottom: 26px;
    }

    .task-create-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(124, 58, 237, 0.16);
        color: #c4b5fd;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .task-create-title {
        color: #fff;
        font-size: clamp(2rem, 3vw, 3rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        margin: 0 0 10px;
    }

    .task-create-subtitle {
        color: #cbd5e1;
        font-size: 1.02rem;
        margin: 0;
        line-height: 1.7;
    }

    .task-form-shell {
        background: rgba(8, 15, 28, 0.72);
        border: 1px solid rgba(148, 163, 184, 0.14);
        border-radius: 28px;
        padding: 26px;
    }

    .task-form-label {
        color: #e2e8f0;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .task-form-control,
    .task-form-select,
    .task-form-textarea {
        background: #0b1220 !important;
        color: #e2e8f0 !important;
        border: 1px solid rgba(148, 163, 184, 0.18) !important;
        border-radius: 16px !important;
        padding: 14px 16px !important;
        min-height: 54px;
        box-shadow: none !important;
    }

    .task-form-textarea {
        min-height: 140px;
        resize: vertical;
    }

    .task-form-control::placeholder,
    .task-form-textarea::placeholder {
        color: #64748b;
    }

    .task-form-control:focus,
    .task-form-select:focus,
    .task-form-textarea:focus {
        border-color: rgba(34, 211, 238, 0.85) !important;
        box-shadow: 0 0 0 0.2rem rgba(34, 211, 238, 0.12) !important;
    }

    .task-error {
        color: #fca5a5;
        font-size: 0.9rem;
        margin-top: 8px;
    }

    .task-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .task-back-btn,
    .task-submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 16px;
        padding: 13px 20px;
        font-weight: 800;
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .task-back-btn {
        color: #e2e8f0;
        border: 1px solid rgba(148, 163, 184, 0.18);
        background: rgba(255, 255, 255, 0.03);
    }

    .task-submit-btn {
        border: 0;
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        box-shadow: 0 18px 36px rgba(124, 58, 237, 0.22);
    }

    .task-back-btn:hover,
    .task-submit-btn:hover {
        transform: translateY(-2px);
    }

    .task-illustration {
        border-radius: 24px;
        padding: 22px;
        background:
            radial-gradient(circle at top right, rgba(6, 182, 212, 0.18), transparent 32%),
            linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        border: 1px solid rgba(148, 163, 184, 0.12);
        min-height: 100%;
    }

    .task-illustration-card {
        background: rgba(15, 23, 42, 0.64);
        border: 1px solid rgba(148, 163, 184, 0.14);
        border-radius: 22px;
        padding: 18px;
    }

    .task-illustration-badge {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        color: #fff;
        font-size: 1.55rem;
        margin-bottom: 16px;
        box-shadow: 0 16px 30px rgba(6, 182, 212, 0.18);
    }

    .task-illustration-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .task-illustration-text {
        color: #cbd5e1;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .task-sample-list {
        display: grid;
        gap: 10px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .task-sample-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #e2e8f0;
        padding: 10px 12px;
        border-radius: 14px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(148, 163, 184, 0.10);
    }

    .task-sample-list i {
        color: #22d3ee;
    }

    @media (max-width: 991.98px) {
        .task-create-wrap {
            padding: 18px;
        }

        .task-create-card {
            padding: 22px;
            border-radius: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="task-create-wrap">
    <div class="task-create-card">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="task-create-hero">
                    <div class="task-create-kicker">
                        <i class="bi bi-pencil-square"></i>
                        Update Task
                    </div>

                    <h1 class="task-create-title">Edit Task</h1>
                    <p class="task-create-subtitle">Update your task information.</p>
                </div>

                <div class="task-form-shell">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="task-form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="form-control task-form-control @error('title') is-invalid @enderror" placeholder="Enter task title">
                            @error('title')
                                <div class="task-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="task-form-label">Description</label>
                            <textarea name="description" id="description" class="form-control task-form-textarea @error('description') is-invalid @enderror" placeholder="Write task details">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="task-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category" class="task-form-label">Category</label>
                            <input type="text" name="category" id="category" value="{{ old('category', $task->category ?? '') }}" class="form-control task-form-control @error('category') is-invalid @enderror" placeholder="e.g. Work, Personal, Study">
                            @error('category')
                                <div class="task-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="priority" class="task-form-label">Priority</label>
                                <select name="priority" id="priority" class="form-select task-form-select @error('priority') is-invalid @enderror">
                                    <option value="">Select priority</option>
                                    <option value="Low" @selected(old('priority', $task->priority) === 'Low')>Low</option>
                                    <option value="Medium" @selected(old('priority', $task->priority) === 'Medium')>Medium</option>
                                    <option value="High" @selected(old('priority', $task->priority) === 'High')>High</option>
                                </select>
                                @error('priority')
                                    <div class="task-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="task-form-label">Status</label>
                                <select name="status" id="status" class="form-select task-form-select @error('status') is-invalid @enderror">
                                    <option value="">Select status</option>
                                    <option value="Pending" @selected(old('status', $task->status) === 'Pending')>Pending</option>
                                    <option value="In Progress" @selected(old('status', $task->status) === 'In Progress')>In Progress</option>
                                    <option value="Completed" @selected(old('status', $task->status) === 'Completed')>Completed</option>
                                </select>
                                @error('status')
                                    <div class="task-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="due_date" class="task-form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" class="form-control task-form-control @error('due_date') is-invalid @enderror">
                            @error('due_date')
                                <div class="task-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="task-actions">
                            <a href="{{ route('tasks.index') }}" class="task-back-btn">
                                <i class="bi bi-arrow-left"></i>
                                Back to Tasks
                            </a>

                            <button type="submit" class="task-submit-btn">
                                <i class="bi bi-check2-circle"></i>
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="task-illustration h-100">
                    <div class="task-illustration-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="task-illustration-badge">
                                <i class="bi bi-journal-check"></i>
                            </div>
                            <div class="task-illustration-title">Refine Your Task</div>
                            <div class="task-illustration-text">
                                Keep your workflow polished by updating priorities, status, and deadlines inside a premium glass workspace.
                            </div>
                        </div>

                        <ul class="task-sample-list">
                            <li><i class="bi bi-check2-circle"></i> Preserve existing values with old() defaults</li>
                            <li><i class="bi bi-check2-circle"></i> Keep validation feedback visible under each field</li>
                            <li><i class="bi bi-check2-circle"></i> Match the same premium design as the create page</li>
                            <li><i class="bi bi-check2-circle"></i> Responsive on desktop, tablet, and mobile</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


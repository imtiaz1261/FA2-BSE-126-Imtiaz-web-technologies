@extends('layouts.taskmaster')

@section('title', 'Settings & Profile')

@section('styles')
<style>
    .settings-wrap {
        padding: 30px;
        min-height: calc(100vh - 78px);
        background:
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.18), transparent 24%),
            radial-gradient(circle at top right, rgba(6, 182, 212, 0.18), transparent 26%),
            linear-gradient(160deg, rgba(8, 15, 33, 0.98), rgba(15, 23, 42, 0.96));
    }

    .settings-hero {
        margin-bottom: 24px;
    }

    .settings-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(34, 211, 238, 0.12);
        color: #67e8f9;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .settings-title {
        color: #fff;
        font-size: clamp(2rem, 3vw, 3rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        margin: 0 0 10px;
    }

    .settings-subtitle {
        color: #cbd5e1;
        font-size: 1.02rem;
        margin: 0;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 1.45fr 0.95fr;
        gap: 18px;
    }

    .glass-card {
        border-radius: 30px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(148, 163, 184, 0.14);
        backdrop-filter: blur(22px);
        box-shadow: 0 24px 56px rgba(2, 6, 23, 0.22);
        overflow: hidden;
    }

    .profile-card {
        padding: 28px;
    }

    .profile-top {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 22px;
    }

    .profile-avatar {
        width: 84px;
        height: 84px;
        border-radius: 26px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        color: #fff;
        font-weight: 900;
        font-size: 1.55rem;
        letter-spacing: 0.05em;
        box-shadow: 0 20px 36px rgba(124, 58, 237, 0.24);
        flex-shrink: 0;
    }

    .profile-name {
        color: #fff;
        font-size: clamp(1.6rem, 2vw, 2.15rem);
        font-weight: 900;
        margin: 0;
    }

    .profile-email {
        color: #cbd5e1;
        margin: 6px 0 0;
        font-weight: 600;
    }

    .status-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.82rem;
        border: 1px solid rgba(148, 163, 184, 0.14);
    }

    .status-pill.active {
        color: #86efac;
        background: rgba(34, 197, 94, 0.12);
    }

    .status-pill.theme {
        color: #bfdbfe;
        background: rgba(37, 99, 235, 0.12);
    }

    .settings-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 24px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 18px;
        border-radius: 18px;
        font-weight: 800;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        border: 0;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .action-btn.edit {
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        box-shadow: 0 18px 36px rgba(124, 58, 237, 0.2);
    }

    .action-btn.password {
        color: #fff;
        background: linear-gradient(135deg, #ec4899, #2563eb);
        box-shadow: 0 18px 36px rgba(37, 99, 235, 0.18);
    }

    .action-btn.logout {
        color: #fecaca;
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(248, 113, 113, 0.18);
    }

    .stats-card {
        padding: 22px;
        display: grid;
        gap: 14px;
        align-content: start;
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

    .stats-list {
        display: grid;
        gap: 12px;
    }

    .stat-row {
        padding: 14px 16px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(148, 163, 184, 0.12);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .stat-label {
        color: #cbd5e1;
        font-weight: 700;
    }

    .stat-value {
        color: #fff;
        font-weight: 900;
        font-size: 1.02rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-top: 18px;
    }

    .summary-card {
        padding: 20px;
        min-height: 130px;
    }

    .summary-label {
        color: #bfdbfe;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.77rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .summary-value {
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
        line-height: 1;
        margin: 0 0 8px;
    }

    .summary-meta {
        color: #cbd5e1;
        margin: 0;
        font-size: 0.92rem;
    }

    @media (max-width: 1199.98px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 991.98px) {
        .settings-wrap {
            padding: 18px;
        }

        .settings-actions,
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $displayName = $user?->name ?? 'Demo User';
    $displayEmail = $user?->email ?? 'demo@taskmaster.app';
    $initials = collect(explode(' ', $displayName))
        ->filter()
        ->take(2)
        ->map(function (string $part): string {
            return strtoupper(substr($part, 0, 1));
        })
        ->implode('');

    if ($initials === '') {
        $initials = 'TM';
    }
@endphp

<div class="settings-wrap">
    <div class="settings-hero">
        <div class="settings-kicker">
            <i class="bi bi-person-badge-fill"></i>
            Profile Settings
        </div>

        <h1 class="settings-title">Settings & Profile</h1>
        <p class="settings-subtitle">Review your account details, task statistics, and premium TaskMaster preferences.</p>
    </div>

    <div class="settings-grid">
        <section class="glass-card profile-card" id="profile-card">
            <div class="profile-top">
                <div class="profile-avatar">{{ $initials }}</div>
                <div>
                    <h2 class="profile-name">{{ $displayName }}</h2>
                    <p class="profile-email">{{ $displayEmail }}</p>
                </div>
            </div>

            <div class="status-badges">
                <span class="status-pill active">
                    <i class="bi bi-shield-check"></i>
                    Account status: Active
                </span>
                <span class="status-pill theme">
                    <i class="bi bi-moon-stars-fill"></i>
                    Theme: Premium Dark Gradient
                </span>
            </div>

            <div class="summary-grid">
                <div class="glass-card summary-card">
                    <div class="summary-label">Total Tasks</div>
                    <div class="summary-value">{{ $totalTasksCreated }}</div>
                    <p class="summary-meta">Tasks created in the system</p>
                </div>

                <div class="glass-card summary-card">
                    <div class="summary-label">Completed</div>
                    <div class="summary-value">{{ $completedTasksCount }}</div>
                    <p class="summary-meta">Completed task count</p>
                </div>

                <div class="glass-card summary-card">
                    <div class="summary-label">Pending</div>
                    <div class="summary-value">{{ $pendingTasksCount }}</div>
                    <p class="summary-meta">Pending task count</p>
                </div>
            </div>

            <div class="settings-actions">
                <a href="#profile-card" class="action-btn edit">
                    <i class="bi bi-pencil-square"></i>
                    Edit profile
                </a>

                <a href="#security-card" class="action-btn password">
                    <i class="bi bi-key-fill"></i>
                    Change password
                </a>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="action-btn logout w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
        </section>

        <aside class="glass-card stats-card" id="security-card">
            <div>
                <h2 class="section-title">Account Overview</h2>
                <p class="section-subtitle">Fast access to the current profile and task summary.</p>
            </div>

            <div class="stats-list">
                <div class="stat-row">
                    <span class="stat-label">Name</span>
                    <span class="stat-value text-end">{{ $displayName }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Email</span>
                    <span class="stat-value text-end">{{ $displayEmail }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Status</span>
                    <span class="stat-value text-end">Active</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Theme</span>
                    <span class="stat-value text-end">Premium Dark Gradient</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Task completion vibe</span>
                    <span class="stat-value text-end">Clean and focused</span>
                </div>
            </div>

            <div class="glass-card p-3 mt-1" style="background: rgba(255,255,255,0.04); border-radius: 22px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="profile-avatar" style="width:64px;height:64px;border-radius:20px;font-size:1.15rem;">{{ $initials }}</div>
                    <div>
                        <div class="text-white fw-black fs-5">Ready for the next sprint</div>
                        <div class="text-secondary">Your profile is set up with a premium TaskMaster look.</div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

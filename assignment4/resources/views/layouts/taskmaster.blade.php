<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskMaster')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">

    <style>
        :root {
            --tm-bg: #07111f;
            --tm-bg-soft: #0d1a31;
            --tm-bg-panel: #f5f7fb;
            --tm-sidebar: linear-gradient(180deg, #07111f 0%, #0b1730 45%, #081220 100%);
            --tm-accent: linear-gradient(135deg, #7c3aed 0%, #06b6d4 100%);
            --tm-text: #dbe5f6;
            --tm-muted: rgba(219, 229, 246, 0.72);
            --tm-border: rgba(148, 163, 184, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            min-height: 100%;
        }

        body {
            margin: 0;
            background: var(--tm-bg-panel);
            color: #0f172a;
            font-family: 'Segoe UI', sans-serif;
        }

        .tm-shell {
            min-height: 100vh;
            display: flex;
            background: var(--tm-bg-panel);
        }

        .tm-sidebar {
            width: 286px;
            min-width: 286px;
            position: fixed;
            inset: 0 auto 0 0;
            background: var(--tm-sidebar);
            color: var(--tm-text);
            padding: 28px 22px 24px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            z-index: 1030;
        }

        .tm-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 8px 10px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 18px;
        }

        .tm-brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: var(--tm-accent);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 1.5rem;
            box-shadow: 0 16px 32px rgba(124, 58, 237, 0.24);
            flex-shrink: 0;
        }

        .tm-brand-title {
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.03em;
            color: #fff;
            margin: 0;
        }

        .tm-brand-subtitle {
            color: var(--tm-muted);
            font-size: 0.92rem;
            margin: 4px 0 0;
        }

        .tm-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding-top: 8px;
            overflow-y: auto;
            flex: 1 1 auto;
        }

        .tm-nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            border-radius: 16px;
            color: var(--tm-text);
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
            border: 1px solid transparent;
        }

        .tm-nav-link i {
            font-size: 1.15rem;
            width: 20px;
            text-align: center;
            color: #fff;
            flex-shrink: 0;
        }

        .tm-nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
            color: #fff;
        }

        .tm-nav-link.active {
            background: var(--tm-accent);
            color: #fff;
            box-shadow: 0 16px 28px rgba(6, 182, 212, 0.18);
        }

        .tm-nav-link.active i {
            color: #fff;
        }

        .tm-sidebar-footer {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tm-profile-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tm-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
            box-shadow: 0 12px 24px rgba(6, 182, 212, 0.2);
        }

        .tm-profile-name {
            color: #fff;
            font-weight: 800;
            margin: 0;
            line-height: 1.15;
        }

        .tm-profile-role {
            color: var(--tm-muted);
            margin: 4px 0 0;
            font-size: 0.88rem;
        }

        .tm-sidebar-upgrade {
            margin-top: 16px;
            border-radius: 22px;
            padding: 18px;
            background:
                radial-gradient(circle at top right, rgba(6, 182, 212, 0.24), transparent 35%),
                radial-gradient(circle at bottom left, rgba(124, 58, 237, 0.22), transparent 32%),
                rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
        }

        .tm-upgrade-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .tm-rocket {
            font-size: 3rem;
            line-height: 1;
            margin: 14px 0 10px;
        }

        .tm-upgrade-title {
            color: #fff;
            font-size: 1.02rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .tm-upgrade-text {
            color: var(--tm-muted);
            font-size: 0.88rem;
            margin-bottom: 14px;
        }

        .tm-upgrade-btn {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 12px 16px;
            color: #fff;
            font-weight: 800;
            background: var(--tm-accent);
            box-shadow: 0 16px 30px rgba(124, 58, 237, 0.24);
        }

        .tm-main {
            flex: 1;
            margin-left: 286px;
            min-width: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .tm-topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            height: 78px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 0 22px;
        }

        .tm-mobile-toggle {
            display: none;
            border: 0;
            background: transparent;
            font-size: 1.5rem;
            color: #0f172a;
            padding: 0.35rem 0.45rem;
            border-radius: 10px;
        }

        .tm-content {
            flex: 1;
            padding: 28px;
        }

        .tm-page-card {
            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .tm-alert-wrap {
            padding: 28px 28px 0;
        }

        .tm-offcanvas {
            display: none;
        }

        @media (max-width: 991.98px) {
            .tm-sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .tm-shell.is-sidebar-open .tm-sidebar {
                transform: translateX(0);
            }

            .tm-main {
                margin-left: 0;
            }

            .tm-mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .tm-topbar {
                padding-inline: 16px;
            }

            .tm-content {
                padding: 18px;
            }

            .tm-nav-link:hover {
                transform: none;
            }

            .tm-offcanvas {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(2, 6, 23, 0.55);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s ease;
                z-index: 1025;
            }

            .tm-shell.is-sidebar-open .tm-offcanvas {
                opacity: 1;
                pointer-events: auto;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
@php
    $sidebarUser = auth()->user();
    $sidebarName = $sidebarUser?->name ?? 'Demo User';
    $sidebarEmail = $sidebarUser?->email ?? 'demo@taskmaster.app';
    $sidebarInitials = collect(explode(' ', $sidebarName))
        ->filter()
        ->take(2)
        ->map(function (string $part): string {
            return strtoupper(substr($part, 0, 1));
        })
        ->implode('');

    if ($sidebarInitials === '') {
        $sidebarInitials = 'DU';
    }

    $taskMasterMenu = [
        ['label' => 'Home', 'icon' => 'bi-house-door-fill', 'route' => url('/')],
        ['label' => 'Dashboard', 'icon' => 'bi-grid-1x2-fill', 'route' => route('tasks.index')],
        ['label' => 'My Tasks', 'icon' => 'bi-list-check', 'route' => route('tasks.index')],
        ['label' => 'Create Task', 'icon' => 'bi-plus-circle-fill', 'route' => route('tasks.index') . '#add-task'],
        ['label' => 'Completed', 'icon' => 'bi-check2-circle', 'route' => route('tasks.index') . '#completed'],
        ['label' => 'Pending', 'icon' => 'bi-hourglass-split', 'route' => route('tasks.index') . '#pending'],
        ['label' => 'Calendar', 'icon' => 'bi-calendar3', 'route' => route('calendar')],
        ['label' => 'Analytics', 'icon' => 'bi-graph-up-arrow', 'route' => route('analytics')],
        ['label' => 'Settings', 'icon' => 'bi-gear', 'route' => route('settings')],
        ['label' => 'Logout', 'icon' => 'bi-box-arrow-right', 'route' => '#'],
    ];
@endphp

<div class="tm-shell" id="tmShell">
    <div class="tm-offcanvas" id="tmBackdrop" aria-hidden="true"></div>

    <aside class="tm-sidebar" aria-label="TaskMaster sidebar">
        <div class="tm-brand">
            <div class="tm-brand-mark">
                <i class="bi bi-check2"></i>
            </div>

            <div>
                <h1 class="tm-brand-title">TaskMaster</h1>
                <p class="tm-brand-subtitle">Organize. Focus. Achieve.</p>
            </div>
        </div>

        <nav class="tm-nav">
            @foreach ($taskMasterMenu as $item)
                @php
                    $isActive = request()->fullUrlIs($item['route']) || request()->url() === $item['route'] || ($item['label'] === 'Dashboard' && request()->routeIs('tasks.index'));
                @endphp

                <a href="{{ $item['route'] }}" class="tm-nav-link {{ $isActive ? 'active' : '' }}">
                    <i class="bi {{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="tm-sidebar-footer">
            <div class="tm-sidebar-upgrade">
                <div class="tm-upgrade-badge">
                    <i class="bi bi-stars"></i>
                    Premium Plan
                </div>

                <div class="tm-rocket">🚀</div>

                <div class="tm-upgrade-title">Unlock advanced productivity tools</div>
                <div class="tm-upgrade-text">Get smarter analytics, calendar insights, and team-ready task workflows.</div>
                <button type="button" class="tm-upgrade-btn">Upgrade Now</button>
            </div>

            <div class="tm-profile-card mt-3">
                <div class="tm-avatar">{{ $sidebarInitials }}</div>
                <div class="min-w-0">
                    <p class="tm-profile-name text-truncate">{{ $sidebarName }}</p>
                    <p class="tm-profile-role text-truncate">{{ $sidebarEmail }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="tm-main">
        <header class="tm-topbar">
            <button type="button" class="tm-mobile-toggle" id="tmSidebarToggle" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>

            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill text-bg-dark px-3 py-2 d-none d-md-inline-flex align-items-center gap-2" style="background:#0b1220 !important;">
                    <i class="bi bi-check2-circle"></i>
                    TaskMaster
                </span>
            </div>

            <div class="ms-auto d-flex align-items-center gap-3">
                @yield('topbar')
            </div>
        </header>

        <div class="tm-content">
            @if (session('success'))
                <div class="tm-alert-wrap">
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="tm-page-card">
                @yield('content')
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shell = document.getElementById('tmShell');
        const toggle = document.getElementById('tmSidebarToggle');
        const backdrop = document.getElementById('tmBackdrop');

        if (toggle && shell) {
            toggle.addEventListener('click', function () {
                shell.classList.toggle('is-sidebar-open');
            });
        }

        if (backdrop && shell) {
            backdrop.addEventListener('click', function () {
                shell.classList.remove('is-sidebar-open');
            });
        }
    });
</script>

@yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'To-Do List Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" integrity="sha384-OxWqvePLOm0AAoo759Ls7uD8ysM4N0fSXEE+QUY3pkVXBtkv6jkKNsPMC0KFMxWe" crossorigin="anonymous">
    <style>
        :root {
            --primary: #4f5bd5;
            --secondary: #3f51b5;
            --bg-light: #f4f7fb;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg-light);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-dark);
        }

        .navbar-custom {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .navbar-brand,
        .nav-link {
            color: #ffffff !important;
        }

        .nav-link {
            position: relative;
            font-weight: 500;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -0.25rem;
            width: 0;
            height: 2px;
            background: #ffffff;
            transition: width 0.2s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .page-title {
            text-align: center;
            margin-top: 35px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: #ffffff;
            border-radius: 10px;
            border: none;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .card-header-custom {
            background: #ffffff;
            font-weight: 700;
            border-bottom: 1px solid #e5e7eb;
        }

        .btn-primary-custom {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary-custom:hover {
            background: #3f47b8;
            border-color: #3f47b8;
        }

        .task-badge {
            min-width: 92px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            font-weight: 600;
        }

        .priority-low,
        .status-completed {
            background: var(--success) !important;
        }

        .priority-medium,
        .status-pending {
            background: var(--warning) !important;
            color: #1f2937 !important;
        }

        .priority-high {
            background: var(--danger) !important;
        }

        .status-in-progress {
            background: var(--info) !important;
        }

        .table thead th {
            background: #f8fafc;
            color: var(--text-dark);
            font-weight: 700;
        }

        .footer-custom {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('tasks.index') }}">To-Do App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tasks.index') }}#about">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 py-lg-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer id="about" class="footer-custom mt-5">
        <div class="container py-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <div>
                <div class="fw-semibold text-dark">About</div>
                <div class="text-muted small">To-Do List Management System helps you organize tasks, track priorities, and stay productive.</div>
            </div>
            <div class="text-muted small">© 2026 To-Do App. All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js" integrity="sha384-QjoPbdj/93O7LUz0wqTxepA3tIabUD3jzfZX+x5QLvqFtHBzSw4eYFLSVthB+EDT" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-success').forEach(function (alertElement) {
                window.setTimeout(function () {
                    const alertInstance = bootstrap.Alert.getOrCreateInstance(alertElement);
                    alertInstance.close();
                }, 3500);
            });

            document.querySelectorAll('.task-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.dataset.confirmed === 'true') {
                        return;
                    }

                    event.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This task will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            form.dataset.confirmed = 'true';
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>

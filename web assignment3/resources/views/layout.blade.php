<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Profile Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #eef3fb;
            font-family: 'Segoe UI', sans-serif;
            color: #1f2937;
        }

        .top-navbar {
            min-height: 70px;
            background: linear-gradient(135deg, #0d6efd, #0047b3);
            box-shadow: 0 5px 18px rgba(0,0,0,0.16);
        }

        .navbar-brand {
            color: #fff !important;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 700;
            margin-left: 18px;
            padding-bottom: 7px;
            position: relative;
        }

        .nav-link.active::after,
        .nav-link:hover::after {
            content: "";
            position: absolute;
            height: 3px;
            background: #facc15;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 10px;
        }

        .dashboard-container {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 45px 0 80px;
        }

        .hero-banner {
            background: linear-gradient(135deg, #5b6ee1, #7b3fad);
            color: #fff;
            border-radius: 16px;
            padding: 42px 25px;
            text-align: center;
            box-shadow: 0 16px 38px rgba(91,110,225,0.28);
            margin-bottom: 32px;
        }

        .hero-title {
            font-size: 38px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .hero-title i {
            margin-right: 12px;
        }

        .hero-subtitle {
            font-size: 16px;
            opacity: 0.95;
            margin-bottom: 0;
        }

        .stat-card {
            background: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(15,23,42,0.10);
            padding: 28px;
            text-align: center;
            min-height: 150px;
        }

        .stat-card i {
            font-size: 36px;
            margin-bottom: 12px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 900;
            color: #4f6df5;
            margin-bottom: 6px;
        }

        .stat-label {
            color: #6b7280;
            font-weight: 600;
        }

        .dashboard-card {
            background: #fff;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(15,23,42,0.12);
        }

        .card-gradient-header {
            background: linear-gradient(135deg, #4f6df5, #7b3fad);
            color: #fff;
            padding: 18px 24px;
            font-size: 18px;
            font-weight: 800;
        }

        .dashboard-card-body {
            padding: 26px;
        }

        .form-label {
            font-weight: 700;
            font-size: 14px;
            color: #374151;
            margin-bottom: 7px;
        }

        .form-label i {
            color: #0d6efd;
            margin-right: 6px;
        }

        .form-control {
            border-radius: 10px;
            min-height: 45px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #4f6df5;
            box-shadow: 0 0 0 0.2rem rgba(79,109,245,0.15);
        }

        .add-user-btn {
            background: linear-gradient(135deg, #0d6efd, #2563eb);
            color: #fff;
            border: none;
            border-radius: 10px;
            height: 48px;
            font-weight: 800;
            box-shadow: 0 8px 18px rgba(13,110,253,0.25);
        }

        .add-user-btn:hover {
            color: #fff;
            transform: translateY(-1px);
        }

        .search-input {
            min-height: 46px;
            border-radius: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            min-width: 950px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table thead th {
            background: linear-gradient(135deg, #4f6df5, #7b3fad);
            color: #fff;
            padding: 16px 14px;
            font-size: 15px;
            font-weight: 800;
            white-space: nowrap;
            border: none;
        }

        .custom-table tbody td {
            background: #fff;
            padding: 18px 14px;
            vertical-align: middle;
            border-bottom: 1px solid #eef0f5;
            white-space: nowrap;
            font-size: 14px;
        }

        .custom-table tbody tr:hover td {
            background: #f8f9ff;
        }

        .photo-column {
            width: 85px;
        }

        .name-column {
            min-width: 190px;
        }

        .actions-column {
            min-width: 180px;
            text-align: center;
        }

        .avatar-wrapper {
            width: 64px;
            height: 64px;
            padding: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f6df5, #ec4899);
            box-shadow: 0 8px 18px rgba(79,109,245,0.25);
        }

        .user-avatar {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            display: block;
        }

        .active-badge {
            background: #d1fae5;
            color: #047857;
            padding: 8px 13px;
            border-radius: 30px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .action-btn {
            border-radius: 8px;
            font-weight: 800;
            font-size: 13px;
            padding: 8px 10px;
            white-space: nowrap;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .footer {
            background: linear-gradient(135deg, #4f6df5, #7b3fad);
            color: #fff;
            padding: 16px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .preview-img {
            width: 82px;
            height: 82px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #4f6df5;
            margin-top: 12px;
        }

        @media (max-width: 991px) {
            .dashboard-container {
                width: 96%;
            }

            .hero-title {
                font-size: 28px;
            }

            .nav-link {
                margin-left: 0;
                margin-top: 8px;
            }
        }

        @media (max-width: 576px) {
            .hero-banner {
                padding: 32px 18px;
            }

            .hero-title {
                font-size: 24px;
            }

            .dashboard-card-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg top-navbar">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="{{ route('users.index') }}">
            <span class="brand-icon"><i class="bi bi-person-fill"></i></span>
            Smart Profile Management
        </a>

        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}#add-user">
                        <i class="bi bi-person-plus"></i> Add User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index', 'users.edit') ? 'active' : '' }}" href="{{ route('users.index') }}#users">
                        <i class="bi bi-people"></i> Users
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="dashboard-container">
    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="footer">
    © 2026 Smart Profile Management System. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user record will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    function previewImage(event) {
        const preview = document.getElementById('preview');

        if (event.target.files && event.target.files[0]) {
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.classList.remove('d-none');
        }
    }
</script>

@yield('scripts')

</body>
</html>

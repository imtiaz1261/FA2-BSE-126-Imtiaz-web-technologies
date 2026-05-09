<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Profile Management System')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        .dashboard-container {
            width: 95%;
            max-width: 1450px;
            margin: 0 auto;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: white !important;
            border-bottom: 3px solid #ffd700;
            padding-bottom: 0.25rem;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 32px;
            text-align: center;
            margin-bottom: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Summary Cards */
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            margin-bottom: 0;
            height: 100%;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .summary-card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .summary-card-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin: 10px 0;
        }

        .summary-card-label {
            font-size: 0.95rem;
            color: #6c757d;
            font-weight: 500;
        }

        /* Card Styling */
        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: white;
        }

        .card-modern:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-modern .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 25px;
            font-weight: 600;
            font-size: 1.2rem;
            border: none;
        }

        .card-modern .card-body {
            padding: 30px;
        }

        .table-modern {
            margin-bottom: 0;
        }

        .table-modern th,
        .table-modern td {
            white-space: nowrap;
        }

        .table-modern th.col-photo {
            width: 84px;
        }

        .table-modern th.col-actions {
            width: 160px;
            text-align: center;
        }

        .table-modern td.td-actions {
            text-align: center;
        }

        .action-btn {
            min-width: 36px;
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.35rem 0.45rem;
        }

        .table-modern th.col-name {
            min-width: 180px;
        }

        .table-modern th.col-email {
            min-width: 220px;
        }

        .table-modern th.col-cnic {
            min-width: 170px;
        }

        .table-modern th.col-telephone {
            min-width: 150px;
        }

        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background-color: #f8f9ff;
        }

        .form-control::placeholder {
            color: #adb5bd;
            font-style: italic;
        }

        /* Image Preview */
        .image-preview {
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
            border: 2px solid #667eea;
            padding: 10px;
            display: none;
        }

        .image-preview.show {
            display: block;
        }

        /* Avatar */
        .avatar-circular {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #667eea;
        }

        .avatar-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #667eea;
        }

        /* Buttons */
        .btn-modern {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-success-modern {
            background: #10b981;
            color: white;
        }

        .btn-success-modern:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .btn-info-modern {
            background: #3b82f6;
            color: white;
        }

        .btn-info-modern:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-danger-modern {
            background: #ef4444;
            color: white;
        }

        .btn-danger-modern:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .btn-secondary-modern {
            background: #6c757d;
            color: white;
        }

        .btn-secondary-modern:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
            color: white;
        }

        /* Table Styling */
        .table-modern {
            border-collapse: collapse;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table-modern tbody td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            background-color: #f8f9ff;
            box-shadow: inset 0 2px 5px rgba(102, 126, 234, 0.1);
        }

        /* Status Badge */
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        /* Search Box */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 0;
            align-items: center;
        }

        .search-box .form-control {
            border: 2px solid #e0e0e0;
        }

        .search-box .btn {
            white-space: nowrap;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        /* Footer */
        .footer-custom {
            text-align: center;
            padding: 30px 20px;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin-top: 72px;
        }

        /* Alert Styling */
        .alert-custom {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }

        .alert-success-custom {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-error-custom {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                width: 100%;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .hero-section h1 {
                font-size: 1.8rem;
            }

            .hero-section {
                padding: 32px 18px;
            }

            .summary-card {
                margin-bottom: 15px;
            }

            .table-modern {
                font-size: 0.9rem;
            }

            .avatar-circular {
                width: 40px;
                height: 40px;
            }
        }
    </style>

    @yield('extra-css')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid px-3 px-lg-4 px-xxl-5">
            <a class="navbar-brand" href="{{ route('users.index') }}">
                <i class="bi bi-person-circle me-2"></i>
                Smart Profile Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                    href="{{ route('users.index') }}">
                            <i class="bi bi-house me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}"
                                    href="{{ route('users.create') }}">
                            <i class="bi bi-person-plus me-1"></i> Add User
                        </a>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                    href="{{ route('users.index') }}">
                            <i class="bi bi-people me-1"></i> Users
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-5">
        <div class="dashboard-container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="dashboard-container">
            <p class="mb-0">
                <i class="bi bi-c-circle me-2"></i>&copy; 2026 Smart Profile Management System. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

    <!-- Custom JS for Delete Confirmation -->
    <script>
        function confirmDeleteForm(formId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This user record will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the delete form
                    document.getElementById(formId).submit();
                }
            });
        }

        // Image preview functionality
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('show');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    @yield('extra-js')
</body>
</html>

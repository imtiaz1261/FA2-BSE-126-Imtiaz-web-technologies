<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do List - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --secondary: #1d4ed8;
            --light-bg: #f8fbff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #dbe3ef;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fbff, #eef5ff);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-dark);
        }

        .auth-wrapper {
            min-height: 100vh;
            border-radius: 32px;
            overflow: hidden;
            background: #ffffff;
        }

        .top-navbar {
            height: 92px;
            border-bottom: 1px solid #e5edf7;
            padding: 0 75px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .brand {
            font-size: 32px;
            font-weight: 900;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.28);
        }

        .nav-link {
            color: #334155;
            font-size: 18px;
            font-weight: 600;
            margin-left: 34px;
            position: relative;
        }

        .nav-link.active,
        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link.active::after {
            content: "";
            position: absolute;
            height: 3px;
            background: var(--primary);
            left: 0;
            right: 0;
            bottom: -17px;
            border-radius: 50px;
        }

        .auth-main {
            min-height: calc(100vh - 92px);
        }

        .hero-panel {
            background: linear-gradient(135deg, #f5f8ff, #eef4ff);
            padding: 90px 90px 45px;
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 999px;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.08);
            margin-bottom: 32px;
        }

        .hero-title {
            font-size: 58px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -2px;
        }

        .hero-title span {
            display: block;
            color: var(--primary);
        }

        .hero-text {
            color: #334155;
            font-size: 22px;
            line-height: 1.55;
            max-width: 560px;
            margin-top: 28px;
        }

        .illustration {
            margin-top: 55px;
            position: relative;
            height: 330px;
        }

        .task-board {
            width: 250px;
            min-height: 300px;
            background: white;
            border-radius: 22px;
            box-shadow: 0 28px 55px rgba(37, 99, 235, 0.20);
            border: 8px solid #203a8f;
            padding: 42px 30px 25px;
            position: absolute;
            left: 135px;
            bottom: 0;
            transform: rotate(2deg);
        }

        .clip {
            position: absolute;
            top: -35px;
            left: 62px;
            width: 120px;
            height: 58px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            border-radius: 18px 18px 8px 8px;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
        }

        .clip::after {
            content: "";
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            position: absolute;
            top: 10px;
            left: 51px;
        }

        .task-line {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        .task-check {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fake-line {
            height: 11px;
            background: #dbeafe;
            border-radius: 20px;
            width: 115px;
        }

        .alarm {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #eef6ff;
            border: 8px solid #2563eb;
            left: 0;
            bottom: 0;
            box-shadow: 0 16px 28px rgba(37, 99, 235, 0.20);
        }

        .alarm::before {
            content: "";
            position: absolute;
            width: 50px;
            height: 6px;
            background: #0f172a;
            top: 55px;
            left: 35px;
            transform: rotate(-90deg);
            border-radius: 10px;
        }

        .alarm::after {
            content: "";
            position: absolute;
            width: 38px;
            height: 6px;
            background: #0f172a;
            top: 55px;
            left: 55px;
            border-radius: 10px;
        }

        .sticky-note {
            position: absolute;
            width: 100px;
            height: 105px;
            background: #fde047;
            right: 95px;
            bottom: 60px;
            border-radius: 8px;
            padding: 18px;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 16px 30px rgba(245, 158, 11, 0.25);
            transform: rotate(-4deg);
        }

        .plant {
            position: absolute;
            right: 15px;
            bottom: 0;
            width: 105px;
            height: 90px;
            background: #f5f5f4;
            border-radius: 0 0 28px 28px;
            box-shadow: 0 14px 24px rgba(15, 23, 42, 0.12);
        }

        .plant::before {
            content: "";
            position: absolute;
            width: 120px;
            height: 95px;
            background: radial-gradient(circle at 25% 70%, #22c55e 0 16px, transparent 17px),
                        radial-gradient(circle at 50% 35%, #4ade80 0 18px, transparent 19px),
                        radial-gradient(circle at 75% 65%, #16a34a 0 18px, transparent 19px);
            top: -80px;
            left: -10px;
        }

        .auth-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 55px;
            background: #ffffff;
        }

        .auth-card {
            width: 100%;
            max-width: 590px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 48px 46px;
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.12);
        }

        .auth-logo {
            width: 72px;
            height: 72px;
            margin: 0 auto 22px;
            border-radius: 50%;
            background: white;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08);
        }

        .auth-logo span {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .auth-title {
            text-align: center;
            font-size: 38px;
            font-weight: 950;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 20px;
            margin-bottom: 34px;
        }

        .form-label {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 22px;
            color: #64748b;
            z-index: 5;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 22px;
            cursor: pointer;
            z-index: 6;
        }

        .auth-input {
            height: 58px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            padding-left: 60px;
            font-size: 18px;
        }

        .auth-input.password-input {
            padding-right: 60px;
        }

        .auth-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.22rem rgba(37, 99, 235, 0.14);
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0 30px;
        }

        .form-check-input {
            width: 22px;
            height: 22px;
            border-radius: 6px;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .login-btn {
            width: 100%;
            height: 62px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white;
            font-size: 22px;
            font-weight: 800;
            box-shadow: 0 18px 35px rgba(37, 99, 235, 0.25);
            transition: 0.25s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 22px;
            color: #64748b;
            margin: 34px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #dbe3ef;
        }

        .bottom-link {
            text-align: center;
            color: #475569;
            font-size: 17px;
        }

        .bottom-link a,
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text {
            position: absolute;
            bottom: 35px;
            left: 90px;
            color: #475569;
            font-size: 15px;
        }

        @media (max-width: 991px) {
            .top-navbar {
                padding: 0 25px;
            }

            .hero-panel {
                display: none;
            }

            .auth-panel {
                min-height: calc(100vh - 92px);
                padding: 30px 18px;
            }

            .auth-card {
                padding: 34px 24px;
            }

            .auth-title {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>
<div class="auth-wrapper">

    <nav class="top-navbar d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="brand">
            <span class="brand-icon">
                <i class="bi bi-check-lg"></i>
            </span>
            To Do List
        </a>

        <div>
            <a href="{{ route('login') }}" class="nav-link d-inline-block active">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link d-inline-block">Register</a>
            @endif
        </div>
    </nav>

    <div class="row g-0 auth-main">
        <div class="col-lg-5 hero-panel">
            <div class="hero-badge">
                <i class="bi bi-rocket-takeoff-fill"></i> Stay Organized. Get Things Done.
            </div>

            <h1 class="hero-title">
                Organize your day,
                <span>achieve more.</span>
            </h1>

            <p class="hero-text">
                A simple and powerful To-Do List app to help you manage tasks,
                stay productive and never miss a deadline.
            </p>

            <div class="illustration">
                <div class="alarm"></div>

                <div class="task-board">
                    <div class="clip"></div>

                    <h5 class="fw-bold mb-4">My Tasks</h5>

                    <div class="task-line">
                        <span class="task-check"><i class="bi bi-check-lg"></i></span>
                        <span class="fake-line"></span>
                    </div>

                    <div class="task-line">
                        <span class="task-check"><i class="bi bi-check-lg"></i></span>
                        <span class="fake-line"></span>
                    </div>

                    <div class="task-line">
                        <span class="task-check"><i class="bi bi-check-lg"></i></span>
                        <span class="fake-line"></span>
                    </div>
                </div>

                <div class="sticky-note">
                    Focus<br>
                    Plan<br>
                    Achieve
                </div>

                <div class="plant"></div>
            </div>

            <div class="footer-text">
                &copy; 2026 To Do List. All rights reserved.
            </div>
        </div>

        <div class="col-lg-7 auth-panel">
            <div class="auth-card">
                <div class="auth-logo">
                    <span>
                        <i class="bi bi-check-lg"></i>
                    </span>
                </div>

                <h2 class="auth-title">Welcome Back</h2>
                <p class="auth-subtitle">Login to manage your tasks efficiently</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>

                        <div class="input-group-custom">
                            <i class="bi bi-envelope input-icon"></i>

                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control auth-input @error('email') is-invalid @enderror"
                                   placeholder="demo@example.com"
                                   required
                                   autofocus>

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>

                        <div class="input-group-custom">
                            <i class="bi bi-lock input-icon"></i>

                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="form-control auth-input password-input @error('password') is-invalid @enderror"
                                   placeholder="........"
                                   required>

                            <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="remember-row">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label ms-2" for="remember">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-btn">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Log In
                    </button>

                    <div class="divider">OR</div>

                    <div class="bottom-link">
                        Don't have an account?

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Create one</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do List - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fbff, #eef5ff);
            font-family: 'Segoe UI', sans-serif;
            color: #0f172a;
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
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(14px);
        }

        .brand {
            font-size: 32px;
            font-weight: 900;
            color: #2563eb;
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
            box-shadow: 0 12px 25px rgba(37,99,235,0.28);
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
            color: #2563eb;
        }

        .nav-link.active::after {
            content: "";
            position: absolute;
            height: 3px;
            background: #2563eb;
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
            color: #2563eb;
            padding: 10px 20px;
            border-radius: 999px;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(37,99,235,0.08);
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
            color: #2563eb;
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
            box-shadow: 0 28px 55px rgba(37,99,235,0.20);
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
            box-shadow: 0 10px 22px rgba(37,99,235,0.35);
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
            box-shadow: 0 16px 30px rgba(245,158,11,0.25);
            transform: rotate(-4deg);
        }

        .auth-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 45px;
            background: #ffffff;
        }

        .auth-card {
            width: 100%;
            max-width: 590px;
            background: rgba(255,255,255,0.96);
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 42px 46px;
            box-shadow: 0 30px 70px rgba(15,23,42,0.12);
        }

        .auth-logo {
            width: 68px;
            height: 68px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: white;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 30px rgba(15,23,42,0.08);
        }

        .auth-logo span {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .auth-title {
            text-align: center;
            font-size: 36px;
            font-weight: 950;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 19px;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 21px;
            color: #64748b;
            z-index: 5;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 21px;
            cursor: pointer;
            z-index: 6;
        }

        .auth-input {
            height: 56px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            padding-left: 58px;
            font-size: 17px;
        }

        .auth-input.password-input {
            padding-right: 58px;
        }

        .auth-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.22rem rgba(37,99,235,0.14);
        }

        .register-btn {
            width: 100%;
            height: 60px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white;
            font-size: 21px;
            font-weight: 800;
            box-shadow: 0 18px 35px rgba(37,99,235,0.25);
            transition: 0.25s;
            margin-top: 10px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 22px;
            color: #64748b;
            margin: 28px 0;
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

        .bottom-link a {
            color: #2563eb;
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
            <a href="{{ route('login') }}" class="nav-link d-inline-block">Login</a>
            <a href="{{ route('register') }}" class="nav-link d-inline-block active">Register</a>
        </div>
    </nav>

    <div class="row g-0 auth-main">
        <div class="col-lg-5 hero-panel">
            <div class="hero-badge">
                <i class="bi bi-rocket-takeoff-fill"></i> Start Planning Today.
            </div>

            <h1 class="hero-title">
                Create your account,
                <span>stay productive.</span>
            </h1>

            <p class="hero-text">
                Register now and start organizing your daily work,
                assignments, meetings, and important deadlines.
            </p>

            <div class="illustration">
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
                    Plan<br>
                    Track<br>
                    Finish
                </div>
            </div>

            <div class="footer-text">
                &copy; 2026 To Do List. All rights reserved.
            </div>
        </div>

        <div class="col-lg-7 auth-panel">
            <div class="auth-card">
                <div class="auth-logo">
                    <span>
                        <i class="bi bi-person-plus"></i>
                    </span>
                </div>

                <h2 class="auth-title">Create Account</h2>
                <p class="auth-subtitle">Register to start managing your tasks</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>

                        <div class="input-group-custom">
                            <i class="bi bi-person input-icon"></i>

                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control auth-input @error('name') is-invalid @enderror"
                                   placeholder="Enter your full name"
                                   required
                                   autofocus>

                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>

                        <div class="input-group-custom">
                            <i class="bi bi-envelope input-icon"></i>

                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control auth-input @error('email') is-invalid @enderror"
                                   placeholder="demo@example.com"
                                   required>

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
                                   placeholder="Create password"
                                   required>

                            <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>

                        <div class="input-group-custom">
                            <i class="bi bi-shield-lock input-icon"></i>

                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   class="form-control auth-input password-input"
                                   placeholder="Confirm password"
                                   required>

                            <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
                        </div>
                    </div>

                    <button type="submit" class="register-btn">
                        <i class="bi bi-person-plus me-2"></i>
                        Create Account
                    </button>

                    <div class="divider">OR</div>

                    <div class="bottom-link">
                        Already have an account?
                        <a href="{{ route('login') }}">Login here</a>
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

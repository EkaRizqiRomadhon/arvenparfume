<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — ARVEN PARFUME</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Animated gradient background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(212, 175, 55, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 80%, rgba(196, 165, 106, 0.06) 0%, transparent 60%);
            pointer-events: none;
        }

        .login-wrapper {
            position: relative;
            width: 100%;
            max-width: 420px;
            padding: 20px;
            z-index: 1;
        }

        .login-card {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 48px 40px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255,255,255,0.02),
                inset 0 1px 0 rgba(212,175,55,0.1);
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 4px;
            background: linear-gradient(135deg, #d4af37, #f5d46e, #c4a56a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-logo p {
            color: #555;
            font-size: 12px;
            letter-spacing: 2px;
            margin-top: 6px;
            text-transform: uppercase;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(212, 175, 55, 0.2);
        }

        .divider span {
            color: #444;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .alert-info {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: #d4af37;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #888;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: rgba(212, 175, 55, 0.5);
            background: rgba(212, 175, 55, 0.04);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.06);
        }

        input::placeholder { color: #444; }

        .field-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #d4af37;
            cursor: pointer;
        }

        .remember-row label {
            color: #888;
            font-size: 13px;
            letter-spacing: 0;
            text-transform: none;
            margin: 0;
            cursor: pointer;
            font-weight: 400;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #d4af37, #c4a56a);
            color: #0a0a0a;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: 0.3s;
        }

        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,175,55,0.35); }
        .btn-login:hover::after { opacity: 1; }
        .btn-login:active { transform: translateY(0); }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }

        .back-link:hover { color: #d4af37; }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">

        <div class="brand-logo">
            <h1>ARVEN</h1>
            <p>Admin Panel</p>
        </div>

        <div class="divider"><span>Masuk sebagai Admin</span></div>

        {{-- Alert error --}}
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Admin</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@arvenparfume.com"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                >
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat sesi login saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk ke Dashboard</button>
        </form>

        <a href="{{ url('/') }}" class="back-link">← Kembali ke Website</a>

    </div>
</div>

</body>
</html>

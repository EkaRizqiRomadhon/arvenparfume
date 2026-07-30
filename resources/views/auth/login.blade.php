<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ARVEN PARFUME</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 20px;
        }

        .login-container {
            background: rgba(40, 40, 40, 0.95);
            border-radius: 20px;
            padding: 40px 35px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(163, 139, 93, 0.2);
        }

        .logo-title { text-align: center; margin-bottom: 10px; }
        .logo-title h1 {
            color: #c4a56a;
            font-size: 32px;
            letter-spacing: 3px;
            font-weight: 800;
            text-shadow: 0 2px 10px rgba(196, 165, 106, 0.3);
        }

        .subtitle { text-align: center; color: #aaa; font-size: 15px; margin-bottom: 35px; }

        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; color: #ddd; font-size: 14px; font-weight: 600; margin-bottom: 8px; }

        .input-wrapper { position: relative; }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(60, 60, 60, 0.6);
            border: 1px solid rgba(163, 139, 93, 0.3);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }
        .form-group input::placeholder { color: #888; }
        .form-group input:focus {
            border-color: #c4a56a;
            background: rgba(70, 70, 70, 0.7);
            box-shadow: 0 0 0 3px rgba(196, 165, 106, 0.15);
        }
        .form-group input.is-invalid { border-color: #ff6b6b; }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 18px;
            user-select: none;
            transition: color 0.3s;
        }
        .password-toggle:hover { color: #c4a56a; }

        .field-error { color: #ff6b6b; font-size: 12px; margin-top: 5px; display: block; }

        .remember-me { display: flex; align-items: center; gap: 8px; margin-bottom: 25px; }
        .remember-me input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; accent-color: #c4a56a; }
        .remember-me label { color: #ddd; font-size: 14px; cursor: pointer; user-select: none; }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #c4a56a 0%, #a38b5d 100%);
            color: #1a1a1a;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(196, 165, 106, 0.3);
        }
        .login-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(196, 165, 106, 0.4); }
        .login-btn:active { transform: translateY(0); }

        .register-link { text-align: center; margin-top: 25px; color: #aaa; font-size: 14px; }
        .register-link a { color: #c4a56a; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .register-link a:hover { color: #d4b57a; text-decoration: underline; }

        .alert-box {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ff6b6b;
        }

        @media (max-width: 480px) {
            .login-container { padding: 30px 25px; }
            .logo-title h1 { font-size: 26px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-title">
            <h1>ARVEN PARFUME</h1>
        </div>
        <p class="subtitle">Login untuk melanjutkan</p>

        {{-- Session error (misalnya diarahkan dari middleware) --}}
        @if(session('error'))
            <div class="alert-box">{{ session('error') }}</div>
        @endif

        {{-- Error dari Laravel (email/password salah) --}}
        @if($errors->any())
            <div class="alert-box">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{--
            Form dikirim ke route 'login.attempt' (POST /login).
            @csrf wajib ada — tanpanya Laravel akan error 419.
            'remember' → nama checkbox yang dikenal Laravel untuk "ingat saya".
        --}}
        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@contoh.com"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                >
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                    >
                    <span class="password-toggle" id="togglePassword">👁️</span>
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="login-btn">LOGIN</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>

    <script>
        // Toggle password visibility (ini aman dipertahankan, bukan fetch)
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.textContent = isPassword ? '🙈' : '👁️';
        });
    </script>
</body>
</html>
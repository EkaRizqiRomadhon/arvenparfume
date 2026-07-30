<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    // ─── LOGIN ───────────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            // Kalau sudah login sebagai admin, langsung ke dashboard admin
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect('/');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $this->authService->logActivity(
                userId:      Auth::id(),
                action:      'login',
                description: 'User berhasil login via web.',
                ipAddress:   $request->ip(),
            );

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    // ─── REGISTER ────────────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'min:3', 'max:100'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.min'           => 'Nama minimal 3 karakter.',
            'email.unique'       => 'Email sudah terdaftar. Silakan login.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // 'name' dari form → disimpan ke kolom 'full_name' di tabel users
        $user = User::create([
            'full_name' => $validated['name'],
            'email'     => $validated['email'],
            'password'  => $validated['password'], // auto-hashed oleh $casts
            'role'      => 'user',
            'is_active' => true,
        ]);

        $this->authService->logActivity(
            userId:      $user->id,
            action:      'register',
            description: 'User baru mendaftar via web.',
            ipAddress:   $request->ip(),
        );

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }

    // ─── LOGOUT ──────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        $userId = Auth::id();

        if ($userId) {
            $this->authService->logActivity(
                userId:      $userId,
                action:      'logout',
                description: 'User melakukan logout.',
                ipAddress:   $request->ip(),
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
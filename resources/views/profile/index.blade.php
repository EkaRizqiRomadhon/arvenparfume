@extends('layouts.app')

@section('title', 'Profil Saya - ARVEN PARFUME')

@push('head')
<style>
    .profile-container {
        max-width: 800px;
        margin: 120px auto 60px;
        padding: 0 20px;
    }

    .profile-title {
        color: #c4a56a;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media(min-width: 768px) {
        .profile-grid { grid-template-columns: 1fr 1fr; }
    }

    .profile-card {
        background: rgba(30, 30, 30, 0.9);
        border: 1px solid rgba(196, 165, 106, 0.2);
        border-radius: 12px;
        padding: 30px;
    }

    .card-title {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        color: #aaa;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .form-group input {
        width: 100%;
        padding: 12px 16px;
        background: rgba(60, 60, 60, 0.6);
        border: 1px solid rgba(196, 165, 106, 0.3);
        border-radius: 8px;
        color: #fff;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }
    .form-group input:focus {
        border-color: #c4a56a;
        background: rgba(70, 70, 70, 0.7);
    }
    .field-error { color: #ef4444; font-size: 12px; margin-top: 5px; display: block; }

    .btn-save {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #c4a56a, #a38b5d);
        color: #1a1a1a;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(196, 165, 106, 0.3);
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <h1 class="profile-title">Profil Saya</h1>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.5); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-grid">
        {{-- Update Profil --}}
        <div class="profile-card">
            <h2 class="card-title">Informasi Pribadi</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                    @error('full_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-save">Simpan Profil</button>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="profile-card">
            <h2 class="card-title">Ubah Password</h2>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>Password Saat Ini</label>
                    <input type="password" name="current_password" required>
                    @error('current_password') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" required>
                    @error('password') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-save">Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection

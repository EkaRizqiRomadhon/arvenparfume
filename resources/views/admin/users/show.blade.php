@extends('layouts.admin')

@section('title', 'Detail User - Admin ARVEN')
@section('header-title', 'Detail Pengguna')

@section('content')
@if(session('success'))
    <div style="background: rgba(74,222,128,0.1); border: 1px solid #4ade80; color: #4ade80; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: rgba(239,68,68,0.1); border: 1px solid #ef4444; color: #ef4444; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: start;">

    {{-- Panel Kiri: Info & Aksi --}}
    <div>
        <div class="admin-card" style="text-align: center;">
            {{-- Avatar --}}
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #d4af37, #c4a56a); display: flex; align-items: center; justify-content: center; font-size: 30px; font-weight: 700; color: #000; margin: 0 auto 16px;">
                {{ strtoupper(substr($user->full_name, 0, 1)) }}
            </div>
            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 4px;">{{ $user->full_name }}</h2>
            <p style="color: var(--admin-text-muted); font-size: 13px; margin-bottom: 16px;">{{ $user->email }}</p>

            @if($user->is_active)
                <span style="background: rgba(74,222,128,0.1); color: #4ade80; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">● Aktif</span>
            @else
                <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">● Nonaktif</span>
            @endif

            <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 10px;">
                {{-- Toggle status --}}
                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" style="width: 100%; padding: 10px; background: {{ $user->is_active ? 'rgba(251,191,36,0.1)' : 'rgba(74,222,128,0.1)' }}; color: {{ $user->is_active ? '#fbbf24' : '#4ade80' }}; border: 1px solid {{ $user->is_active ? 'rgba(251,191,36,0.3)' : 'rgba(74,222,128,0.3)' }}; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
                        {{ $user->is_active ? '🔒 Nonaktifkan Akun' : '✅ Aktifkan Akun' }}
                    </button>
                </form>

                {{-- Reset Password --}}
                <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" onsubmit="return confirm('Reset password akun ini ke default?');">
                    @csrf @method('PATCH')
                    <button type="submit" style="width: 100%; padding: 10px; background: rgba(96,165,250,0.1); color: #60a5fa; border: 1px solid rgba(96,165,250,0.3); border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
                        🔑 Reset Password
                    </button>
                </form>

                {{-- Hapus Akun --}}
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('YAKIN hapus akun ini secara permanen?');">
                    @csrf @method('DELETE')
                    <button type="submit" style="width: 100%; padding: 10px; background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
                        🗑️ Hapus Akun
                    </button>
                </form>
            </div>
        </div>

        <div style="margin-top: 12px;">
            <a href="{{ route('admin.users.index') }}" style="display: block; text-align: center; color: var(--admin-text-muted); text-decoration: none; font-size: 13px;">← Kembali ke daftar</a>
        </div>
    </div>

    {{-- Panel Kanan: Info Detail + Riwayat --}}
    <div>
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Informasi Akun</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 1px;">Nama Lengkap</p>
                    <p style="font-weight: 500;">{{ $user->full_name }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 1px;">Email</p>
                    <p>{{ $user->email }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 1px;">Role</p>
                    <p style="text-transform: capitalize;">{{ $user->role }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 1px;">Login Terakhir</p>
                    <p>{{ $user->last_login ? $user->last_login->diffForHumans() : 'Belum pernah' }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 1px;">Daftar Sejak</p>
                    <p>{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 1px;">Total Pesanan</p>
                    <p style="font-size: 18px; font-weight: 700; color: var(--admin-primary);">{{ $user->checkouts->count() }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Riwayat Pesanan</h2>
            </div>
            @if($user->checkouts->isEmpty())
                <p style="color: var(--admin-text-muted); font-size: 14px; text-align: center; padding: 20px 0;">Belum ada riwayat pesanan</p>
            @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: left;">Order ID</th>
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: left;">Total</th>
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: left;">Status</th>
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: left;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->checkouts->take(10) as $checkout)
                    @php
                        $statusColor = match($checkout->status) {
                            'completed'  => '#4ade80',
                            'cancelled'  => '#ef4444',
                            'processing','shipped' => '#60a5fa',
                            default => '#d4af37',
                        };
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                        <td style="padding: 12px; font-size: 13px; font-family: monospace; color: var(--admin-primary);">{{ $checkout->order_id ?? '#'.$checkout->id }}</td>
                        <td style="padding: 12px; font-size: 13px;">Rp {{ number_format($checkout->gross_amount, 0, ',', '.') }}</td>
                        <td style="padding: 12px;">
                            <span style="color: {{ $statusColor }}; font-size: 12px; font-weight: 600; text-transform: capitalize;">{{ $checkout->status }}</span>
                        </td>
                        <td style="padding: 12px; font-size: 12px; color: var(--admin-text-muted);">{{ $checkout->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>
@endsection

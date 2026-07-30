@extends('layouts.admin')

@section('title', 'Kelola User - Admin ARVEN')
@section('header-title', 'Kelola User')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Daftar Pengguna Terdaftar</h2>
        <span style="color: var(--admin-text-muted); font-size: 14px;">{{ $users->total() }} total user</span>
    </div>

    {{-- Alert --}}
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

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            style="flex: 1; min-width: 200px; padding: 10px 14px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none; font-size: 14px;"
        >
        <select name="status" style="padding: 10px 14px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none; font-size: 14px;">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit" style="padding: 10px 20px; background: var(--admin-primary); color: #000; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">Cari</button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.users.index') }}" style="padding: 10px 16px; background: transparent; border: 1px solid var(--admin-border); color: var(--admin-text-muted); border-radius: 6px; text-decoration: none; font-size: 14px; display: flex; align-items: center;">Reset</a>
        @endif
    </form>

    {{-- Table --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">#</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Nama</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Email</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Status</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Daftar</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; font-size: 13px; color: var(--admin-text-muted);">{{ $user->id }}</td>
                    <td style="padding: 15px;">
                        <div style="font-weight: 500; font-size: 14px;">{{ $user->full_name }}</div>
                    </td>
                    <td style="padding: 15px; font-size: 13px; color: var(--admin-text-muted);">{{ $user->email }}</td>
                    <td style="padding: 15px;">
                        @if($user->is_active)
                            <span style="background: rgba(74,222,128,0.1); color: #4ade80; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">Aktif</span>
                        @else
                            <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding: 15px; font-size: 13px; color: var(--admin-text-muted);">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ route('admin.users.show', $user) }}" style="font-size: 12px; color: #60a5fa; text-decoration: none; padding: 4px 8px; border: 1px solid rgba(96,165,250,0.3); border-radius: 4px;">Detail</a>

                            {{-- Toggle Aktif/Nonaktif --}}
                            <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" style="font-size: 12px; color: {{ $user->is_active ? '#fbbf24' : '#4ade80' }}; background: none; border: 1px solid {{ $user->is_active ? 'rgba(251,191,36,0.3)' : 'rgba(74,222,128,0.3)' }}; padding: 4px 8px; border-radius: 4px; cursor: pointer;">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- Hapus --}}
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus akun {{ $user->full_name }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" style="font-size: 12px; color: #ef4444; background: none; border: 1px solid rgba(239,68,68,0.3); padding: 4px 8px; border-radius: 4px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
                        @if(request('search'))
                            Tidak ada user yang cocok dengan pencarian "{{ request('search') }}"
                        @else
                            Belum ada pengguna terdaftar
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: center; gap: 8px;">
        {{-- Simple pagination links with custom styling --}}
        <div style="color: var(--admin-text-muted); font-size: 13px; padding-top: 4px;">
            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
        </div>
        <div style="margin-left: auto; display: flex; gap: 4px;">
            @if($users->onFirstPage())
                <span style="padding: 6px 12px; background: rgba(255,255,255,0.03); color: #555; border-radius: 4px; font-size: 13px;">‹ Prev</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; background: rgba(255,255,255,0.05); color: #fff; border-radius: 4px; font-size: 13px; text-decoration: none;">‹ Prev</a>
            @endif

            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; background: rgba(255,255,255,0.05); color: #fff; border-radius: 4px; font-size: 13px; text-decoration: none;">Next ›</a>
            @else
                <span style="padding: 6px 12px; background: rgba(255,255,255,0.03); color: #555; border-radius: 4px; font-size: 13px;">Next ›</span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Admin Dashboard - ARVEN PARFUME')
@section('header-title', 'Overview Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 30px;">
    {{-- Stat: Pesanan Baru --}}
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--admin-text-muted); font-size: 13px; margin-bottom: 8px;">Pesanan Pending</p>
                <h3 style="font-size: 32px; font-weight: 700;">{{ $stats['pending_orders'] }}</h3>
            </div>
            <div style="background: rgba(212,175,55,0.1); color: var(--admin-primary); padding: 12px; border-radius: 8px; font-size: 20px;">🛒</div>
        </div>
        <div style="margin-top: 12px; font-size: 12px; color: var(--admin-text-muted);">dari {{ $stats['total_orders'] }} total pesanan</div>
    </div>

    {{-- Stat: Total Brand --}}
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--admin-text-muted); font-size: 13px; margin-bottom: 8px;">Total Brand</p>
                <h3 style="font-size: 32px; font-weight: 700;">{{ $stats['total_brands'] }}</h3>
            </div>
            <div style="background: rgba(212,175,55,0.1); color: var(--admin-primary); padding: 12px; border-radius: 8px; font-size: 20px;">🏷️</div>
        </div>
        <div style="margin-top: 12px; font-size: 12px; color: var(--admin-text-muted);">{{ $stats['total_products'] }} produk aktif</div>
    </div>

    {{-- Stat: Pesan Belum Dibaca --}}
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--admin-text-muted); font-size: 13px; margin-bottom: 8px;">Pesan Belum Dibaca</p>
                <h3 style="font-size: 32px; font-weight: 700; color: {{ $stats['unread_contacts'] > 0 ? '#ef4444' : '#fff' }};">
                    {{ $stats['unread_contacts'] }}
                </h3>
            </div>
            <div style="background: rgba(212,175,55,0.1); color: var(--admin-primary); padding: 12px; border-radius: 8px; font-size: 20px;">📩</div>
        </div>
        <div style="margin-top: 12px;">
            <a href="{{ route('admin.contacts.index') }}" style="font-size: 12px; color: var(--admin-primary); text-decoration: none;">Lihat semua →</a>
        </div>
    </div>

    {{-- Stat: Total User --}}
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--admin-text-muted); font-size: 13px; margin-bottom: 8px;">Total User</p>
                <h3 style="font-size: 32px; font-weight: 700;">{{ $stats['total_users'] }}</h3>
            </div>
            <div style="background: rgba(212,175,55,0.1); color: var(--admin-primary); padding: 12px; border-radius: 8px; font-size: 20px;">👥</div>
        </div>
        <div style="margin-top: 12px; font-size: 12px; color: var(--admin-text-muted);">
            {{ $stats['active_users'] }} akun aktif &nbsp;·&nbsp;
            <a href="{{ route('admin.users.index') }}" style="color: var(--admin-primary); text-decoration: none;">Kelola →</a>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 30px;">
    <a href="{{ route('admin.brands.create') }}" style="display: flex; align-items: center; gap: 12px; background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.2); padding: 16px; border-radius: 8px; text-decoration: none; color: #fff; transition: 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
        <span style="font-size: 22px;">➕</span>
        <span style="font-size: 14px; font-weight: 500;">Tambah Brand</span>
    </a>
    <a href="{{ route('admin.products.create') }}" style="display: flex; align-items: center; gap: 12px; background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.2); padding: 16px; border-radius: 8px; text-decoration: none; color: #fff; transition: 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
        <span style="font-size: 22px;">📦</span>
        <span style="font-size: 14px; font-weight: 500;">Tambah Produk</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; gap: 12px; background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.2); padding: 16px; border-radius: 8px; text-decoration: none; color: #fff; transition: 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
        <span style="font-size: 22px;">🛒</span>
        <span style="font-size: 14px; font-weight: 500;">Lihat Pesanan</span>
    </a>
    <a href="{{ route('admin.contacts.index') }}" style="display: flex; align-items: center; gap: 12px; background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.2); padding: 16px; border-radius: 8px; text-decoration: none; color: #fff; transition: 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
        <span style="font-size: 22px;">📩</span>
        <span style="font-size: 14px; font-weight: 500;">Pesan Masuk</span>
    </a>
    <a href="{{ route('admin.users.index') }}" style="display: flex; align-items: center; gap: 12px; background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.2); padding: 16px; border-radius: 8px; text-decoration: none; color: #fff; transition: 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
        <span style="font-size: 22px;">👥</span>
        <span style="font-size: 14px; font-weight: 500;">Kelola User</span>
    </a>
</div>

{{-- Tabel Pesanan Terbaru --}}
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" style="color: var(--admin-primary); text-decoration: none; font-size: 14px;">Lihat Semua →</a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <th style="padding: 12px 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">ID Pesanan</th>
                    <th style="padding: 12px 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Pelanggan</th>
                    <th style="padding: 12px 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Total</th>
                    <th style="padding: 12px 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Status</th>
                    <th style="padding: 12px 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stats['recent_orders'] as $order)
                @php
                    $statusColor = match($order->status) {
                        'pending'    => '#d4af37',
                        'processing' => '#60a5fa',
                        'shipped'    => '#a78bfa',
                        'completed'  => '#4ade80',
                        'cancelled'  => '#ef4444',
                        default      => '#888',
                    };
                @endphp
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                    <td style="padding: 12px 15px; font-size: 13px; font-family: monospace; color: var(--admin-primary);">{{ $order->order_id ?? '#ORD-'.$order->id }}</td>
                    <td style="padding: 12px 15px; font-size: 14px;">{{ $order->user->full_name ?? $order->user->name ?? 'N/A' }}</td>
                    <td style="padding: 12px 15px; font-size: 14px;">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</td>
                    <td style="padding: 12px 15px;">
                        <span style="color: {{ $statusColor }}; font-size: 12px; font-weight: 600; text-transform: capitalize;">● {{ $order->status }}</span>
                    </td>
                    <td style="padding: 12px 15px; font-size: 13px; color: var(--admin-text-muted);">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: var(--admin-text-muted);">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

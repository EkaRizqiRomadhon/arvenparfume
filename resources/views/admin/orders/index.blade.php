@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin ARVEN')
@section('header-title', 'Kelola Pesanan')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Semua Transaksi</h2>
        <span style="color: var(--admin-text-muted); font-size: 14px;">{{ $orders->count() }} total pesanan</span>
    </div>

    @if(session('success'))
        <div style="background: rgba(74, 222, 128, 0.1); border: 1px solid #4ade80; color: #4ade80; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">ID Pesanan</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Pelanggan</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Total</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Status</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Tanggal</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $statusColor = match($order->status) {
                        'pending'    => ['bg' => 'rgba(212,175,55,0.15)',  'color' => '#d4af37'],
                        'processing' => ['bg' => 'rgba(96,165,250,0.15)', 'color' => '#60a5fa'],
                        'shipped'    => ['bg' => 'rgba(167,139,250,0.15)','color' => '#a78bfa'],
                        'completed'  => ['bg' => 'rgba(74,222,128,0.15)', 'color' => '#4ade80'],
                        'cancelled'  => ['bg' => 'rgba(239,68,68,0.15)',  'color' => '#ef4444'],
                        default      => ['bg' => 'rgba(255,255,255,0.05)','color' => '#888'],
                    };
                @endphp
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                    <td style="padding: 15px; font-size: 13px; font-family: monospace; color: var(--admin-primary);">
                        {{ $order->order_id ?? '#ORD-'.$order->id }}
                    </td>
                    <td style="padding: 15px; font-size: 14px;">
                        {{ $order->user->full_name ?? $order->user->name ?? 'N/A' }}
                        <div style="font-size: 12px; color: var(--admin-text-muted);">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td style="padding: 15px; font-size: 14px;">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</td>
                    <td style="padding: 15px;">
                        <span style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['color'] }}; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; text-transform: capitalize;">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td style="padding: 15px; font-size: 13px; color: var(--admin-text-muted);">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td style="padding: 15px;">
                        <a href="{{ route('admin.orders.show', $order) }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

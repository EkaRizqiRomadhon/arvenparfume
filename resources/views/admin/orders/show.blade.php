@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin ARVEN')
@section('header-title', 'Detail Pesanan')

@section('content')
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

@if(session('success'))
    <div style="background: rgba(74, 222, 128, 0.1); border: 1px solid #4ade80; color: #4ade80; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">

    {{-- Kolom kiri: Detail order --}}
    <div>
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Info Pesanan</h2>
                <span style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['color'] }}; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; text-transform: capitalize;">{{ $order->status }}</span>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px;">ID Pesanan</p>
                    <p style="font-family: monospace; color: var(--admin-primary);">{{ $order->order_id ?? '#ORD-'.$order->id }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px;">Tanggal</p>
                    <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px;">Pelanggan</p>
                    <p>{{ $order->user->full_name ?? $order->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px;">Email</p>
                    <p style="color: var(--admin-text-muted);">{{ $order->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px;">Metode Bayar</p>
                    <p>{{ $order->payment_type ?? 'Simulasi' }}</p>
                </div>
                <div>
                    <p style="color: var(--admin-text-muted); font-size: 12px; margin-bottom: 4px;">Total</p>
                    <p style="font-size: 18px; font-weight: 700; color: var(--admin-primary);">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Item Dibeli</h2>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: left;">Produk</th>
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: right;">Harga</th>
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: center;">Qty</th>
                        <th style="padding: 12px; color: var(--admin-text-muted); font-weight: 500; font-size: 13px; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                        <td style="padding: 12px; font-size: 14px;">{{ $item->name }}</td>
                        <td style="padding: 12px; font-size: 14px; text-align: right; color: var(--admin-text-muted);">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="padding: 12px; font-size: 14px; text-align: center;">{{ $item->quantity }}</td>
                        <td style="padding: 12px; font-size: 14px; text-align: right; font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="padding: 20px; text-align:center; color: var(--admin-text-muted);">Tidak ada item detail</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kolom kanan: Update Status --}}
    <div>
        <div class="admin-card">
            <div class="card-header" style="margin-bottom: 16px; padding-bottom: 12px;">
                <h2 class="card-title">Update Status</h2>
            </div>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="margin-bottom: 16px;">
                    <select name="status" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
                        @foreach(['pending','processing','shipped','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }} style="background: #1a1a1a;">
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" style="width: 100%; background: var(--admin-primary); color: #000; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    Simpan Status
                </button>
            </form>
        </div>

        <div style="margin-top: 16px;">
            <a href="{{ route('admin.orders.index') }}" style="display: block; text-align: center; color: var(--admin-text-muted); text-decoration: none; font-size: 13px;">
                ← Kembali ke daftar
            </a>
        </div>
    </div>
</div>
@endsection

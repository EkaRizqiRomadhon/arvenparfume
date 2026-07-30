@extends('layouts.app')

@section('title', 'Riwayat Transaksi - ARVEN PARFUME')

@push('head')
<style>
    .history-container {
        max-width: 1000px;
        margin: 120px auto 60px;
        padding: 0 20px;
        min-height: 50vh;
    }

    .history-title {
        color: #c4a56a;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
    }

    .history-card {
        background: rgba(30, 30, 30, 0.9);
        border: 1px solid rgba(196, 165, 106, 0.2);
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .history-header {
        background: rgba(0, 0, 0, 0.4);
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(196, 165, 106, 0.1);
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-id {
        color: #fff;
        font-weight: 700;
        font-family: monospace;
        font-size: 16px;
    }

    .order-date {
        color: #888;
        font-size: 14px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .status-pending { background: rgba(212, 175, 55, 0.1); color: #d4af37; border: 1px solid rgba(212, 175, 55, 0.3); }
    .status-processing { background: rgba(96, 165, 250, 0.1); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.3); }
    .status-shipped { background: rgba(167, 139, 250, 0.1); color: #a78bfa; border: 1px solid rgba(167, 139, 250, 0.3); }
    .status-completed { background: rgba(74, 222, 128, 0.1); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); }
    .status-cancelled { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }

    .history-body {
        padding: 20px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed rgba(255,255,255,0.05);
    }
    .item-row:last-child {
        border-bottom: none;
    }

    .item-name {
        color: #fff;
        font-size: 15px;
    }
    .item-qty {
        color: #aaa;
        font-size: 14px;
    }
    .item-subtotal {
        color: #c4a56a;
        font-weight: 600;
    }

    .history-footer {
        padding: 15px 20px;
        background: rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        border-top: 1px solid rgba(196, 165, 106, 0.1);
    }

    .total-amount {
        font-size: 18px;
        font-weight: 700;
        color: #c4a56a;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: rgba(30, 30, 30, 0.6);
        border-radius: 12px;
        border: 1px dashed rgba(196, 165, 106, 0.3);
    }
    .empty-state i {
        font-size: 48px;
        color: #c4a56a;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    .empty-state p {
        color: #aaa;
        font-size: 16px;
        margin-bottom: 20px;
    }
    .btn-shop {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(135deg, #c4a56a, #a38b5d);
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 700;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(196, 165, 106, 0.4);
    }

    @media (max-width: 600px) {
        .history-header { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')
<div class="history-container">
    <h1 class="history-title">Riwayat Transaksi</h1>

    @if($checkouts->isEmpty())
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>Belum ada riwayat pesanan.</p>
            <a href="{{ url('/koleksi') }}" class="btn-shop">Belanja Sekarang</a>
        </div>
    @else
        @foreach($checkouts as $checkout)
            <div class="history-card">
                <div class="history-header">
                    <div>
                        <div class="order-id">{{ $checkout->order_id }}</div>
                        <div class="order-date">{{ $checkout->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        @php
                            $statusClass = 'status-pending';
                            if($checkout->status == 'processing') $statusClass = 'status-processing';
                            if($checkout->status == 'shipped') $statusClass = 'status-shipped';
                            if($checkout->status == 'completed' || $checkout->status == 'success') $statusClass = 'status-completed';
                            if($checkout->status == 'cancelled') $statusClass = 'status-cancelled';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $checkout->status }}</span>
                    </div>
                </div>
                
                <div class="history-body">
                    @foreach($checkout->items as $item)
                        <div class="item-row">
                            <div>
                                <div class="item-name">{{ $item->name }}</div>
                                <div class="item-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="item-subtotal">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="history-footer">
                    <div style="color: #fff; margin-right: 15px; font-weight: 500;">Total Pesanan:</div>
                    <div class="total-amount">Rp {{ number_format($checkout->gross_amount, 0, ',', '.') }}</div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

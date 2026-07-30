@extends('layouts.admin')

@section('title', 'Pesan Masuk - Admin ARVEN')
@section('header-title', 'Pesan Masuk')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Semua Pesan Kontak</h2>
        @php $unread = $messages->where('status', 'unread')->count(); @endphp
        @if($unread > 0)
            <span style="background: rgba(239,68,68,0.15); color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                {{ $unread }} belum dibaca
            </span>
        @else
            <span style="color: var(--admin-text-muted); font-size: 14px;">{{ $messages->count() }} total pesan</span>
        @endif
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Pengirim</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Subjek</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Status</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Waktu</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                @php
                    $isUnread = $msg->status === 'unread';
                    $statusMap = [
                        'unread'  => ['bg' => 'rgba(239,68,68,0.15)',  'color' => '#ef4444', 'label' => 'Baru'],
                        'read'    => ['bg' => 'rgba(255,255,255,0.05)','color' => '#888',    'label' => 'Dibaca'],
                        'replied' => ['bg' => 'rgba(74,222,128,0.15)', 'color' => '#4ade80', 'label' => 'Dibalas'],
                    ];
                    $s = $statusMap[$msg->status] ?? $statusMap['read'];
                @endphp
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02); {{ $isUnread ? 'background: rgba(212,175,55,0.03);' : '' }}">
                    <td style="padding: 15px;">
                        <div style="font-weight: {{ $isUnread ? '600' : '400' }};">{{ $msg->name }}</div>
                        <div style="font-size: 12px; color: var(--admin-text-muted);">{{ $msg->email }}</div>
                    </td>
                    <td style="padding: 15px; font-size: 14px; font-weight: {{ $isUnread ? '600' : '400' }};">{{ $msg->subject }}</td>
                    <td style="padding: 15px;">
                        <span style="background: {{ $s['bg'] }}; color: {{ $s['color'] }}; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                            {{ $s['label'] }}
                        </span>
                    </td>
                    <td style="padding: 15px; font-size: 13px; color: var(--admin-text-muted);">
                        {{ $msg->created_at->format('d M Y, H:i') }}
                    </td>
                    <td style="padding: 15px;">
                        <a href="{{ route('admin.contacts.show', $msg) }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;">Baca →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: var(--admin-text-muted);">Belum ada pesan masuk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

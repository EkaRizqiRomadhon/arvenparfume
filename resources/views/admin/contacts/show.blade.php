@extends('layouts.admin')

@section('title', 'Detail Pesan - Admin ARVEN')
@section('header-title', 'Detail Pesan')

@section('content')
@if(session('success'))
    <div style="background: rgba(74, 222, 128, 0.1); border: 1px solid #4ade80; color: #4ade80; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">

    {{-- Isi pesan --}}
    <div class="admin-card">
        <div class="card-header">
            <h2 class="card-title">{{ $contact->subject }}</h2>
            @php
                $statusMap = [
                    'unread'  => ['bg' => 'rgba(239,68,68,0.15)',  'color' => '#ef4444', 'label' => 'Baru'],
                    'read'    => ['bg' => 'rgba(255,255,255,0.05)','color' => '#888',    'label' => 'Dibaca'],
                    'replied' => ['bg' => 'rgba(74,222,128,0.15)', 'color' => '#4ade80', 'label' => 'Dibalas'],
                ];
                $s = $statusMap[$contact->status] ?? $statusMap['read'];
            @endphp
            <span style="background: {{ $s['bg'] }}; color: {{ $s['color'] }}; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                {{ $s['label'] }}
            </span>
        </div>

        <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--admin-border);">
            <div style="display: flex; gap: 24px; color: var(--admin-text-muted); font-size: 13px;">
                <span>👤 <strong style="color: #fff;">{{ $contact->name }}</strong></span>
                <span>✉️ {{ $contact->email }}</span>
                <span>🕐 {{ $contact->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; line-height: 1.8; white-space: pre-wrap; font-size: 15px;">
            {{ $contact->message }}
        </div>
    </div>

    {{-- Panel Balas (Simulasi) --}}
    <div>
        @if($contact->status !== 'replied')
        <div class="admin-card">
            <div class="card-header" style="margin-bottom: 16px; padding-bottom: 12px;">
                <h2 class="card-title">Balas Pesan</h2>
            </div>
            <p style="color: var(--admin-text-muted); font-size: 13px; margin-bottom: 16px;">
                Tulis catatan balasan (simulasi — tidak mengirim email). Status pesan akan berubah menjadi <strong style="color: #4ade80;">Dibalas</strong>.
            </p>
            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="margin-bottom: 16px;">
                    <textarea name="reply_note" rows="5" required placeholder="Tulis catatan balasan di sini..." style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none; resize: vertical;"></textarea>
                </div>
                <button type="submit" style="width: 100%; background: var(--admin-primary); color: #000; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    Tandai Sudah Dibalas ✓
                </button>
            </form>
        </div>
        @else
        <div class="admin-card" style="text-align: center; padding: 30px;">
            <div style="font-size: 40px; margin-bottom: 10px;">✅</div>
            <p style="color: #4ade80; font-weight: 600;">Pesan ini sudah dibalas</p>
        </div>
        @endif

        <div style="margin-top: 16px;">
            <a href="{{ route('admin.contacts.index') }}" style="display: block; text-align: center; color: var(--admin-text-muted); text-decoration: none; font-size: 13px;">
                ← Kembali ke daftar
            </a>
        </div>
    </div>
</div>
@endsection

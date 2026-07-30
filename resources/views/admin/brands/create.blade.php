@extends('layouts.admin')

@section('title', 'Tambah Brand - Admin ARVEN')
@section('header-title', 'Tambah Brand')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.brands.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Nama Brand</label>
            <input type="text" name="name" required style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;" placeholder="Contoh: Dior">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Deskripsi Singkat</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;"></textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Path Gambar (misal: brand/ysl.png)</label>
            <input type="text" name="image" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" style="background: var(--admin-primary); color: #000; border: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; cursor: pointer;">Simpan Brand</button>
            <a href="{{ route('admin.brands.index') }}" style="background: transparent; color: var(--admin-text); border: 1px solid var(--admin-border); padding: 12px 24px; border-radius: 6px; text-decoration: none; display: flex; align-items: center;">Batal</a>
        </div>
    </form>
</div>
@endsection

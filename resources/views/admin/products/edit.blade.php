@extends('layouts.admin')

@section('title', 'Edit Produk - Admin ARVEN')
@section('header-title', 'Edit Produk')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Pilih Brand</label>
            <select name="brand_id" required style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" required style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Deskripsi</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">{{ $product->description }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Harga (Rp)</label>
                <input type="number" name="price" value="{{ intval($product->price) }}" required min="0" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Stok (Pcs)</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required min="0" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; color: var(--admin-text-muted); font-size: 14px;">Path Gambar (misal: brand/ysl.png)</label>
            <input type="text" name="image" value="{{ $product->image }}" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: #fff; border-radius: 6px; outline: none;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; color: #fff;">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} style="width: 16px; height: 16px;">
                Aktif (Tampilkan di website)
            </label>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" style="background: var(--admin-primary); color: #000; border: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; cursor: pointer;">Update Produk</button>
            <a href="{{ route('admin.products.index') }}" style="background: transparent; color: var(--admin-text); border: 1px solid var(--admin-border); padding: 12px 24px; border-radius: 6px; text-decoration: none; display: flex; align-items: center;">Batal</a>
        </div>
    </form>
</div>
@endsection

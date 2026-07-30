@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin ARVEN')
@section('header-title', 'Kelola Produk')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Daftar Produk Parfum</h2>
        <a href="{{ route('admin.products.create') }}" style="background: var(--admin-primary); color: #000; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 600;">+ Tambah Produk</a>
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
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Produk</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Brand</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Harga</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Stok</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Status</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px;">
                            @else
                                <div style="width: 40px; height: 40px; background: #333; display: flex; align-items: center; justify-content: center; border-radius: 4px;">-</div>
                            @endif
                            <div>
                                <div style="font-weight: 500;">{{ $product->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 15px; color: var(--admin-text-muted);">{{ $product->brand->name }}</td>
                    <td style="padding: 15px;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td style="padding: 15px;">
                        @if($product->stock > 5)
                            <span style="color: #4ade80;">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span style="color: #fbbf24;">{{ $product->stock }} (Menipis)</span>
                        @else
                            <span style="color: #ef4444;">Habis</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if($product->is_active)
                            <span style="background: rgba(74, 222, 128, 0.1); color: #4ade80; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Aktif</span>
                        @else
                            <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.products.edit', $product) }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 13px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center; color: var(--admin-text-muted);">Belum ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

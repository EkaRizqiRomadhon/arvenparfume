@extends('layouts.admin')

@section('title', 'Kelola Brand - Admin ARVEN')
@section('header-title', 'Kelola Brand')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h2 class="card-title">Daftar Brand</h2>
        <a href="{{ route('admin.brands.create') }}" style="background: var(--admin-primary); color: #000; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 600;">+ Tambah Brand</a>
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
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Logo</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Nama Brand</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Total Produk</th>
                    <th style="padding: 15px; color: var(--admin-text-muted); font-weight: 500; font-size: 14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                    <td style="padding: 15px;">
                        @if($brand->image)
                            <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" style="width: 50px; height: 50px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #333; display: flex; align-items: center; justify-content: center; border-radius: 4px;">-</div>
                        @endif
                    </td>
                    <td style="padding: 15px; font-weight: 500;">{{ $brand->name }}</td>
                    <td style="padding: 15px; color: var(--admin-text-muted);">{{ $brand->products_count }} produk</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.brands.edit', $brand) }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;">Edit</a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Hapus brand ini beserta semua produknya?');">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 13px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: var(--admin-text-muted);">Belum ada brand</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', $brand->name . ' - Koleksi Parfum ARVEN')
@section('description', $brand->description)

@section('content')
<section class="page-container">
  {{-- Brand Header --}}
  <div style="text-align: center; margin-bottom: 40px;">
    @if($brand->image)
      <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" style="height: 70px; object-fit: contain; margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;">
    @endif
    <h1>{{ $brand->name }}<br>Parfume Collection</h1>
    @if($brand->description)
      <p style="color: #888; margin-top: 10px; max-width: 500px; margin-left: auto; margin-right: auto;">{{ $brand->description }}</p>
    @endif
    @php $activeProducts = $products->where('is_active', true); @endphp
    <p style="color: #a38b5d; font-size: 14px; margin-top: 12px; letter-spacing: 1px;">
      {{ $activeProducts->count() }} produk tersedia
    </p>
  </div>

  {{-- Product Grid --}}
  <div class="perfume-grid">
    @forelse($activeProducts as $product)
    <div class="perfume-card">
      @if($product->image)
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
      @else
        <div style="width:100%;height:200px;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;border-radius:8px;color:#555;">
          Tidak ada gambar
        </div>
      @endif

      <h3>{{ $product->name }}</h3>
      <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
      <p style="font-size: 13px; color: #aaa; margin-bottom: 8px;">{{ $product->description }}</p>

      @if($product->stock > 5)
        <p style="font-size: 11px; font-weight: 700; color: #4ade80; margin-bottom: 6px;">Stok tersedia ({{ $product->stock }})</p>
      @elseif($product->stock > 0)
        <p style="font-size: 11px; font-weight: 700; color: #fbbf24; margin-bottom: 6px;">Stok terbatas ({{ $product->stock }} tersisa)</p>
      @else
        <p style="font-size: 11px; font-weight: 700; color: #ef4444; margin-bottom: 6px;">Stok habis</p>
      @endif

      @if($product->stock > 0)
        <button
          class="add-to-cart"
          data-id="{{ $product->id }}"
          data-name="{{ $product->name }}"
          data-price="{{ intval($product->price) }}"
          data-img="{{ $product->image ? asset($product->image) : '' }}"
        >
          Tambah ke Keranjang
        </button>
      @else
        <button disabled style="opacity:0.4;cursor:not-allowed;background:#555;border:none;padding:10px 20px;color:#fff;width:100%;border-radius:6px;">
          Stok Habis
        </button>
      @endif
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px;color:#888;">
      <p style="font-size: 16px; margin-bottom: 15px;">Belum ada produk untuk brand ini.</p>
      <a href="{{ route('koleksi') }}" style="color:#a38b5d;text-decoration:none;">← Kembali ke koleksi</a>
    </div>
    @endforelse
  </div>

  <div style="text-align:center;margin-top:40px;">
    <a href="{{ route('koleksi') }}" style="color:#a38b5d;text-decoration:none;font-size:14px;">← Kembali ke semua brand</a>
  </div>
</section>
@endsection

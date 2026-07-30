@extends('layouts.app')

@section('title', 'Koleksi Brand - ARVEN PARFUME')
@section('description', 'Temukan 6 koleksi parfum mewah dari brand ternama dunia di ARVEN PARFUME.')

@section('content')
  <main class="brand-section">
    <h1>PILIH BRAND PARFUM</h1>

    <div class="brand-grid">
      @forelse($brands as $brand)
      <a href="{{ url('/koleksi/' . $brand->slug) }}" class="brand-card">
        <div class="brand-card-inner">
          @if($brand->image)
            <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }} Brand" />
          @endif
          <h3>{{ $brand->name }}</h3>
          <p>{{ $brand->description }}</p>
          @if($brand->products_count > 0)
            <span style="font-size: 12px; color: #a38b5d; display: block; margin-top: 8px;">{{ $brand->products_count }} produk tersedia</span>
          @endif
        </div>
      </a>
      @empty
      <p style="color: #888; text-align: center; grid-column: 1/-1;">Belum ada brand tersedia.</p>
      @endforelse
    </div>
  </main>

  <section class="contact-section">
    <h2>HUBUNGI KAMI</h2>
    <div class="contact-grid">
      <div class="contact-item">
        <i class="fas fa-phone"></i>
        <h3>Telepon</h3>
        <p>Layanan Pelanggan:</p>
        <p>+62 812-345-6789 (WhatsApp)</p>
      </div>

      <div class="contact-item">
        <i class="fas fa-map-marker-alt"></i>
        <h3>Alamat Kantor Pusat</h3>
        <p>Jl. Balai pemuda No. 19-20</p>
        <p>Tegalsari, Surabaya</p>
      </div>

      <div class="contact-item">
        <i class="fas fa-share-alt"></i>
        <h3 style="margin-bottom: 20px">Media Sosial</h3>
        <div class="social-icons" style="flex-direction: column; gap: 15px">
          <a href="https://www.instagram.com/arvenparfume/" target="_blank" aria-label="Instagram"
            style="display:flex;align-items:center;justify-content:center;gap:10px;font-size:16px;text-decoration:none;">
            <i class="fab fa-instagram" style="font-size:24px"></i>
            @@arvenparfume
          </a>
          <a href="https://www.tiktok.com/@arvenparfume" target="_blank" aria-label="TikTok"
            style="display:flex;align-items:center;justify-content:center;gap:10px;font-size:16px;text-decoration:none;">
            <i class="fab fa-tiktok" style="font-size:24px"></i>
            @@arvenparfume
          </a>
        </div>
        <p style="margin-top:15px">Ikuti kami untuk update terbaru.</p>
      </div>
    </div>
  </section>
@endsection

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'ARVEN PARFUME - A Classy Perfume')</title>
    <meta name="description" content="@yield('description', 'Temukan koleksi parfum elegan dan berkelas di ARVEN PARFUME, Surabaya.')" />

    {{-- Vite mem-bundle semua CSS dan JS menjadi satu file hashed --}}
    @vite(['resources/css/arven.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @stack('head')

    <script>
      // Diletakkan di <head> agar terbaca sebelum modul Vite dieksekusi.
      window.isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    </script>
  </head>
  <body>
    {{-- ── HEADER & NAV (sama di semua halaman) ──────────────────────── --}}
    <header id="siteHeader">
      <div class="logo">
        <a href="{{ url('/') }}">ARVEN PARFUME</a>
      </div>

      <div class="header-right-nav">
        <nav>
          <ul>
            <li><a href="{{ url('/') }}">BERANDA</a></li>
            <li><a href="{{ url('/about') }}">TENTANG KAMI</a></li>
            <li><a href="{{ url('/koleksi') }}">KOLEKSI</a></li>
            <li><a href="{{ url('/contact') }}">KONTAK</a></li>
            <li>
              <a href="{{ url('/cart') }}" class="icon" title="Keranjang"
                style="position:relative;text-decoration:none;color:inherit;display:flex;align-items:center;">
                <i class="fas fa-shopping-cart"></i>
                <span id="cartBadge" class="cart-badge"
                  style="display:none;position:absolute;top:-8px;right:-8px;
                         background:#a38b5d;color:#000;border-radius:50%;
                         font-size:10px;padding:0;width:16px;height:16px;
                         justify-content:center;align-items:center;font-weight:bold;">
                  0
                </span>
              </a>
            </li>
            @auth
            <li>
              <a href="{{ route('checkout.history') }}" class="icon" title="Riwayat Transaksi"
                style="text-decoration:none;color:inherit;display:flex;align-items:center;">
                <i class="fas fa-history"></i>
              </a>
            </li>
            <li>
              <a href="{{ url('/profile') }}" class="icon" title="Profil Saya"
                style="text-decoration:none;color:inherit;display:flex;align-items:center;">
                <i class="fas fa-user"></i>
              </a>
            </li>
            @endauth

            {{-- ── Tombol Auth: SSR Laravel menggantikan auth.js lama ──────────── --}}
            @auth
              <li style="display: flex; align-items: center; gap: 20px; margin-left: 20px;">
                <span style="color: #c4a56a; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">
                  Halo, {{ explode(' ', Auth::user()->full_name)[0] }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                  @csrf
                  <button type="submit" style="
                      background: transparent;
                      border: 1.5px solid #c4a56a;
                      color: #c4a56a;
                      padding: 8px 20px;
                      border-radius: 8px;
                      cursor: pointer;
                      font-size: 12px;
                      font-weight: 700;
                      letter-spacing: 1px;
                      text-transform: uppercase;
                      transition: all 0.3s ease;
                      font-family: inherit;
                  " 
                  onmouseover="this.style.background='#c4a56a'; this.style.color='#161616';"
                  onmouseout="this.style.background='transparent'; this.style.color='#c4a56a';">
                    LOGOUT
                  </button>
                </form>
              </li>
            @else
              <li style="margin-left: 20px;">
                <a href="{{ route('login') }}" style="
                    background: linear-gradient(135deg, #c4a56a, #a38b5d);
                    color: #161616;
                    padding: 10px 24px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-size: 12px;
                    font-weight: 800;
                    letter-spacing: 1.2px;
                    text-transform: uppercase;
                    transition: all 0.3s ease;
                    display: inline-block;
                    box-shadow: 0 4px 12px rgba(196, 165, 106, 0.3);
                "
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 18px rgba(196, 165, 106, 0.4)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(196, 165, 106, 0.3)';">
                  LOGIN
                </a>
              </li>
            @endauth

          </ul>
        </nav>
        <div class="header-icons"></div>
      </div>
    </header>


    @yield('content')

    @stack('scripts')

    <script>
      window.showToast = function(message, type = 'error') {
          const toast = document.createElement('div');
          toast.style.position = 'fixed';
          toast.style.bottom = '20px';
          toast.style.right = '20px';
          toast.style.padding = '15px 25px';
          toast.style.background = type === 'error' ? '#ef4444' : '#10b981';
          toast.style.color = '#fff';
          toast.style.borderRadius = '8px';
          toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
          toast.style.zIndex = '9999';
          toast.style.fontFamily = 'Inter, sans-serif';
          toast.style.fontSize = '14px';
          toast.style.transition = 'all 0.3s ease';
          toast.style.transform = 'translateY(20px)';
          toast.style.opacity = '0';
          toast.innerText = message;
          
          document.body.appendChild(toast);
          
          // Animate in
          setTimeout(() => {
              toast.style.transform = 'translateY(0)';
              toast.style.opacity = '1';
          }, 10);
          
          // Animate out
          setTimeout(() => {
              toast.style.transform = 'translateY(20px)';
              toast.style.opacity = '0';
              setTimeout(() => toast.remove(), 300);
          }, 6000);
      };
    </script>
  </body>
</html>

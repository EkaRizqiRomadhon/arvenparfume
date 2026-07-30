@extends('layouts.app')

@section('title', 'Keranjang Belanja - ARVEN PARFUME')
@section('description', 'Review koleksi parfum pilihan Anda sebelum melakukan checkout.')

@section('content')
  <main class="container">
    <h1 class="page-title">Keranjang Belanja</h1>
    <div class="sub-title">
      Review item pilihan eksklusif Anda sebelum checkout.
    </div>

    <div class="cart-wrap">
      <section class="cart-list" id="cartList">
        <div class="empty-state">Memuat keranjang...</div>
      </section>

      <aside class="cart-summary" id="cartSummary">
        <h2>Ringkasan Pesanan</h2>

        <div class="summary-row">
          <div>Subtotal</div>
          <div id="subtotalText">Rp 0</div>
        </div>

        <div class="summary-row">
          <div>Pajak &amp; Layanan</div>
          <div id="taxText">Rp 0</div>
        </div>

        <div class="summary-row total">
          <div>Total Estimasi</div>
          <div id="totalText">Rp 0</div>
        </div>

        <button id="checkoutBtn" class="btn btn-primary" data-auth="{{ Auth::check() ? 'true' : 'false' }}">Secure Checkout</button>
        <button id="clearBtn" class="btn btn-ghost">Kosongkan Keranjang</button>
      </aside>
    </div>

    <!-- Modal Simulasi Pembayaran -->
    <div id="paymentModal" class="payment-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: #1a1a1a; width: 100%; max-width: 400px; border-radius: 12px; padding: 25px; border: 1px solid rgba(212, 175, 55, 0.3); text-align: center; position: relative;">
            <button id="closeModalBtn" style="position: absolute; top: 15px; right: 20px; background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">✕</button>
            
            <h2 style="color: #d4af37; margin-bottom: 5px; font-size: 20px;">ARVEN PAY</h2>
            <p style="color: #aaa; font-size: 14px; margin-bottom: 25px;">Simulasi Payment Gateway Otomatis</p>
            
            <div style="font-size: 14px; color: #fff; margin-bottom: 10px;">Total Tagihan:</div>
            <div id="modalTotalText" style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Rp 0</div>

            <div style="display: grid; gap: 12px; text-align: left;">
                <button class="pay-method-btn" onclick="processSimulatedPayment('QRIS')" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 8px; color: #fff; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: 0.3s;">
                    <span>QRIS (OVO, GoPay, Dana)</span>
                    <span style="color: #d4af37;">▶</span>
                </button>
                <button class="pay-method-btn" onclick="processSimulatedPayment('Virtual Account BCA')" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 8px; color: #fff; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: 0.3s;">
                    <span>Virtual Account BCA</span>
                    <span style="color: #d4af37;">▶</span>
                </button>
                <button class="pay-method-btn" onclick="processSimulatedPayment('Virtual Account Mandiri')" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 8px; color: #fff; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: 0.3s;">
                    <span>Virtual Account Mandiri</span>
                    <span style="color: #d4af37;">▶</span>
                </button>
            </div>

            <div id="paymentLoading" style="display: none; margin-top: 20px;">
                <div style="color: #d4af37; margin-bottom: 10px;">Memproses Pembayaran...</div>
                <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                    <div style="width: 50%; height: 100%; background: #d4af37; animation: loadingBar 1s infinite alternate;"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pay-method-btn:hover { background: rgba(212, 175, 55, 0.1) !important; border-color: #d4af37 !important; }
        @keyframes loadingBar { 0% { transform: translateX(-100%); } 100% { transform: translateX(200%); } }
    </style>

    <script>
    // Fallback: Memastikan fungsi pemanggilan API terdaftar meskipun ada cache pada file JS luar
    window.processSimulatedPayment = function(method) {
        const loading = document.getElementById('paymentLoading');
        const buttons = document.querySelectorAll('.pay-method-btn');
        
        // Ambil data dari localStorage (sama seperti di cart.js)
        const cart = JSON.parse(localStorage.getItem('arven_cart_v1') || '[]');
        
        if (cart.length === 0) return alert("Keranjang kosong");

        buttons.forEach(btn => btn.style.display = 'none');
        loading.style.display = 'block';
        
        fetch('/checkout/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cart: cart })
        })
        .then(response => response.json())
        .then(data => {
            if (data.snapToken) {
                alert(`✅ Checkout Berhasil dibuat!`);
                localStorage.removeItem('arven_cart_v1');
                window.location.href = '/';
            } else {
                alert("Gagal: " + (data.error || "Terjadi kesalahan"));
                buttons.forEach(btn => btn.style.display = 'flex');
                loading.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Kesalahan koneksi ke server.");
            buttons.forEach(btn => btn.style.display = 'flex');
            loading.style.display = 'none';
        });
    };
    </script>
  </main>
@endsection

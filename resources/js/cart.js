// Config & Utils
const STORAGE_KEY = 'arven_cart_v1';

// Format Rupiah: Rp 1.000.000
const currency = (n) => {
  return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
};

// Data Management
function readCart() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    return raw ? JSON.parse(raw) : [];
  } catch (e) {
    return [];
  }
}

function writeCart(cart) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
  renderCart();
  updateBadge();
}

function getCartCount() {
  return readCart().reduce((s, i) => s + (i.qty || 0), 0);
}

// Global Actions

// Ubah kuantitas
window.changeQty = function(id, delta) {
  const cart = readCart();
  const idx = cart.findIndex(i => i.id == id);
  if (idx >= 0) {
    // Minimal 1
    cart[idx].qty = Math.max(1, (cart[idx].qty || 1) + delta);
    writeCart(cart);
  }
};

// Hapus item
window.removeItem = function(id) {
  const cart = readCart().filter(i => i.id != id);
  writeCart(cart);
};

// Kosongkan keranjang
function clearCart() {
  localStorage.removeItem(STORAGE_KEY);
  renderCart();
  updateBadge();
}

// UI Updates

function updateBadge() {
  const count = getCartCount();
  const badge = document.getElementById('cartBadge');
  
  if (badge) {
    if (count > 0) {
      badge.style.display = 'flex';
      badge.textContent = count;
    } else {
      badge.style.display = 'none';
    }
  }
}

function renderCart() {
  const container = document.getElementById('cartList');
  if (!container) return;

  const cart = readCart();

  // 1. Keranjang kosong
  if (!cart.length) {
    container.innerHTML = `
      <div class="empty-state">
        <h3 style="color:#fff; margin-bottom:10px;">Keranjang Anda Kosong</h3>
        <p>Temukan koleksi eksklusif kami sekarang.</p>
        <a href="/koleksi" class="btn btn-primary" style="display:inline-block; width:auto; margin-top:20px; padding:10px 30px;">Belanja Sekarang</a>
      </div>`;
    
    // Reset ringkasan
    updateSummary(0);
    return;
  }

  // 2. Render item
  container.innerHTML = cart.map(item => {
    const subtotal = item.price * item.qty;
    // Hindari XSS
    const safeName = item.name.replace(/"/g, '&quot;'); 

    return `
      <div class="cart-item">
        <div class="item-thumb">
          ${item.image ? `<img src="${item.image}" alt="${safeName}">` : ''}
        </div>
        
        <div class="item-info">
          <h3>${safeName}</h3>
          <div class="price-row">
            ${currency(item.price)}
          </div>
          
          <div class="qty-controls">
            <button onclick="changeQty('${item.id}', -1)">−</button>
            <span class="qty-value">${item.qty}</span>
            <button onclick="changeQty('${item.id}', 1)">+</button>
          </div>
        </div>

        <div class="item-remove" style="text-align:right">
          <button class="remove-btn" onclick="removeItem('${item.id}')" title="Hapus">✕</button>
          <div class="subtotal" style="margin-top:20px;">${currency(subtotal)}</div>
        </div>
      </div>
    `;
  }).join('');

  // 3. Update ringkasan
  const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
  updateSummary(subtotal);
}

function updateSummary(subtotal) {
  const tax = subtotal * 0.0; // Pajak 0%
  const total = subtotal + tax;

  const elSub = document.getElementById('subtotalText');
  const elTax = document.getElementById('taxText');
  const elTot = document.getElementById('totalText');

  if(elSub) elSub.textContent = currency(subtotal);
  if(elTax) elTax.textContent = currency(tax);
  if(elTot) elTot.textContent = currency(total);
}

// Initialization

document.addEventListener('DOMContentLoaded', () => {
  // Render awal
  renderCart();
  updateBadge();

  // 1. Header Scroll Effect
  window.addEventListener("scroll", function() {
    const header = document.getElementById("mainHeader");
    if (header) {
      if (window.scrollY > 50) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    }
  });

  // 2. Button Listeners
  const clearBtn = document.getElementById('clearBtn');
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      if(confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) clearCart();
    });
  }

  const checkoutBtn = document.getElementById('checkoutBtn');
  const modal = document.getElementById('paymentModal');
  const closeModalBtn = document.getElementById('closeModalBtn');
  
  if (checkoutBtn && modal) {
    checkoutBtn.addEventListener('click', () => {
       const isAuth = checkoutBtn.getAttribute('data-auth') === 'true' || window.isLoggedIn;
       if (!isAuth) {
           if (typeof window.showToast === 'function') {
               window.showToast("Silahkan login terlebih dahulu", "error");
           } else {
               alert("Silahkan login terlebih dahulu");
           }
           // Redirect ke halaman login otomatis
           window.location.href = '/login';
           return;
       }

       const cart = readCart();
       if(cart.length === 0) return alert("Keranjang kosong");
       
       // Hitung total untuk di modal
       const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
       document.getElementById('modalTotalText').textContent = currency(subtotal);
       
       // Tampilkan modal
       modal.style.display = 'flex';
    });
    
    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });
  }

  // Fungsi yang dipanggil dari tombol di dalam modal
  window.processSimulatedPayment = function(method) {
      const loading = document.getElementById('paymentLoading');
      const buttons = document.querySelectorAll('.pay-method-btn');
      const cart = readCart();
      
      if (cart.length === 0) return alert("Keranjang kosong");

      // Sembunyikan tombol, tampilkan loading
      buttons.forEach(btn => btn.style.display = 'none');
      loading.style.display = 'block';
      
      // Simpan riwayat pesanan ke database
      fetch('/checkout/process', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
          },
          body: JSON.stringify({ cart: cart })
      })
      .then(response => {
          if (response.status === 422) {
              return response.json().then(data => {
                  // Stok habis dari backend
                  const msg = data.error || 'Beberapa produk tidak tersedia.';
                  if (typeof window.showToast === 'function') {
                      window.showToast(msg, 'error');
                  } else {
                      alert(msg);
                  }
                  buttons.forEach(btn => btn.style.display = 'flex');
                  loading.style.display = 'none';
                  if (modal) modal.style.display = 'none';
                  throw new Error('out_of_stock'); // stop chain
              });
          }
          return response.json();
      })
      .then(data => {
          if (!data) return; // sudah dihandle di atas
          if (data.snapToken) {
              // Simulasi: dianggap sukses
              if (typeof window.showToast === 'function') {
                  window.showToast('Pesanan berhasil dibuat', 'success');
              } else {
                  alert('✅ Pesanan berhasil dibuat');
              }
              
              // Kosongkan keranjang & tutup modal
              clearCart();
              if (document.getElementById('paymentModal')) {
                  document.getElementById('paymentModal').style.display = 'none';
              }
          } else {
              const errMsg = data.error || 'Gagal memproses checkout';
              if (typeof window.showToast === 'function') {
                  window.showToast(errMsg, 'error');
              } else {
                  alert(errMsg);
              }
              buttons.forEach(btn => btn.style.display = 'flex');
              loading.style.display = 'none';
          }
      })
      .catch(error => {
          if (error.message === 'out_of_stock') return;
          console.error('Error:', error);
          if (typeof window.showToast === 'function') {
              window.showToast('Terjadi kesalahan saat menghubungi server.', 'error');
          } else {
              alert('Terjadi kesalahan saat menghubungi server.');
          }
          buttons.forEach(btn => btn.style.display = 'flex');
          loading.style.display = 'none';
      });
  };

  // 3. Add to Cart Listeners (Brand Pages)
  window.addToCart = function(id, name, price, image) {
    const cart = readCart();
    const existing = cart.find(i => i.id === id);
    if (existing) {
      existing.qty += 1;
    } else {
      cart.push({ id, name, price: parseInt(price), image, qty: 1 });
    }
    writeCart(cart);
    if (typeof window.showToast === 'function') {
      window.showToast(`${name} ditambahkan ke keranjang!`, 'success');
    }
  };

  const addToCartBtns = document.querySelectorAll('.add-to-cart');
  addToCartBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const id    = this.dataset.id;
      const name  = this.dataset.name;
      const price = this.dataset.price;
      const img   = this.dataset.img;

      // Cek stok real-time ke backend sebelum tambah ke keranjang
      fetch(`/api/stock/${id}`, {
        headers: { 'Accept': 'application/json' }
      })
      .then(r => r.json())
      .then(data => {
        if (data.stock <= 0) {
          if (typeof window.showToast === 'function') {
            window.showToast('Maaf, produk ini telah habis stoknya!', 'error');
          }
          // Disable tombol & update teks
          this.disabled = true;
          this.textContent = 'Stok Habis';
          this.style.opacity = '0.4';
          this.style.cursor = 'not-allowed';
          return;
        }
        window.addToCart(id, name, price, img);
      })
      .catch(() => {
        // Jika API tidak bisa diakses, tetap izinkan tambah (fallback)
        window.addToCart(id, name, price, img);
      });
    });
  });
});
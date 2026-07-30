## Backend Feature Migration

Migrasikan fitur backend dari proyek Arven Parfum ke proyek ini.

### Fitur yang harus dibuat

1. **Toast Notification Support**
- Kirim response yang mudah digunakan frontend untuk menampilkan toast.
- Kondisi:
  - Item berhasil ditambahkan ke keranjang
  - Checkout berhasil
  - Checkout gagal
  - Login diperlukan
  - Validasi gagal

2. **Authentication**
- Checkout hanya dapat dilakukan oleh user yang sudah login.
- Jika belum login, return HTTP 401 dengan pesan yang sesuai.

3. **Checkout**
- Buat endpoint checkout.
- Validasi alamat, produk, total harga, dan metode pembayaran.
- Simpan status checkout.

4. **Payment Simulation**
- Buat simulasi pembayaran seperti payment gateway.
- Status yang didukung:
  - pending
  - success
  - failed
- Response minimal:
  - transaction_id
  - status
  - payment_method
  - amount
  - message

5. **Checkout Status**
Gunakan status:
- cart
- checkout_in_progress
- payment_pending
- payment_success
- payment_failed

### Endpoint

- POST /api/checkout
- POST /api/checkout/payment-simulate
- GET /api/checkout/status/{id}
- GET /api/user/cart

### Requirement

- Gunakan REST API yang konsisten.
- Validasi seluruh request.
- Return JSON yang rapi dan konsisten.
- Gunakan HTTP status code yang sesuai.
- Struktur kode harus clean, scalable, dan mudah dikembangkan.
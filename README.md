<div align="center">

# 🌸 Arven Parfum

**Platform E-Commerce Parfum Modern & Elegan Berbasis Laravel**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

> Toko parfum online eksklusif yang dirancang dengan estetika tinggi, sistem manajemen stok atomik berbasis transaksi database (*Pessimistic Locking*), manajemen keranjang belanja dinamis, autentikasi berbasis sesi aman, dan panel administrasi komprehensif.

</div>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Arsitektur & Keamanan Backend](#-arsitektur--keamanan-backend)
- [Tech Stack](#-tech-stack)
- [Struktur Proyek](#-struktur-proyek)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi & Setup](#-instalasi--setup)
- [Konfigurasi Environment](#-konfigurasi-environment)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Panduan Penggunaan & Route](#-panduan-penggunaan--route)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Proyek

**Arven Parfum** adalah platform e-commerce yang berfokus pada penjualan parfum mewah dan eksklusif. Aplikasi ini memadukan desain antarmuka modern yang responsif (*glassmorphism*, *micro-animations*, dan skema warna *luxury gold*) dengan arsitektur backend Laravel yang tangguh, aman, dan efisien.

Seluruh produk dan brand dikelola secara dinamis melalui basis data, serta dilindungi oleh mekanisme transaksi transaksi atomik untuk mencegah masalah *overselling* saat terjadi lonjakan pembelian secara bersamaan.

---

## ✨ Fitur Utama

### 🛍️ Pengalaman Pengguna & Katalog
- **Halaman Beranda Interaktif** — Tampilan hero parallax, produk unggulan, dan efek animasi halus.
- **Katalog Brand Dinamis** — Eksplorasi koleksi berdasarkan brand (Chanel, Dior, HMNS, Mykonos, Saff & Co, YSL).
- **Verifikasi Stok Real-Time** — Pengecekan ketersediaan stok melalui API sebelum produk ditambahkan ke keranjang.
- **Keranjang Belanja Dinamis** — Manajemen item berbasis `localStorage` dengan penanganan badge otomatis.
- **Checkout Atomik** — Transaksi pembayaran aman dengan pemberitahuan notifikasi toast responsif.
- **Riwayat Pesanan & Profil** — Pantau status pesanan dan perbarui profil pengguna/password.
- **Formulir Kontak** — Layanan pesan pengunjung langsung terintegrasi dengan backend.

### 🛡️ Panel Admin (CMS)
- **Dashboard Statistik** — Ringkasan jumlah pesanan, produk, brand, pesan kontak belum dibaca, dan pengguna aktif.
- **Manajemen Brand & Produk** — CRUD lengkap untuk data brand dan katalog parfum.
- **Manajemen Pesanan** — Pemantauan transaksi dan pembaruan status pesanan.
- **Manajemen Pesan Kontak** — Baca dan balas pesan dari pengunjung.
- **Manajemen Pengguna** — Atur status aktif/nonaktif pengguna serta reset password.

---

## 🔒 Arsitektur & Keamanan Backend

1. **Pessimistic Database Locking (`lockForUpdate`)**
   - Mencegah *race condition* dan *overselling* stok ketika beberapa pengguna melakukan checkout pada waktu yang bersamaan.
   - Menggunakan `DB::beginTransaction()` dan `DB::rollBack()` untuk menjamin integritas data transaksi.

2. **Session Persistence (Database Session Driver)**
   - Middleware API disesuaikan (`EncryptCookies`, `AddQueuedCookiesToResponse`) untuk menjaga sesi pengguna tetap valid dan aman saat melakukan fetch API latar belakang.

3. **Proteksi & Keamanan**
   - **Rate Limiting (`throttle:5,1`)** — Melindungi endpoint autentikasi dari serangan *brute-force*.
   - **Role-Based Access Control (RBAC)** — Proteksi route admin menggunakan `IsAdmin` middleware.
   - **Log Aktivitas (`ActivityLog`)** — Pencatatan log autentikasi pengguna tanpa mengganggu alur utama.

4. **Clean Code & Professional Documentation**
   - Kode ditulis dengan prinsip *Clean Code*, tanpa *dead code*, serta didokumentasikan dalam Bahasa Indonesia yang profesional dan teknis.

---

## 🧰 Tech Stack

| Kategori | Teknologi |
|---|---|
| **Framework Backend** | Laravel 12.x |
| **Bahasa Utama** | PHP 8.2+ |
| **Frontend Styling & Scripting** | Vanilla CSS, JavaScript (ES6+), Blade Engine |
| **Asset Bundler** | Vite 7.x |
| **Database** | MySQL / SQLite |
| **Session Driver** | Database Session |
| **Keamanan Auth** | Laravel Guard & Custom Middleware (`IsAdmin`) |

---

## 📁 Struktur Proyek

```
arven-parfum/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                  # Controller CRUD Admin (Brand, Product, Order, User, Contact)
│   │   │   ├── AdminController.php      # Dashboard statistik admin
│   │   │   ├── AuthController.php       # Login, Register, Logout
│   │   │   ├── CheckoutController.php   # Proses checkout atomik & riwayat pesanan
│   │   │   ├── ContactController.php    # Penanganan pesan kontak
│   │   │   └── ProfileController.php    # Pembaruan profil & password
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php              # Middleware hak akses admin
│   │   └── Requests/
│   │       └── StoreContactRequest.php  # Validasi form kontak
│   ├── Models/
│   │   ├── ActivityLog.php              # Log aktivitas user
│   │   ├── Brand.php                    # Model brand parfum
│   │   ├── Checkout.php                 # Transaksi checkout
│   │   ├── CheckoutItem.php             # Detail item per checkout
│   │   ├── ContactMessage.php           # Pesan kontak pengunjung
│   │   ├── Product.php                  # Model produk parfum & stok
│   │   └── User.php                     # Model pengguna & role
│   └── Services/
│       ├── AuthService.php              # Logging aktivitas autentikasi
│       └── ContactService.php           # Penanganan bisnis layanan kontak
├── bootstrap/
│   └── app.php                          # Konfigurasi middleware & exception handler
├── database/
│   ├── migrations/                      # Schema migrasi tabel database
│   └── seeders/                         # Seeder data brand & produk
├── resources/
│   ├── css/                             # Stylesheet utama (arven.css)
│   ├── js/                              # Script frontend (animation.js, cart.js, navbar.js)
│   └── views/                           # Blade templates & layout
├── routes/
│   ├── api.php                          # Endpoint API stok produk
│   └── web.php                          # Route aplikasi web & admin
└── vite.config.js                       # Konfigurasi bundler Vite
```

---

## ⚙️ Persyaratan Sistem

Pastikan perangkat Anda memenuhi persyaratan berikut:

- **PHP** >= 8.2 (ekstensi: `pdo`, `pdo_mysql` / `pdo_sqlite`, `mbstring`, `openssl`, `xml`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL / MariaDB** (atau SQLite untuk pengembangan lokal)

---

## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/EkaRizqiRomadhon/arvenparfume.git
cd arvenparfume
```

### 2. Instal Dependensi PHP & Node.js

```bash
# Instal paket PHP
composer install

# Instal paket Node.js
npm install
```

### 3. Salin & Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database & Seeder

Sesuaikan pengaturan koneksi database di file `.env`, kemudian jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

### 5. Build Asset Frontend

```bash
npm run build
```

---

## 🔧 Konfigurasi Environment

Contoh konfigurasi file `.env`:

```env
APP_NAME="Arven Parfum"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

# Konfigurasi Database (Contoh MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arven_parfum
DB_USERNAME=root
DB_PASSWORD=

# Session Driver (Wajib menggunakan database untuk persistensi terbaik)
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

## ▶️ Menjalankan Aplikasi

### Mode Pengembangan (Development)

Jalankan server Laravel di satu terminal:

```bash
php artisan serve
```

Jika melakukan perubahan pada file CSS/JS di `resources/`, jalankan Vite dev server di terminal terpisah:

```bash
npm run dev
```

Aplikasi dapat diakses melalui browser di: `http://127.0.0.1:8000`

---

## 📖 Panduan Penggunaan & Route

### 🌐 Route Publik
| Path | Method | Deskripsi |
|---|---|---|
| `/` | GET | Beranda utama |
| `/about` | GET | Halaman tentang Arven Parfum |
| `/koleksi` | GET | Katalog semua brand |
| `/koleksi/{brand}` | GET | Halaman produk dinamis per brand (contoh: `/koleksi/chanel`) |
| `/contact` | GET / POST | Halaman kontak & kirim pesan |
| `/cart` | GET | Halaman keranjang belanja |

### 🔑 Autentikasi & Pengguna
| Path | Method | Deskripsi |
|---|---|---|
| `/login` | GET / POST | Masuk ke akun (Rate limited: 5x/menit) |
| `/register` | GET / POST | Pendaftaran akun baru |
| `/logout` | POST | Keluar dari sesi |
| `/checkout/history` | GET | Riwayat transaksi pengguna (Perlu Login) |
| `/checkout/process` | POST | Proses transaksi checkout atomik (Perlu Login) |
| `/profile` | GET / PATCH | Kelola profil pengguna & ubah kata sandi |

### 🛠️ Route Admin (`/admin`)
| Path | Method | Deskripsi |
|---|---|---|
| `/admin/dashboard` | GET | Ringkasan statistik sistem |
| `/admin/brands` | Resource | Olah data brand parfum |
| `/admin/products` | Resource | Olah data katalog & stok produk |
| `/admin/orders` | GET / PATCH | Monitoring pesanan & ubah status |
| `/admin/contacts` | GET / PATCH | Kelola pesan masuk & balasan |
| `/admin/users` | GET / PATCH / DELETE | Manajemen akun pengguna & status |

### ⚡ API Endpoint
| Path | Method | Deskripsi |
|---|---|---|
| `/api/stock/{product}` | GET | Ambil sisa stok produk secara real-time |

---

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur baru: `git checkout -b feature/FiturBaru`
3. Commit perubahan Anda: `git commit -m 'feat: menambahkan fitur baru'`
4. Push ke branch: `git push origin feature/FiturBaru`
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<div align="center">

Dibuat dengan ❤️ oleh **Arven Parfum Team**

</div>

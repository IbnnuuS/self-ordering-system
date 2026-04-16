# 🍽️ Self Ordering System

Sistem self-ordering modern untuk restoran/cafe yang memungkinkan customer memesan sendiri melalui kiosk touchscreen, dengan integrasi payment gateway (QRIS & Cash), kitchen display, dan dashboard admin lengkap.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.0-38B2AC?style=flat&logo=tailwind-css&logoColor=white)

---

## ✨ Fitur Utama

### 🛒 Kiosk (Customer)
- **Touch-friendly interface** untuk pemesanan mandiri
- Tampilan menu dengan gambar (responsive)
- Keranjang belanja real-time
- Pilihan pembayaran: Cash atau QRIS
- Auto-print struk thermal (80mm)

### 💳 Payment Gateway
- **Midtrans Integration** (QRIS Dynamic)
- Sandbox & Production ready
- Auto-update status pembayaran
- Callback handler untuk notifikasi

### 🧾 Kasir
- Konfirmasi pembayaran cash
- Monitor semua order (pending/paid)
- Filter by payment method
- Auto-refresh setiap 15 detik

### 👨‍🍳 Kitchen Display
- Real-time order notification
- Status tracking (waiting/processing/done)
- Touch-friendly untuk mark done
- Auto-refresh order list

### 📊 Admin Dashboard
- **Dashboard Analytics:**
  - Total order & revenue hari ini
  - Order pending
  - Chart 7 hari terakhir
  - Top menu & payment split
  
- **Manajemen Menu:**
  - CRUD menu dengan upload gambar
  - Kategori (food/drink)
  - Status available/unavailable
  - Filter by kategori

- **Manajemen Kategori:**
  - CRUD kategori
  - Tipe makanan/minuman
  - Status aktif/nonaktif

- **Manajemen User:**
  - CRUD user admin
  - Authentication system

- **Laporan Lengkap:**
  - Laporan Penjualan (daily breakdown)
  - Laporan Menu (best seller)
  - Laporan Pembayaran (Cash vs QRIS)
  - Filter by date range

- **Settings:**
  - Store name, address, phone
  - WiFi SSID & password (untuk struk)

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12
- **Database:** MySQL 8.0
- **Frontend:** Blade Templates + Alpine.js
- **CSS:** Tailwind CSS
- **Payment:** Midtrans PHP SDK
- **Real-time:** Laravel Reverb (Broadcasting)
- **Icons:** Font Awesome 6

---

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL 8.0
- Web Server (Apache/Nginx) atau Laravel Valet/Laragon

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/self-ordering.git
cd self-ordering
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=self_ordering
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:
```bash
mysql -u root -p
CREATE DATABASE self_ordering;
exit;
```

### 5. Konfigurasi Midtrans (Opsional)
Daftar di [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com) dan dapatkan API keys.

Edit `.env`:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

### 6. Migrasi & Seeder
```bash
php artisan migrate --seed
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
npm run build
```

### 9. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## 🔑 Default Credentials

**Admin Login:**
- Email: `admin@selforder.com`
- Password: `password`

---

## 📱 Akses Aplikasi

| Role | URL | Deskripsi |
|------|-----|-----------|
| **Kiosk** | `/` | Customer self-ordering |
| **Admin** | `/admin` | Dashboard & management |
| **Kasir** | `/kasir` | Konfirmasi pembayaran |
| **Kitchen** | `/kitchen` | Kitchen display system |
| **Login** | `/login` | Admin authentication |

---

## 📸 Screenshots

### Kiosk (Customer View)
![Kiosk Menu](<img width="806" height="1638" alt="image" src="https://github.com/user-attachments/assets/74b7d4d6-66e4-4a8e-94b5-79d775e07a9d" />)
*Touch-friendly menu dengan gambar*

### Admin Dashboard
![Dashboard](<img width="2800" height="1608" alt="Macbook-Air-127 0 0 1" src="https://github.com/user-attachments/assets/0bf54d58-b8cc-4a52-89c2-c39b21ce43dc" />)
*Analytics & statistics*

### Laporan Penjualan
![Reports](<img width="2800" height="1608" alt="Macbook-Air-127 0 0 1 (1)" src="https://github.com/user-attachments/assets/8d97d6f7-8e9a-432d-af93-aafa73df43c6" />)
*Comprehensive sales reports*

### Kasir Display
![Kitchen](<img width="2800" height="1608" alt="Macbook-Air-127 0 0 1 (2)" src="https://github.com/user-attachments/assets/52360502-b766-4f80-a661-f6ee2704f227" />)
*Real-time order tracking*

### Kitchen Display
![Kitchen](<img width="2800" height="1608" alt="Macbook-Air-127 0 0 1 (3)" src="https://github.com/user-attachments/assets/8ea3926f-812b-4dc9-bdb4-80e4bde789a8" />)
*Real-time order tracking*

---

## 🎨 Fitur Tambahan

- ✅ Responsive design (mobile & desktop)
- ✅ Touch-friendly interface
- ✅ Auto-print thermal receipt (80mm)
- ✅ Real-time order updates
- ✅ Image upload untuk menu
- ✅ Barcode untuk cash payment
- ✅ WiFi info di struk
- ✅ Multi-language ready (ID)

---

## 🔧 Konfigurasi Production

### 1. Optimize untuk Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Set Environment
```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Setup Midtrans Production
```env
MIDTRANS_SERVER_KEY=your-production-server-key
MIDTRANS_CLIENT_KEY=your-production-client-key
MIDTRANS_IS_PRODUCTION=true
```

### 4. Setup Notification URL di Midtrans
Masuk ke [Midtrans Dashboard](https://dashboard.midtrans.com) → Settings → Configuration:
```
Payment Notification URL: https://yourdomain.com/payment/midtrans/callback
```

---

## 🐛 Troubleshooting

### Error: "Class 'Midtrans\Config' not found"
```bash
composer require midtrans/midtrans-php
```

### Error: Storage link tidak berfungsi
```bash
php artisan storage:link
```

### QRIS payment tidak update status
- Pastikan Midtrans Notification URL sudah diset
- Untuk localhost, gunakan ngrok: `ngrok http 8000`
- Set notification URL: `https://xxxx.ngrok.io/payment/midtrans/callback`

### Gambar menu tidak muncul
```bash
php artisan storage:link
chmod -R 775 storage
```

---

## 📝 Database Schema

### Tables
- `users` - Admin users
- `categories` - Menu categories (food/drink)
- `menus` - Menu items
- `orders` - Customer orders
- `order_items` - Order details
- `payments` - Payment transactions
- `settings` - System settings

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Midtrans](https://midtrans.com) - Payment Gateway
- [Font Awesome](https://fontawesome.com) - Icons
- [Alpine.js](https://alpinejs.dev) - JavaScript Framework

---


**⭐ Jangan lupa kasih star jika project ini membantu!**

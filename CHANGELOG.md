# Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2026-04-16

### Added
- 🎉 Initial release
- ✨ Kiosk self-ordering system with touch-friendly interface
- 💳 Payment integration (Cash & QRIS via Midtrans)
- 🧾 Auto-print thermal receipt (80mm)
- 👨‍🍳 Kitchen display system
- 💰 Cashier confirmation system
- 📊 Admin dashboard with analytics
- 🍽️ Menu management with image upload
- 📂 Category management (CRUD)
- 👥 User management
- 📈 Sales report with date filter
- 📊 Menu report (best seller)
- 💳 Payment report (Cash vs QRIS)
- ⚙️ Settings system (store info, WiFi)
- 🔐 Authentication & authorization
- 🌐 Responsive design (mobile & desktop)
- 🔄 Real-time order updates (Laravel Reverb)

### Features Detail

#### Kiosk
- Browse menu by category
- Add to cart with quantity
- View cart summary
- Choose payment method
- Print receipt with barcode (Cash) or QR code (QRIS)

#### Payment
- Midtrans QRIS integration
- Cash payment with barcode
- Auto-update payment status
- Callback handler for notifications

#### Kasir
- View all orders (pending/paid)
- Confirm cash payment
- Filter by payment method
- Auto-refresh every 15 seconds

#### Kitchen
- View incoming orders
- Mark order as done
- Real-time order updates
- Touch-friendly interface

#### Admin
- Dashboard with charts (7 days)
- Menu management (CRUD with image)
- Category management
- User management
- Sales report (daily breakdown)
- Menu report (ranking)
- Payment report (Cash vs QRIS)
- Settings (store info, WiFi)

### Tech Stack
- Laravel 11
- PHP 8.2
- MySQL 8.0
- Tailwind CSS
- Alpine.js
- Midtrans PHP SDK
- Laravel Reverb
- Font Awesome 6

---

## [Unreleased]

### Planned Features
- [ ] Export reports to Excel/PDF
- [ ] Multi-language support
- [ ] Email notifications
- [ ] SMS notifications
- [ ] Loyalty program
- [ ] Discount/promo system
- [ ] Table management
- [ ] Reservation system
- [ ] Multi-branch support

---

**Note:** This project follows [Semantic Versioning](https://semver.org/).

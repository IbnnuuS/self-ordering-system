# Contributing to Self Ordering System

Terima kasih telah tertarik untuk berkontribusi! 🎉

## 🚀 Cara Berkontribusi

### 1. Fork Repository
Klik tombol "Fork" di pojok kanan atas halaman GitHub.

### 2. Clone Fork Anda
```bash
git clone https://github.com/YOUR-USERNAME/self-ordering.git
cd self-ordering
```

### 3. Buat Branch Baru
```bash
git checkout -b feature/nama-fitur-anda
```

### 4. Install Dependencies
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

### 5. Buat Perubahan
- Tulis kode yang bersih dan mudah dibaca
- Follow Laravel best practices
- Tambahkan komentar jika diperlukan
- Test fitur yang dibuat

### 6. Commit Perubahan
```bash
git add .
git commit -m "feat: menambahkan fitur X"
```

**Commit Message Convention:**
- `feat:` untuk fitur baru
- `fix:` untuk bug fix
- `docs:` untuk dokumentasi
- `style:` untuk formatting
- `refactor:` untuk refactoring code
- `test:` untuk testing
- `chore:` untuk maintenance

### 7. Push ke GitHub
```bash
git push origin feature/nama-fitur-anda
```

### 8. Buat Pull Request
- Buka repository Anda di GitHub
- Klik "Compare & pull request"
- Isi deskripsi perubahan dengan jelas
- Submit pull request

## 📋 Guidelines

### Code Style
- Follow PSR-12 coding standard
- Use meaningful variable names
- Keep functions small and focused
- Add comments for complex logic

### Testing
- Test fitur sebelum submit PR
- Pastikan tidak ada breaking changes
- Test di berbagai browser (Chrome, Firefox, Safari)

### Documentation
- Update README.md jika menambah fitur baru
- Tambahkan komentar di kode jika diperlukan
- Update CHANGELOG.md

## 🐛 Melaporkan Bug

Jika menemukan bug, silakan buat [Issue](https://github.com/yourusername/self-ordering/issues) dengan informasi:
- Deskripsi bug
- Langkah untuk reproduce
- Expected behavior
- Screenshots (jika ada)
- Environment (OS, PHP version, Laravel version)

## 💡 Request Fitur

Punya ide fitur baru? Buat [Issue](https://github.com/yourusername/self-ordering/issues) dengan label "enhancement" dan jelaskan:
- Deskripsi fitur
- Use case
- Mockup/wireframe (jika ada)

## ❓ Pertanyaan

Jika ada pertanyaan, silakan:
- Buat [Discussion](https://github.com/yourusername/self-ordering/discussions)
- Atau email ke: your.email@example.com

## 🙏 Terima Kasih!

Kontribusi Anda sangat berarti untuk project ini! 🚀

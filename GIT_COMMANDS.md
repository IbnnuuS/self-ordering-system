# 📝 Git Commands Cheat Sheet

Panduan cepat untuk upload project ke GitHub.

## 🚀 First Time Upload

### 1. Inisialisasi Git (jika belum)
```bash
cd self-ordering
git init
```

### 2. Tambahkan Remote Repository
Buat repository baru di GitHub dulu, lalu:
```bash
git remote add origin https://github.com/USERNAME/REPO-NAME.git
```

### 3. Add & Commit Files
```bash
git add .
git commit -m "Initial commit: Self Ordering System v1.0"
```

### 4. Push ke GitHub
```bash
git branch -M main
git push -u origin main
```

---

## 🔄 Update Project (Setelah Ada Perubahan)

### 1. Cek Status
```bash
git status
```

### 2. Add Changes
```bash
# Add semua file
git add .

# Atau add file tertentu
git add path/to/file.php
```

### 3. Commit
```bash
git commit -m "feat: menambahkan fitur X"
```

### 4. Push
```bash
git push origin main
```

---

## 📋 Commit Message Convention

Gunakan format ini untuk commit message yang jelas:

```
<type>: <description>

[optional body]
```

**Types:**
- `feat:` - Fitur baru
- `fix:` - Bug fix
- `docs:` - Update dokumentasi
- `style:` - Formatting, missing semicolons, etc
- `refactor:` - Refactoring code
- `test:` - Adding tests
- `chore:` - Maintenance tasks

**Contoh:**
```bash
git commit -m "feat: tambah laporan penjualan"
git commit -m "fix: perbaiki bug payment QRIS"
git commit -m "docs: update README installation steps"
```

---

## 🌿 Branching

### Buat Branch Baru
```bash
git checkout -b feature/nama-fitur
```

### Pindah Branch
```bash
git checkout main
```

### Merge Branch
```bash
git checkout main
git merge feature/nama-fitur
```

### Hapus Branch
```bash
git branch -d feature/nama-fitur
```

---

## 🔙 Undo Changes

### Undo Last Commit (Keep Changes)
```bash
git reset --soft HEAD~1
```

### Undo Last Commit (Discard Changes)
```bash
git reset --hard HEAD~1
```

### Discard Changes in File
```bash
git checkout -- path/to/file.php
```

---

## 📥 Pull Latest Changes

```bash
git pull origin main
```

---

## 🏷️ Tagging (Versioning)

### Create Tag
```bash
git tag -a v1.0.0 -m "Release version 1.0.0"
```

### Push Tag
```bash
git push origin v1.0.0
```

### List Tags
```bash
git tag
```

---

## 🔍 Useful Commands

### View Commit History
```bash
git log --oneline
```

### View Changes
```bash
git diff
```

### View Remote URL
```bash
git remote -v
```

### Change Remote URL
```bash
git remote set-url origin https://github.com/NEW-USERNAME/NEW-REPO.git
```

---

## ⚠️ Important Notes

1. **Jangan commit file `.env`** - Sudah ada di `.gitignore`
2. **Jangan commit folder `vendor/` dan `node_modules/`** - Sudah di `.gitignore`
3. **Selalu pull sebelum push** jika kolaborasi dengan tim
4. **Gunakan branch** untuk fitur baru, jangan langsung ke `main`

---

## 🆘 Troubleshooting

### Error: "fatal: remote origin already exists"
```bash
git remote remove origin
git remote add origin https://github.com/USERNAME/REPO-NAME.git
```

### Error: "Updates were rejected"
```bash
git pull origin main --rebase
git push origin main
```

### Error: "Permission denied (publickey)"
Setup SSH key atau gunakan HTTPS URL.

---

## 📚 Resources

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Conventional Commits](https://www.conventionalcommits.org/)

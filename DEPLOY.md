# 🚀 Deployment Guide

Panduan untuk deploy Self Ordering System ke production.

## 📋 Pre-Deployment Checklist

- [ ] Test semua fitur di local
- [ ] Update `.env` dengan production values
- [ ] Setup database production
- [ ] Dapatkan Midtrans production keys
- [ ] Setup domain & SSL certificate
- [ ] Backup database (jika update)

---

## 🔧 Production Setup

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/self-ordering.git
cd self-ordering
```

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_DATABASE=your_production_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

MIDTRANS_SERVER_KEY=your-production-server-key
MIDTRANS_CLIENT_KEY=your-production-client-key
MIDTRANS_IS_PRODUCTION=true
```

### 4. Database Migration
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 5. Storage & Permissions
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Setup Midtrans Notification
Login ke [Midtrans Dashboard](https://dashboard.midtrans.com):
- Settings → Configuration
- Payment Notification URL: `https://yourdomain.com/payment/midtrans/callback`
- Finish Redirect URL: `https://yourdomain.com/payment/{order_id}/finish`

---

## 🌐 Web Server Configuration

### Apache (.htaccess)
Laravel sudah include `.htaccess` di folder `public/`.

Pastikan `mod_rewrite` enabled:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/self-ordering/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🔒 Security Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Use strong database password
- [ ] Enable HTTPS/SSL
- [ ] Setup firewall rules
- [ ] Disable directory listing
- [ ] Set proper file permissions (755 for folders, 644 for files)
- [ ] Keep Laravel & dependencies updated
- [ ] Setup backup automation

---

## 📊 Monitoring

### Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

### Database Backup (Cron Job)
```bash
# Add to crontab
0 2 * * * mysqldump -u user -p'password' database_name > /backup/db_$(date +\%Y\%m\%d).sql
```

### Disk Space
```bash
df -h
```

---

## 🔄 Update Deployment

### Pull Latest Changes
```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Restart Services
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

## 🆘 Troubleshooting

### 500 Internal Server Error
```bash
php artisan config:clear
php artisan cache:clear
chmod -R 775 storage bootstrap/cache
```

### Storage Link Not Working
```bash
php artisan storage:link
```

### Permission Denied
```bash
sudo chown -R www-data:www-data /var/www/self-ordering
sudo chmod -R 775 storage bootstrap/cache
```

### Database Connection Error
- Check `.env` database credentials
- Ensure MySQL is running: `sudo systemctl status mysql`
- Test connection: `mysql -u user -p`

---

## 📞 Support

Jika ada masalah saat deployment, buat [Issue](https://github.com/yourusername/self-ordering/issues) di GitHub.

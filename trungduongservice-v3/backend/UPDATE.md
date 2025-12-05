# 📦 HƯỚNG DẪN CÀI ĐẶT & CẬP NHẬT HZ - PHONE REPAIR SYSTEM

## 📋 MỤC LỤC

1. [Giới thiệu](#giới-thiệu)
2. [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
3. [Cài đặt trên XAMPP (Windows)](#cài-đặt-trên-xampp-windows)
4. [Cài đặt trên cPanel 11](#cài-đặt-trên-cpanel-11)
5. [Cài đặt trên VPS (Linux)](#cài-đặt-trên-vps-linux)
6. [Cài đặt trên aaPanel](#cài-đặt-trên-aapanel)
7. [Cập nhật từ phiên bản cũ](#cập-nhật-từ-phiên-bản-cũ)
8. [Cấu hình bổ sung](#cấu-hình-bổ-sung)
9. [Xử lý lỗi thường gặp](#xử-lý-lỗi-thường-gặp)

---

## GIỚI THIỆU

**HZ Phone Repair System** là hệ thống quản lý sửa chữa điện thoại được xây dựng trên:
- **Backend:** Laravel 11 + PHP 8.2+
- **Database:** MySQL 8.0+
- **Frontend:** HTML/CSS/JavaScript (Vanilla)
- **API:** RESTful API với Laravel Sanctum

### Tính năng chính

✅ Quản lý sản phẩm với nhiều bảng giá (giá bán, giá buôn, giá lẻ)
✅ Quản lý đơn hàng & POS
✅ Quản lý công nợ khách hàng + Phiếu thu
✅ Quản lý chi nhánh/kho hàng
✅ Quản lý tỷ giá đa loại tiền tệ
✅ Kiểm kê tồn kho
✅ Backup & Restore dữ liệu
✅ Phân quyền nhân viên (Admin/Staff/Viewer)
✅ Dashboard với biểu đồ Chart.js

---

## YÊU CẦU HỆ THỐNG

### Yêu cầu tối thiểu

| Thành phần | Yêu cầu |
|------------|---------|
| **PHP** | >= 8.2 |
| **MySQL** | >= 8.0 hoặc MariaDB >= 10.3 |
| **Composer** | >= 2.6 |
| **Web Server** | Apache 2.4+ hoặc Nginx 1.18+ |
| **RAM** | >= 512 MB (khuyến nghị 1 GB+) |
| **Disk** | >= 500 MB trống |
| **SSL** | Khuyến nghị (Let's Encrypt miễn phí) |

### PHP Extensions cần thiết

```ini
extension=pdo_mysql
extension=mbstring
extension=openssl
extension=tokenizer
extension=xml
extension=ctype
extension=json
extension=fileinfo
extension=bcmath
extension=zip
```

---

## CÀI ĐẶT TRÊN XAMPP (WINDOWS)

### Bước 1: Download & Cài đặt XAMPP

1. Download XAMPP PHP 8.2: https://www.apachefriends.org/download.html
2. Chạy installer, chọn:
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - ✅ phpMyAdmin
3. Cài vào `C:\xampp`

### Bước 2: Cài đặt Composer

1. Download Composer: https://getcomposer.org/Composer-Setup.exe
2. Chạy installer, chọn PHP từ XAMPP: `C:\xampp\php\php.exe`
3. Kiểm tra:
```cmd
composer --version
```

### Bước 3: Clone/Download source code

```cmd
REM Tạo thư mục
cd C:\xampp\htdocs

REM Clone từ GitHub
git clone https://github.com/huyhz123/Seo.git hz

REM Hoặc download ZIP và giải nén
REM Giải nén vào: C:\xampp\htdocs\hz\trungduongservice-v3\backend

REM Di chuyển vào thư mục
cd C:\xampp\htdocs\hz\trungduongservice-v3\backend
```

### Bước 4: Cài đặt dependencies

```cmd
REM Install Composer packages
composer install

REM Nếu lỗi, chạy:
composer install --ignore-platform-reqs
composer dump-autoload
```

### Bước 5: Cấu hình môi trường

```cmd
REM Copy file .env
copy .env.example .env

REM Generate app key
php artisan key:generate
```

Mở file `.env` và chỉnh sửa:

```env
APP_NAME=HZ
APP_ENV=local
APP_KEY=base64:... # Đã generate
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

### Bước 6: Tạo database

1. Mở phpMyAdmin: http://localhost/phpmyadmin
2. Click **New** (Mới)
3. Nhập tên database: `hz_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click **Create**

### Bước 7: Chạy migrations

```cmd
REM Tạo các bảng
php artisan migrate

REM Nếu muốn reset và chạy lại từ đầu
php artisan migrate:fresh

REM Chạy seeder để tạo dữ liệu mẫu
php artisan db:seed
```

**Thông tin đăng nhập mặc định:**
- Admin: `admin@hz.com` / `password`
- Staff: `staff@hz.com` / `password`

### Bước 8: Tạo thư mục storage

```cmd
REM Tạo các thư mục cần thiết
mkdir storage\framework\cache\data
mkdir storage\framework\sessions
mkdir storage\framework\views
mkdir storage\logs
mkdir bootstrap\cache
mkdir public\uploads
mkdir public\uploads\products

REM Set permissions (không bắt buộc trên Windows)
```

### Bước 9: Chạy ứng dụng

**Phương pháp 1: Dùng Apache XAMPP**

1. Start Apache và MySQL trong XAMPP Control Panel
2. Truy cập: `http://localhost/hz/trungduongservice-v3/backend/public/login.html`

**Phương pháp 2: Dùng PHP built-in server**

```cmd
php artisan serve

REM Truy cập: http://localhost:8000/login.html
```

### Bước 10: Cấu hình Apache Virtual Host (Khuyến nghị)

Mở file `C:\xampp\apache\conf\extra\httpd-vhosts.conf`, thêm:

```apache
<VirtualHost *:80>
    ServerName hz.local
    DocumentRoot "C:/xampp/htdocs/hz/trungduongservice-v3/backend/public"

    <Directory "C:/xampp/htdocs/hz/trungduongservice-v3/backend/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Thêm vào file `C:\Windows\System32\drivers\etc\hosts`:

```
127.0.0.1   hz.local
```

Restart Apache, truy cập: `http://hz.local/login.html`

---

## CÀI ĐẶT TRÊN CPANEL 11

### Bước 1: Upload source code

**Phương pháp 1: File Manager**

1. Đăng nhập cPanel
2. Vào **File Manager**
3. Navigate đến `public_html`
4. Upload file ZIP source code
5. Click chuột phải → **Extract**

**Phương pháp 2: FTP**

```bash
# Dùng FileZilla hoặc WinSCP
# Upload toàn bộ thư mục vào: /home/your_user/public_html
```

### Bước 2: Cài đặt Composer

```bash
# SSH vào hosting (nếu có)
cd public_html
curl -sS https://getcomposer.org/installer | php
php composer.phar install

# Hoặc nếu có composer global
composer install
```

**Nếu không có SSH:**

1. Cài Composer trên local
2. Chạy `composer install`
3. Upload thư mục `vendor` lên server qua FTP

### Bước 3: Tạo database

1. Trong cPanel → **MySQL Databases**
2. Tạo database mới: `yourusername_hz`
3. Tạo user: `yourusername_hzuser`
4. Mật khẩu: Tạo mật khẩu mạnh
5. Add user vào database với **ALL PRIVILEGES**

### Bước 4: Cấu hình .env

```env
APP_NAME=HZ
APP_ENV=production
APP_KEY=base64:... # Generate bằng php artisan key:generate trên local
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_hz
DB_USERNAME=yourusername_hzuser
DB_PASSWORD=your_strong_password

# cPanel 11 compatible
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
FILESYSTEM_DISK=local

SANCTUM_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com
```

### Bước 5: Generate APP_KEY

**Trên local:**
```cmd
php artisan key:generate --show

# Copy giá trị base64:xxx và paste vào .env trên server
```

### Bước 6: Chạy migrations qua SSH

```bash
cd /home/your_user/public_html

# Chạy migrations
php artisan migrate

# Chạy seeder
php artisan db:seed
```

**Nếu không có SSH:**

1. Import file SQL migration thủ công qua phpMyAdmin
2. Hoặc dùng web-based artisan executor

### Bước 7: Set permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/uploads

chown -R your_user:your_user storage
chown -R your_user:your_user bootstrap/cache
```

### Bước 8: Cấu hình domain

**Nếu dùng subdomain (hz.yourdomain.com):**

1. cPanel → **Subdomains**
2. Subdomain: `hz`
3. Document Root: `/public_html/public`

**Nếu dùng domain chính:**

Tạo file `.htaccess` trong `public_html`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Bước 9: SSL (Let's Encrypt)

1. cPanel → **SSL/TLS Status**
2. Chọn domain
3. Click **Run AutoSSL**

Sau khi có SSL, cập nhật `.env`:

```env
APP_URL=https://yourdomain.com
```

### Bước 10: Optimize for production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## CÀI ĐẶT TRÊN VPS (LINUX)

### Môi trường: Ubuntu 22.04 LTS + Nginx + MySQL + PHP 8.2

### Bước 1: Update hệ thống

```bash
sudo apt update
sudo apt upgrade -y
```

### Bước 2: Cài đặt Nginx

```bash
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl status nginx
```

### Bước 3: Cài đặt MySQL

```bash
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql

# Cấu hình bảo mật
sudo mysql_secure_installation

# Tạo database và user
sudo mysql
```

Trong MySQL console:

```sql
CREATE DATABASE hz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hzuser'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON hz_db.* TO 'hzuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Bước 4: Cài đặt PHP 8.2

```bash
# Thêm repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Cài PHP và extensions
sudo apt install php8.2-fpm php8.2-cli php8.2-common php8.2-mysql \
    php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml \
    php8.2-bcmath php8.2-tokenizer php8.2-fileinfo -y

# Kiểm tra
php -v
```

### Bước 5: Cài đặt Composer

```bash
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer --version
```

### Bước 6: Clone source code

```bash
cd /var/www
sudo git clone https://github.com/huyhz123/Seo.git hz
cd hz/trungduongservice-v3/backend

# Hoặc upload bằng SFTP/SCP
```

### Bước 7: Cài đặt dependencies

```bash
composer install --no-dev --optimize-autoloader
```

### Bước 8: Cấu hình .env

```bash
cp .env.example .env
nano .env
```

```env
APP_NAME=HZ
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=hzuser
DB_PASSWORD=your_strong_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

Generate key:

```bash
php artisan key:generate
```

### Bước 9: Set permissions

```bash
sudo chown -R www-data:www-data /var/www/hz
sudo chmod -R 755 /var/www/hz
sudo chmod -R 775 /var/www/hz/trungduongservice-v3/backend/storage
sudo chmod -R 775 /var/www/hz/trungduongservice-v3/backend/bootstrap/cache
```

### Bước 10: Chạy migrations

```bash
cd /var/www/hz/trungduongservice-v3/backend
php artisan migrate --force
php artisan db:seed --force
```

### Bước 11: Cấu hình Nginx

```bash
sudo nano /etc/nginx/sites-available/hz
```

Nội dung file:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/hz/trungduongservice-v3/backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;

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

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/hz /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Bước 12: Cài đặt SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

Chọn option **2** (Redirect HTTP to HTTPS)

### Bước 13: Cấu hình Firewall

```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable
sudo ufw status
```

### Bước 14: Optimize Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Bước 15: Setup Cron (cho scheduled tasks)

```bash
sudo crontab -e
```

Thêm dòng:

```cron
* * * * * cd /var/www/hz/trungduongservice-v3/backend && php artisan schedule:run >> /dev/null 2>&1
```

### Bước 16: Setup Supervisor (cho queue workers)

```bash
sudo apt install supervisor -y

sudo nano /etc/supervisor/conf.d/hz-worker.conf
```

Nội dung:

```ini
[program:hz-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/hz/trungduongservice-v3/backend/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/hz/trungduongservice-v3/backend/storage/logs/worker.log
```

Start supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start hz-worker:*
```

---

## CÀI ĐẶT TRÊN AAPANEL

aaPanel là bản quốc tế của BaoTa Panel, hỗ trợ quản lý VPS dễ dàng.

### Bước 1: Cài đặt aaPanel

```bash
# Ubuntu/Debian
wget -O install.sh http://www.aapanel.com/script/install-ubuntu_6.0_en.sh && sudo bash install.sh

# CentOS
yum install -y wget && wget -O install.sh http://www.aapanel.com/script/install_6.0_en.sh && bash install.sh
```

Sau khi cài xong, ghi lại:
- Panel URL: `http://your-ip:7800/xxx`
- Username: `xxx`
- Password: `xxx`

### Bước 2: Cài đặt môi trường LNMP

1. Đăng nhập vào aaPanel
2. Click **App Store**
3. Cài đặt:
   - **Nginx** 1.22+
   - **MySQL** 8.0+
   - **PHP** 8.2
   - **phpMyAdmin**

### Bước 3: Cài PHP Extensions

1. **Software Store** → **PHP 8.2** → **Settings**
2. Tab **Install Extensions**, enable:
   - opcache
   - fileinfo
   - bcmath
   - zip
   - mbstring
   - mysqli
   - pdo_mysql

### Bước 4: Tạo website

1. **Website** → **Add site**
2. Domain: `yourdomain.com`
3. Root Directory: `/www/wwwroot/yourdomain.com`
4. PHP Version: **PHP-82**
5. Create database: ✅ Yes
   - Database name: `hz_db`
   - User: `hz_user`
   - Password: Auto-generate
6. Click **Submit**

### Bước 5: Upload source code

**Phương pháp 1: Git**

```bash
cd /www/wwwroot/yourdomain.com
rm -rf *
git clone https://github.com/huyhz123/Seo.git .
cd trungduongservice-v3/backend
```

**Phương pháp 2: File Manager**

1. **Files** → Navigate to `/www/wwwroot/yourdomain.com`
2. Upload ZIP file
3. Extract

### Bước 6: Cài đặt Composer

```bash
cd /www/wwwroot/yourdomain.com/trungduongservice-v3/backend
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
```

### Bước 7: Cấu hình .env

```bash
cp .env.example .env
nano .env
```

```env
APP_NAME=HZ
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=hz_user
DB_PASSWORD=your_db_password # Lấy từ bước tạo database

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

Generate key:

```bash
php artisan key:generate
```

### Bước 8: Set web root

1. **Website** → Click domain → **Settings**
2. Tab **Site directory**
3. Running directory: `/public`
4. Save

### Bước 9: Chạy migrations

```bash
cd /www/wwwroot/yourdomain.com/trungduongservice-v3/backend
php artisan migrate --force
php artisan db:seed --force
```

### Bước 10: Set permissions

```bash
chown -R www:www /www/wwwroot/yourdomain.com
chmod -R 755 /www/wwwroot/yourdomain.com
chmod -R 775 /www/wwwroot/yourdomain.com/trungduongservice-v3/backend/storage
chmod -R 775 /www/wwwroot/yourdomain.com/trungduongservice-v3/backend/bootstrap/cache
```

### Bước 11: SSL

1. **Website** → Click domain → **Settings**
2. Tab **SSL**
3. Select **Let's Encrypt**
4. Click **Apply**

### Bước 12: Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## CẬP NHẬT TỪ PHIÊN BẢN CŨ

### Phương pháp 1: Git Pull (Khuyến nghị)

```bash
cd /path/to/project

# Backup database trước
php artisan db:backup # Nếu có package backup
mysqldump -u user -p hz_db > backup_$(date +%Y%m%d).sql

# Stash local changes
git stash

# Pull latest code
git pull origin claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E

# Update dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Re-cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Phương pháp 2: Chép đè file (Windows XAMPP)

```cmd
REM Backup database
cd C:\xampp\htdocs\hz\trungduongservice-v3\backend
php artisan tinker
DB::table('users')->get();
exit

REM Backup .env
copy .env .env.backup

REM Download version mới
REM Giải nén vào thư mục tạm: C:\temp\hz-new

REM Chép đè code (giữ nguyên .env và storage)
xcopy /E /Y C:\temp\hz-new\public\* C:\xampp\htdocs\hz\trungduongservice-v3\backend\public\
xcopy /E /Y C:\temp\hz-new\app\* C:\xampp\htdocs\hz\trungduongservice-v3\backend\app\
xcopy /E /Y C:\temp\hz-new\config\* C:\xampp\htdocs\hz\trungduongservice-v3\backend\config\
xcopy /E /Y C:\temp\hz-new\database\* C:\xampp\htdocs\hz\trungduongservice-v3\backend\database\

REM Chạy migrations mới
php artisan migrate --force

REM Clear cache
php artisan config:clear
php artisan cache:clear
```

### Phương pháp 3: Cập nhật chỉ frontend

Nếu chỉ có thay đổi HTML/CSS/JS:

```bash
# Chỉ cần copy thư mục public
cp -rf /path/to/new/public/* /path/to/old/public/

# Windows
xcopy /E /Y C:\temp\hz-new\public\* C:\xampp\htdocs\hz\backend\public\
```

---

## CẤU HÌNH BỔ SUNG

### 1. Tối ưu hiệu suất

**Caching:**

```bash
# Config cache
php artisan config:cache

# Route cache
php artisan route:cache

# View cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload -o
```

**OPcache (php.ini):**

```ini
[opcache]
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

### 2. Backup tự động

**Cron job (Linux):**

```cron
# Backup database mỗi ngày lúc 2 AM
0 2 * * * mysqldump -u user -p'password' hz_db | gzip > /backup/hz_$(date +\%Y\%m\%d).sql.gz

# Backup files mỗi tuần
0 3 * * 0 tar -czf /backup/hz_files_$(date +\%Y\%m\%d).tar.gz /var/www/hz
```

**Windows Task Scheduler:**

Tạo file `backup.bat`:

```bat
@echo off
set TIMESTAMP=%date:~-4%%date:~3,2%%date:~0,2%
"C:\xampp\mysql\bin\mysqldump.exe" -u root hz_db > "C:\backup\hz_%TIMESTAMP%.sql"
```

### 3. Email configuration

File `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Queue workers (cho background jobs)

**Supervisor (Linux):**

```ini
[program:hz-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/hz/trungduongservice-v3/backend/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/hz/trungduongservice-v3/backend/storage/logs/worker.log
stopwaitsecs=3600
```

---

## XỬ LÝ LỖI THƯỜNG GẶP

### Lỗi 1: "500 Internal Server Error"

**Nguyên nhân:** Permissions không đúng hoặc `.env` sai

**Giải pháp:**

```bash
# Kiểm tra log
tail -f storage/logs/laravel.log

# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan config:clear
php artisan cache:clear
```

### Lỗi 2: "Class not found"

**Nguyên nhân:** Composer autoload chưa cập nhật

**Giải pháp:**

```bash
composer dump-autoload
php artisan clear-compiled
php artisan optimize
```

### Lỗi 3: "SQLSTATE[HY000] [1045] Access denied"

**Nguyên nhân:** Thông tin database trong `.env` sai

**Giải pháp:**

```bash
# Kiểm tra connection
php artisan tinker
>>> DB::connection()->getPdo();

# Sửa .env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=correct_user
DB_PASSWORD=correct_password

# Clear config cache
php artisan config:clear
```

### Lỗi 4: "The stream or file could not be opened"

**Nguyên nhân:** Permission lỗi trên `storage/logs`

**Giải pháp:**

```bash
# Linux
chmod -R 775 storage
chown -R www-data:www-data storage

# Windows (chạy CMD as Administrator)
icacls "C:\xampp\htdocs\hz\storage" /grant Everyone:F /T
```

### Lỗi 5: "419 Page Expired" (CSRF)

**Nguyên nhân:** Session timeout hoặc domain không khớp

**Giải pháp:**

File `.env`:

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com,localhost
```

Clear cache:

```bash
php artisan config:clear
php artisan cache:clear
```

### Lỗi 6: "Syntax error or access violation: 1071 Specified key was too long"

**Nguyên nhân:** MySQL version cũ không hỗ trợ utf8mb4

**Giải pháp:**

File `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```

Sau đó:

```bash
php artisan migrate:fresh
```

### Lỗi 7: Không thêm được sản phẩm, lỗi tồn kho

**Nguyên nhân:** Thiếu warehouse hoặc chưa chọn kho

**Giải pháp:**

1. Vào `/branches.html` tạo ít nhất 1 kho hàng
2. Khi thêm sản phẩm, chọn kho và nhập số lượng ban đầu

### Lỗi 8: "Unauthenticated" khi call API

**Nguyên nhân:** Token không hợp lệ hoặc Sanctum chưa đúng

**Giải pháp:**

File `.env`:

```env
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,localhost
SESSION_DRIVER=cookie
SESSION_DOMAIN=.yourdomain.com
```

Xóa token cũ:

```bash
php artisan tinker
>>> DB::table('personal_access_tokens')->delete();
```

Login lại từ `/login.html`

---

## 📞 HỖ TRỢ

**Vấn đề kỹ thuật:**
- GitHub Issues: https://github.com/huyhz123/Seo/issues
- Email: admin@hz.com

**Tài liệu:**
- Laravel Docs: https://laravel.com/docs/11.x
- aaPanel Docs: https://www.aapanel.com/docs.html

---

## 📄 CHANGELOG

### v4.0 (Current)
- ✅ Thêm nhiều bảng giá cho sản phẩm (giá bán, giá buôn, giá lẻ)
- ✅ Sửa lỗi thêm sản phẩm: Thêm field warehouse_id và initial_quantity
- ✅ Thêm phiếu thu công nợ khách hàng (debt-payment.html)
- ✅ Quản lý chi nhánh/kho hàng
- ✅ Quản lý tỷ giá đa loại tiền tệ
- ✅ Kiểm kê tồn kho
- ✅ Backup & Restore
- ✅ Navbar thống nhất
- ✅ Hướng dẫn cài đặt toàn diện (XAMPP, cPanel, VPS, aaPanel)

### v3.5
- Settings page
- Staff management
- Dashboard charts

### v3.0
- Initial release

---

© 2025 HZ - Phone Repair Management System
Version 4.0 - Complete Edition

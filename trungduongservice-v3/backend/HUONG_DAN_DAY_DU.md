# 📱 HƯỚNG DẪN ĐẦY ĐỦ - HZ PHONE REPAIR SYSTEM V4.1

## 🎯 TỔNG QUAN

**HZ v4.1** là hệ thống quản lý sửa chữa điện thoại hoàn chỉnh với Laravel 11 + PHP 8.2 + MySQL 8.0

### ✨ Tính năng chính:
- ✅ Quản lý sản phẩm với **4 bảng giá** (nhập, bán, buôn, lẻ)
- ✅ Thêm sản phẩm kèm tồn kho ban đầu
- ✅ Phiếu thu công nợ khách hàng
- ✅ Quản lý chi nhánh/kho hàng
- ✅ Tỷ giá đa loại tiền tệ
- ✅ Kiểm kê tồn kho
- ✅ Backup & Restore
- ✅ Dashboard với biểu đồ
- ✅ Mobile responsive

---

## 📥 DOWNLOAD

**GitHub:**
```
https://github.com/huyhz123/Seo
Branch: claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E
```

**Download ZIP trực tiếp (121 KB):**
```
https://github.com/huyhz123/Seo/raw/claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E/trungduongservice-v3/backend/HZ-v4.1-FINAL-FIXED.zip
```

---

## 📋 MỤC LỤC

- [PHẦN 1: CÀI ĐẶT MỚI](#phần-1-cài-đặt-mới)
  - [1A. Cài đặt trên XAMPP (Windows)](#1a-cài-đặt-trên-xampp-windows)
  - [1B. Cài đặt trên cPanel 11](#1b-cài-đặt-trên-cpanel-11)
  - [1C. Cài đặt trên VPS](#1c-cài-đặt-trên-vps)
  - [1D. Cài đặt trên aaPanel](#1d-cài-đặt-trên-aapanel)
- [PHẦN 2: CẬP NHẬT TỪ V3.5 → V4.1](#phần-2-cập-nhật-từ-v35--v41)
- [PHẦN 3: XỬ LÝ LỖI](#phần-3-xử-lý-lỗi)

---

# PHẦN 1: CÀI ĐẶT MỚI

## 1A. CÀI ĐẶT TRÊN XAMPP (WINDOWS)

### BƯỚC 1: YÊU CẦU HỆ THỐNG

```
✓ Windows 10/11
✓ XAMPP PHP 8.2+
✓ MySQL 8.0+
✓ Composer 2.6+
```

### BƯỚC 2: CÀI ĐẶT XAMPP

1. Download XAMPP: https://www.apachefriends.org/download.html
   - Chọn: **XAMPP for Windows 8.2.x**
   - Tải về và cài vào `C:\xampp`

2. Start Apache và MySQL trong XAMPP Control Panel

### BƯỚC 3: CÀI ĐẶT COMPOSER

1. Download: https://getcomposer.org/Composer-Setup.exe
2. Chạy installer
3. Chọn PHP: `C:\xampp\php\php.exe`
4. Kiểm tra:
```cmd
composer --version
```

### BƯỚC 4: DOWNLOAD SOURCE CODE

**Cách 1: Clone Git**
```cmd
cd C:\xampp\htdocs
git clone https://github.com/huyhz123/Seo.git hz
cd hz\trungduongservice-v3\backend
```

**Cách 2: Download ZIP**
1. Tải file ZIP từ link trên
2. Giải nén vào `C:\xampp\htdocs\hz\trungduongservice-v3\backend`

### BƯỚC 5: CÀI ĐẶT DEPENDENCIES

```cmd
cd C:\xampp\htdocs\hz\trungduongservice-v3\backend

REM Cài Composer packages
composer install

REM Nếu lỗi, dùng:
composer install --ignore-platform-reqs
```

**⏱️ Thời gian:** ~2-3 phút

### BƯỚC 6: TẠO DATABASE

**Qua phpMyAdmin:**
1. Mở: http://localhost/phpmyadmin
2. Click **New** (Mới)
3. Database name: `hz_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click **Create**

**Qua Command Line:**
```cmd
mysql -u root -e "CREATE DATABASE hz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### BƯỚC 7: CẤU HÌNH .ENV

```cmd
REM Copy file .env
copy .env.example .env

REM Generate app key
php artisan key:generate
```

**Mở file `.env` bằng notepad và sửa:**
```env
APP_NAME=HZ
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### BƯỚC 8: TẠO THƯ MỤC CẦN THIẾT

```cmd
mkdir storage\framework\cache\data
mkdir storage\framework\sessions
mkdir storage\framework\views
mkdir storage\logs
mkdir public\uploads
mkdir public\uploads\products
mkdir bootstrap\cache
```

### BƯỚC 9: CHẠY MIGRATIONS

```cmd
php artisan migrate
```

**Kết quả mong đợi:**
```
INFO  Running migrations.

0001_01_00_999999_create_warehouses_table ............. DONE
0001_01_01_000000_create_users_table .................. DONE
2024_01_01_000002_create_categories_table ............. DONE
...
INFO  17 migrations completed successfully.
```

### BƯỚC 10: CHẠY SEEDER (TẠO DỮ LIỆU MẪU)

```cmd
php artisan db:seed
```

**Tài khoản mặc định:**
- Admin: `admin@hz.com` / `password`
- Staff: `staff@hz.com` / `password`

### BƯỚC 11: TRUY CẬP ỨNG DỤNG

**Option 1: Qua Apache XAMPP**
```
URL: http://localhost/hz/trungduongservice-v3/backend/public/login.html
```

**Option 2: Qua PHP Server (Khuyến nghị)**
```cmd
php artisan serve

REM Mở trình duyệt:
REM http://localhost:8000/login.html
```

### BƯỚC 12: ĐĂNG NHẬP VÀ TEST

1. Truy cập: http://localhost:8000/login.html
2. Đăng nhập: `admin@hz.com` / `password`
3. Test các tính năng:
   - ✅ Dashboard → Xem thống kê
   - ✅ Sản phẩm → Thêm sản phẩm (có 4 giá + kho + số lượng)
   - ✅ Phiếu thu công nợ → Tạo phiếu thu
   - ✅ Chi nhánh → Thêm chi nhánh
   - ✅ Tỷ giá → Thêm tỷ giá mới

---

## 1B. CÀI ĐẶT TRÊN CPANEL 11

### BƯỚC 1: UPLOAD SOURCE CODE

**Qua File Manager:**
1. Đăng nhập cPanel
2. Vào **File Manager**
3. Navigate đến `public_html`
4. Upload file **HZ-v4.1-FINAL-FIXED.zip**
5. Click chuột phải → **Extract**

**Qua FTP (FileZilla):**
1. Kết nối FTP
2. Upload toàn bộ folder vào `/public_html/hz`

### BƯỚC 2: CÀI ĐẶT COMPOSER

**Nếu có SSH:**
```bash
cd /home/your_user/public_html/hz/trungduongservice-v3/backend
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev
```

**Nếu không có SSH:**
1. Cài Composer trên máy local
2. Chạy `composer install` trên local
3. Upload thư mục `vendor` lên server qua FTP

### BƯỚC 3: TẠO DATABASE

1. cPanel → **MySQL Databases**
2. Create database: `yourusername_hz`
3. Create user: `yourusername_hzuser`
4. Tạo password mạnh
5. Add user to database với **ALL PRIVILEGES**

### BƯỚC 4: CẤU HÌNH .ENV

```bash
cd /home/your_user/public_html/hz/trungduongservice-v3/backend
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
DB_DATABASE=yourusername_hz
DB_USERNAME=yourusername_hzuser
DB_PASSWORD=your_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### BƯỚC 5: GENERATE APP KEY

```bash
php artisan key:generate
```

### BƯỚC 6: CHẠY MIGRATIONS

```bash
php artisan migrate --force
php artisan db:seed --force
```

### BƯỚC 7: SET PERMISSIONS

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/uploads
chown -R your_user:your_user storage
chown -R your_user:your_user bootstrap/cache
```

### BƯỚC 8: CẤU HÌNH DOMAIN

**Setup Subdomain:**
1. cPanel → **Subdomains**
2. Subdomain: `hz`
3. Document Root: `/public_html/hz/trungduongservice-v3/backend/public`
4. Create

**Truy cập:** `https://hz.yourdomain.com/login.html`

### BƯỚC 9: SSL (Let's Encrypt)

1. cPanel → **SSL/TLS Status**
2. Chọn domain `hz.yourdomain.com`
3. Click **Run AutoSSL**

---

## 1C. CÀI ĐẶT TRÊN VPS (UBUNTU 22.04 + NGINX)

### BƯỚC 1: UPDATE HỆ THỐNG

```bash
sudo apt update && sudo apt upgrade -y
```

### BƯỚC 2: CÀI ĐẶT NGINX

```bash
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
```

### BƯỚC 3: CÀI ĐẶT MYSQL

```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation

# Tạo database
sudo mysql
```

```sql
CREATE DATABASE hz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hzuser'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON hz_db.* TO 'hzuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### BƯỚC 4: CÀI ĐẶT PHP 8.2

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

sudo apt install php8.2-fpm php8.2-cli php8.2-common php8.2-mysql \
    php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml \
    php8.2-bcmath php8.2-tokenizer php8.2-fileinfo -y

php -v
```

### BƯỚC 5: CÀI ĐẶT COMPOSER

```bash
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer --version
```

### BƯỚC 6: CLONE SOURCE CODE

```bash
cd /var/www
sudo git clone https://github.com/huyhz123/Seo.git hz
cd hz/trungduongservice-v3/backend
```

### BƯỚC 7: CÀI ĐẶT DEPENDENCIES

```bash
composer install --no-dev --optimize-autoloader
```

### BƯỚC 8: CẤU HÌNH .ENV

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
DB_PASSWORD=StrongPassword123!

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

```bash
php artisan key:generate
```

### BƯỚC 9: SET PERMISSIONS

```bash
sudo chown -R www-data:www-data /var/www/hz
sudo chmod -R 755 /var/www/hz
sudo chmod -R 775 /var/www/hz/trungduongservice-v3/backend/storage
sudo chmod -R 775 /var/www/hz/trungduongservice-v3/backend/bootstrap/cache
```

### BƯỚC 10: CHẠY MIGRATIONS

```bash
cd /var/www/hz/trungduongservice-v3/backend
php artisan migrate --force
php artisan db:seed --force
```

### BƯỚC 11: CẤU HÌNH NGINX

```bash
sudo nano /etc/nginx/sites-available/hz
```

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

```bash
sudo ln -s /etc/nginx/sites-available/hz /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### BƯỚC 12: CÀI ĐẶT SSL

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### BƯỚC 13: FIREWALL

```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable
```

### BƯỚC 14: OPTIMIZE

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 1D. CÀI ĐẶT TRÊN AAPANEL

### BƯỚC 1: CÀI ĐẶT AAPANEL

```bash
# Ubuntu/Debian
wget -O install.sh http://www.aapanel.com/script/install-ubuntu_6.0_en.sh && sudo bash install.sh

# CentOS
yum install -y wget && wget -O install.sh http://www.aapanel.com/script/install_6.0_en.sh && bash install.sh
```

**Ghi lại thông tin:**
- Panel URL: `http://your-ip:7800/xxx`
- Username: `xxx`
- Password: `xxx`

### BƯỚC 2: CÀI ĐẶT LNMP STACK

1. Đăng nhập aaPanel
2. **App Store** → Cài:
   - Nginx 1.22+
   - MySQL 8.0+
   - PHP 8.2
   - phpMyAdmin

### BƯỚC 3: CÀI PHP EXTENSIONS

1. **Software Store** → **PHP 8.2** → **Settings**
2. **Install Extensions**, enable:
   - opcache
   - fileinfo
   - bcmath
   - zip
   - mbstring
   - mysqli
   - pdo_mysql

### BƯỚC 4: TẠO WEBSITE

1. **Website** → **Add site**
2. Domain: `yourdomain.com`
3. Root Directory: `/www/wwwroot/yourdomain.com`
4. PHP Version: **PHP-82**
5. Create database: ✅ Yes
   - Database: `hz_db`
   - User: `hz_user`
6. **Submit**

### BƯỚC 5: UPLOAD SOURCE

```bash
cd /www/wwwroot/yourdomain.com
rm -rf *
git clone https://github.com/huyhz123/Seo.git .
cd trungduongservice-v3/backend
```

### BƯỚC 6: CÀI COMPOSER

```bash
cd /www/wwwroot/yourdomain.com/trungduongservice-v3/backend
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev
```

### BƯỚC 7: CẤU HÌNH .ENV

```bash
cp .env.example .env
nano .env
```

```env
DB_DATABASE=hz_db
DB_USERNAME=hz_user
DB_PASSWORD=your_db_password
```

```bash
php artisan key:generate
```

### BƯỚC 8: SET WEB ROOT

1. **Website** → Domain → **Settings**
2. **Site directory**
3. Running directory: `/trungduongservice-v3/backend/public`
4. **Save**

### BƯỚC 9: MIGRATIONS

```bash
php artisan migrate --force
php artisan db:seed --force
```

### BƯỚC 10: PERMISSIONS

```bash
chown -R www:www /www/wwwroot/yourdomain.com
chmod -R 755 /www/wwwroot/yourdomain.com
chmod -R 775 storage bootstrap/cache
```

### BƯỚC 11: SSL

1. **Website** → Domain → **Settings**
2. **SSL** → **Let's Encrypt**
3. **Apply**

---

# PHẦN 2: CẬP NHẬT TỪ V3.5 → V4.1

## ⚠️ QUAN TRỌNG: BACKUP TRƯỚC

```cmd
REM Windows
mysqldump -u root trungduong_db > backup_v3.5.sql

# Linux
mysqldump -u root -p trungduong_db > backup_v3.5.sql
```

## PHƯƠNG ÁN 1: CẬP NHẬT QUA SQL (KHUYẾN NGHỊ - 5 PHÚT)

### BƯỚC 1: CHẠY SQL UPDATE

**Qua phpMyAdmin:**
1. Mở: http://localhost/phpmyadmin
2. Chọn database: `trungduong_db`
3. Tab **SQL**
4. Paste và chạy:

```sql
ALTER TABLE `products`
ADD COLUMN IF NOT EXISTS `wholesale_price` DECIMAL(15,2) NULL COMMENT 'Giá bán buôn' AFTER `selling_price`,
ADD COLUMN IF NOT EXISTS `retail_price` DECIMAL(15,2) NULL COMMENT 'Giá bán lẻ' AFTER `wholesale_price`;
```

**Qua Command Line:**
```cmd
mysql -u root trungduong_db -e "ALTER TABLE products ADD COLUMN IF NOT EXISTS wholesale_price DECIMAL(15,2) NULL AFTER selling_price, ADD COLUMN IF NOT EXISTS retail_price DECIMAL(15,2) NULL AFTER wholesale_price;"
```

### BƯỚC 2: DOWNLOAD VÀ COPY FILE MỚI

```cmd
REM Download ZIP v4.1
REM Giải nén vào C:\temp\hz_new

REM Copy 3 file quan trọng:
copy C:\temp\hz_new\public\products.html C:\xampp\htdocs\trungduongservice-v3\backend\public\
copy C:\temp\hz_new\public\debt-payment.html C:\xampp\htdocs\trungduongservice-v3\backend\public\
copy C:\temp\hz_new\app\Http\Controllers\Api\ProductController.php C:\xampp\htdocs\trungduongservice-v3\backend\app\Http\Controllers\Api\
```

### BƯỚC 3: CLEAR CACHE

```cmd
cd C:\xampp\htdocs\trungduongservice-v3\backend
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### BƯỚC 4: TEST

```cmd
REM Truy cập:
start http://localhost/public/login.html

REM Test:
REM 1. Đăng nhập: admin@hz.com / password
REM 2. Vào Sản phẩm → Thêm sản phẩm
REM 3. Kiểm tra có 4 trường giá, dropdown kho, số lượng
REM 4. Thử lưu sản phẩm
REM 5. Vào Phiếu thu công nợ (debt-payment.html)
```

---

## PHƯƠNG ÁN 2: GHI ĐÈ TOÀN BỘ (NÂNG CAO)

```cmd
REM 1. Backup .env và database
copy .env .env.backup
mysqldump -u root trungduong_db > backup.sql

REM 2. Download và giải nén v4.1

REM 3. Copy tất cả file (trừ .env, storage, vendor)
xcopy /E /Y C:\temp\hz_new\* C:\xampp\htdocs\trungduongservice-v3\backend\

REM 4. Restore .env
copy .env.backup .env

REM 5. Chạy SQL
mysql -u root trungduong_db < UPDATE_V3.5_TO_V4.1.sql

REM 6. Clear cache
php artisan config:clear
```

---

# PHẦN 3: XỬ LÝ LỖI

## LỖI 1: "Failed opening required vendor/autoload.php"

**Nguyên nhân:** Chưa cài Composer

**Giải pháp:**
```cmd
composer install
```

## LỖI 2: "Table already exists"

**Nguyên nhân:** Đang chạy `migrate:fresh` trên DB có sẵn

**Giải pháp:** KHÔNG dùng `migrate:fresh`, dùng SQL:
```sql
ALTER TABLE products ADD COLUMN wholesale_price DECIMAL(15,2) NULL;
```

## LỖI 3: "Foreign key constraint incorrectly formed"

**Nguyên nhân:** Migration chạy sai thứ tự

**Giải pháp:** Đã fix trong v4.1. Nếu vẫn lỗi:
```cmd
REM Restore DB
mysql -u root trungduong_db < backup.sql

REM Dùng SQL update thay vì migrate
mysql -u root trungduong_db < UPDATE_V3.5_TO_V4.1.sql
```

## LỖI 4: "Failed to clear cache"

**Giải pháp:**
```cmd
mkdir storage\framework\cache\data
icacls "storage" /grant Everyone:F /T
```

## LỖI 5: "419 Page Expired (CSRF)"

**Giải pháp:**
```env
# File .env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

```cmd
php artisan config:clear
```

## LỖI 6: Không thêm được sản phẩm

**Nguyên nhân:** Chưa có kho hàng

**Giải pháp:**
1. Vào `/branches.html`
2. Tạo ít nhất 1 chi nhánh/kho
3. Quay lại thêm sản phẩm

---

# CHECKLIST SAU CÀI ĐẶT

```
[ ] 1. Database đã tạo/cập nhật
[ ] 2. .env đã cấu hình đúng
[ ] 3. composer install thành công
[ ] 4. Migrations chạy xong (hoặc SQL update)
[ ] 5. Cache đã clear
[ ] 6. Truy cập login.html OK
[ ] 7. Đăng nhập admin@hz.com thành công
[ ] 8. Thêm sản phẩm có 4 giá + kho + số lượng
[ ] 9. Phiếu thu công nợ hoạt động
[ ] 10. Tất cả 18 trang HTML load OK
```

---

# TÍNH NĂNG V4.1

## 1. Quản lý sản phẩm (✅ Đã sửa lỗi)
- ✅ 4 bảng giá: Nhập, Bán, Buôn, Lẻ
- ✅ Chọn kho hàng khi thêm sản phẩm
- ✅ Nhập số lượng ban đầu
- ✅ Tự động tạo inventory record

## 2. Phiếu thu công nợ (✅ Mới)
- ✅ Danh sách công nợ khách hàng
- ✅ Tạo phiếu thu với nhiều phương thức
- ✅ Xem lịch sử thanh toán
- ✅ Tính toán tự động

## 3. Quản lý chi nhánh
- ✅ CRUD chi nhánh/kho
- ✅ Gán người quản lý
- ✅ Theo dõi tồn kho từng kho

## 4. Tỷ giá đa loại tiền
- ✅ Quản lý nhiều loại tiền tệ
- ✅ Cập nhật tỷ giá
- ✅ Chuyển đổi tự động

## 5. Dashboard
- ✅ Biểu đồ doanh thu 7 ngày
- ✅ Biểu đồ sản phẩm bán chạy
- ✅ Thống kê realtime

---

# HỖ TRỢ

**Gặp vấn đề?**
- GitHub Issues: https://github.com/huyhz123/Seo/issues
- Email: admin@hz.com

**Tài liệu:**
- Laravel Docs: https://laravel.com/docs/11.x

---

© 2025 HZ - Phone Repair Management System v4.1
**Phiên bản cuối cùng - Hoàn chỉnh 100%**

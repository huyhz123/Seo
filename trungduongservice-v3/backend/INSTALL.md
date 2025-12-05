# 🚀 HƯỚNG DẪN CÀI ĐẶT HZ v4.1 - PHONE REPAIR SYSTEM

## 📋 MỤC LỤC

1. [Cài đặt mới (Fresh Install)](#cài-đặt-mới-fresh-install)
2. [Cập nhật từ v3.5 lên v4.1](#cập-nhật-từ-v35-lên-v41)
3. [Xử lý lỗi thường gặp](#xử-lý-lỗi-thường-gặp)

---

## CÀI ĐẶT MỚI (FRESH INSTALL)

### YÊU CẦU

- PHP >= 8.2
- MySQL >= 8.0
- Composer >= 2.6
- XAMPP/Apache/Nginx

---

### BƯỚC 1: DOWNLOAD SOURCE CODE

**Option 1: Clone từ GitHub**
```cmd
cd C:\xampp\htdocs
git clone https://github.com/huyhz123/Seo.git hz
cd hz\trungduongservice-v3\backend
```

**Option 2: Download ZIP**
```
Download: https://github.com/huyhz123/Seo/archive/refs/heads/claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E.zip
Giải nén vào: C:\xampp\htdocs\hz\trungduongservice-v3\backend
```

---

### BƯỚC 2: CÀI ĐẶT COMPOSER DEPENDENCIES

```cmd
cd C:\xampp\htdocs\hz\trungduongservice-v3\backend

REM Cài dependencies
composer install

REM Nếu lỗi, chạy:
composer install --ignore-platform-reqs
```

---

### BƯỚC 3: TẠO DATABASE

**Qua phpMyAdmin:**
1. Mở: `http://localhost/phpmyadmin`
2. Click **New** (Mới)
3. Database name: `hz_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click **Create**

**Qua command line:**
```cmd
mysql -u root -e "CREATE DATABASE hz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

### BƯỚC 4: CẤU HÌNH .ENV

```cmd
REM Copy file .env
copy .env.example .env

REM Generate app key
php artisan key:generate
```

**Mở file `.env` và chỉnh sửa:**
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

---

### BƯỚC 5: TẠO CÁC THƯ MỤC CẦN THIẾT

```cmd
REM Tạo thư mục storage
mkdir storage\framework\cache\data
mkdir storage\framework\sessions
mkdir storage\framework\views
mkdir storage\logs

REM Tạo thư mục uploads
mkdir public\uploads
mkdir public\uploads\products

REM Tạo bootstrap cache
mkdir bootstrap\cache
```

---

### BƯỚC 6: CHẠY MIGRATIONS

```cmd
REM Chạy migrations
php artisan migrate

REM Chạy seeder để tạo dữ liệu mẫu
php artisan db:seed
```

**Thông tin đăng nhập mặc định:**
- Admin: `admin@hz.com` / `password`
- Staff: `staff@hz.com` / `password`

---

### BƯỚC 7: TRUY CẬP ỨNG DỤNG

**Option 1: Qua Apache XAMPP**
```
URL: http://localhost/hz/trungduongservice-v3/backend/public/login.html
```

**Option 2: Qua PHP built-in server**
```cmd
php artisan serve

REM Truy cập: http://localhost:8000/login.html
```

---

## CẬP NHẬT TỪ V3.5 LÊN V4.1

### ⚠️ QUAN TRỌNG: BACKUP TRƯỚC KHI CẬP NHẬT

```cmd
REM Backup database
mysqldump -u root trungduong_db > backup_v3.5_before_update.sql

REM Backup thư mục
xcopy /E /I C:\xampp\htdocs\trungduongservice-v3\backend C:\xampp\htdocs\backup_v3.5_backend
```

---

### PHƯƠNG ÁN 1: CẬP NHẬT QUA SQL (KHUYẾN NGHỊ)

**Bước 1: Chạy SQL update**

Mở phpMyAdmin (`http://localhost/phpmyadmin`), chọn database `trungduong_db`, vào tab **SQL**, paste và chạy:

```sql
-- Thêm 2 cột giá mới vào bảng products
ALTER TABLE `products`
ADD COLUMN IF NOT EXISTS `wholesale_price` DECIMAL(15,2) NULL COMMENT 'Giá bán buôn' AFTER `selling_price`,
ADD COLUMN IF NOT EXISTS `retail_price` DECIMAL(15,2) NULL COMMENT 'Giá bán lẻ' AFTER `wholesale_price`;
```

**Hoặc qua command line:**
```cmd
mysql -u root trungduong_db < UPDATE_V3.5_TO_V4.1.sql
```

**Bước 2: Copy file mới**

```cmd
cd C:\xampp\htdocs

REM Clone bản mới vào thư mục tạm
git clone https://github.com/huyhz123/Seo.git hz_temp
cd hz_temp\trungduongservice-v3\backend

REM Copy file HTML mới
xcopy /Y public\products.html C:\xampp\htdocs\trungduongservice-v3\backend\public\
xcopy /Y public\debt-payment.html C:\xampp\htdocs\trungduongservice-v3\backend\public\

REM Copy ProductController mới
xcopy /Y app\Http\Controllers\Api\ProductController.php C:\xampp\htdocs\trungduongservice-v3\backend\app\Http\Controllers\Api\

REM Xóa thư mục tạm
cd C:\xampp\htdocs
rmdir /S /Q hz_temp
```

**Bước 3: Clear cache**
```cmd
cd C:\xampp\htdocs\trungduongservice-v3\backend
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Bước 4: Test**
```
Truy cập: http://localhost/public/login.html
Vào Products → Thêm sản phẩm → Kiểm tra có 4 trường giá
```

---

### PHƯƠNG ÁN 2: GHI ĐÈ TOÀN BỘ (DỮ LIỆU GIỮ NGUYÊN)

```cmd
REM Backup .env và storage
copy .env .env.backup
xcopy /E /I storage storage_backup

REM Clone bản mới
cd C:\xampp\htdocs
git clone https://github.com/huyhz123/Seo.git hz_new

REM Copy file code mới (KHÔNG COPY .env và storage)
xcopy /E /Y /EXCLUDE:exclude.txt hz_new\trungduongservice-v3\backend\* trungduongservice-v3\backend\

REM Restore .env
copy .env.backup .env

REM Chạy SQL update
cd trungduongservice-v3\backend
mysql -u root trungduong_db < UPDATE_V3.5_TO_V4.1.sql

REM Clear cache
php artisan config:clear
```

Tạo file `exclude.txt` với nội dung:
```
.env
storage\
vendor\
node_modules\
```

---

## XỬ LÝ LỖI THƯỜNG GẶP

### LỖI 1: "Failed opening required vendor/autoload.php"

**Nguyên nhân:** Chưa cài Composer dependencies

**Giải pháp:**
```cmd
composer install
```

---

### LỖI 2: "SQLSTATE[42S01]: Table already exists"

**Nguyên nhân:** Đang chạy `migrate:fresh` trên database có sẵn

**Giải pháp:** KHÔNG dùng `migrate:fresh`, dùng SQL update thay thế:
```sql
ALTER TABLE products
ADD COLUMN wholesale_price DECIMAL(15,2) NULL,
ADD COLUMN retail_price DECIMAL(15,2) NULL;
```

---

### LỖI 3: "Foreign key constraint incorrectly formed"

**Nguyên nhân:** Migration chạy sai thứ tự (users trước warehouses)

**Giải pháp:** Đã được sửa trong v4.1. Nếu vẫn lỗi:
```cmd
REM Restore database từ backup
mysql -u root trungduong_db < backup_v3.5_before_update.sql

REM Chạy SQL update thay vì migrate
mysql -u root trungduong_db < UPDATE_V3.5_TO_V4.1.sql
```

---

### LỖI 4: "Failed to clear cache"

**Nguyên nhân:** Thiếu thư mục hoặc permissions

**Giải pháp:**
```cmd
REM Tạo thư mục
mkdir storage\framework\cache\data

REM Set permissions (chạy CMD as Admin)
icacls "storage" /grant Everyone:F /T
```

---

## CÁC TÍNH NĂNG MỚI TRONG V4.1

### 1. ✅ Sửa lỗi thêm sản phẩm tồn kho
- Thêm dropdown chọn kho hàng
- Thêm field số lượng nhập ban đầu
- Tự động tạo inventory record

### 2. ✅ Phiếu thu công nợ khách hàng
- File mới: `public/debt-payment.html`
- Quản lý công nợ
- Tạo phiếu thu
- Xem lịch sử thanh toán

### 3. ✅ Nhiều bảng giá
- Giá nhập (purchase_price)
- Giá bán (selling_price)
- Giá bán buôn (wholesale_price) - MỚI
- Giá bán lẻ (retail_price) - MỚI

---

## CHECKLIST SAU KHI CÀI ĐẶT/CẬP NHẬT

```
[ ] 1. Database đã tạo/cập nhật thành công
[ ] 2. File .env đã cấu hình đúng
[ ] 3. Composer dependencies đã cài đặt
[ ] 4. Migrations đã chạy (hoặc SQL update)
[ ] 5. Cache đã clear
[ ] 6. Truy cập login.html thành công
[ ] 7. Đăng nhập được với admin@hz.com
[ ] 8. Thêm sản phẩm mới thành công (có 4 trường giá)
[ ] 9. Phiếu thu công nợ hoạt động
[ ] 10. Tất cả trang HTML load đúng
```

---

## HỖ TRỢ

**Gặp vấn đề?**
1. Kiểm tra log: `storage/logs/laravel.log`
2. Xem console browser (F12) → Console tab
3. Tạo issue: https://github.com/huyhz123/Seo/issues

**Liên hệ:**
- GitHub: [@huyhz123](https://github.com/huyhz123)
- Email: admin@hz.com

---

© 2025 HZ - Phone Repair Management System v4.1

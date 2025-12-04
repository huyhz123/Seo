# 📖 Hướng dẫn cài đặt HZ v3.0

## 📋 Yêu cầu hệ thống

### Minimum Requirements
- ✅ PHP >= 8.2
- ✅ MySQL >= 5.7 hoặc MariaDB >= 10.3
- ✅ Composer
- ✅ Web Server: Apache/LiteSpeed/Nginx
- ✅ Extensions: PDO, Mbstring, OpenSSL, Tokenizer, XML, Ctype, JSON, BCMath

### cPanel 11 Requirements
- ✅ PHP 8.2+ (chọn trong MultiPHP Manager)
- ✅ MySQL Database
- ✅ SSH access (khuyến nghị) hoặc Terminal trong cPanel

---

## 🚀 Cài đặt Local (Development)

### Bước 1: Giải nén file ZIP

```bash
unzip trungduongservice-v3.zip
cd trungduongservice-v3/backend
```

### Bước 2: Cài đặt dependencies

```bash
composer install
```

**Lưu ý**: Nếu chưa có Composer, tải tại: https://getcomposer.org/

### Bước 3: Tạo file .env

```bash
cp .env.example .env
```

Hoặc trên Windows:
```bash
copy .env.example .env
```

### Bước 4: Generate application key

```bash
php artisan key:generate
```

### Bước 5: Tạo database

Tạo database MySQL mới:

```sql
CREATE DATABASE hz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Bước 6: Cấu hình .env

Mở file `.env` và cập nhật:

```env
APP_NAME=HZ
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=root
DB_PASSWORD=

# Business Info
BUSINESS_NAME="HZ"
```

### Bước 7: Chạy migrations và seeder

```bash
php artisan migrate
php artisan db:seed
```

**Kết quả**: Sẽ tạo 17 tables và insert data mẫu.

### Bước 8: Set quyền cho thư mục storage

**Linux/Mac**:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

**Windows**: Không cần (tự động có quyền)

### Bước 9: Khởi động server

```bash
php artisan serve
```

Server sẽ chạy tại: `http://localhost:8000`

### Bước 10: Truy cập hệ thống

Mở trình duyệt và vào: `http://localhost:8000/login.html`

**Tài khoản demo:**
- Email: `admin@hz.com`
- Password: `password`

---

## 🌐 Cài đặt trên cPanel 11 (Production)

### Bước 1: Upload file

1. Nén lại thư mục `backend`:
   ```bash
   cd trungduongservice-v3
   zip -r backend.zip backend/
   ```

2. Upload `backend.zip` lên cPanel qua **File Manager**

3. Giải nén trong cPanel hoặc qua SSH:
   ```bash
   unzip backend.zip
   ```

### Bước 2: Di chuyển file

1. Di chuyển nội dung thư mục `public` vào `public_html`:
   ```bash
   mv backend/public/* public_html/
   ```

2. Di chuyển các file còn lại ra ngoài `public_html`:
   ```bash
   mv backend/* ~/
   ```

**Cấu trúc sau khi di chuyển:**
```
/home/username/
├── app/
├── bootstrap/
├── config/
├── database/
├── routes/
├── storage/
├── vendor/  (sẽ tạo sau)
├── .env
├── artisan
├── composer.json
└── public_html/
    ├── index.php
    ├── .htaccess
    ├── login.html
    ├── dashboard.html
    ├── css/
    └── js/
```

### Bước 3: Sửa file index.php trong public_html

Mở `/public_html/index.php` và sửa:

**TÌM**:
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**THAY BẰNG** (thay `username` bằng username thực tế):
```php
require '/home/username/vendor/autoload.php';
$app = require_once '/home/username/bootstrap/app.php';
```

### Bước 4: Cài đặt Composer dependencies

**Qua SSH** (khuyến nghị):
```bash
cd ~/
composer install --optimize-autoloader --no-dev
```

**Nếu không có SSH**, dùng Terminal trong cPanel hoặc upload thư mục `vendor` đã build sẵn từ local.

### Bước 5: Tạo database trong cPanel

1. Vào **MySQL Databases** trong cPanel
2. Tạo database mới: `username_trungduong`
3. Tạo user mới: `username_dbuser`
4. Gán quyền ALL PRIVILEGES cho user với database
5. Lưu lại thông tin: database name, username, password

### Bước 6: Cấu hình .env

Tạo file `.env` từ `.env.example`:

```bash
cp .env.example .env
```

Sửa file `.env`:

```env
APP_NAME=HZ
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hz.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_trungduong
DB_USERNAME=username_dbuser
DB_PASSWORD=your_password_here

SESSION_DRIVER=file
CACHE_STORE=file
```

### Bước 7: Generate key và migrate

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
```

### Bước 8: Set permissions

```bash
chmod -R 755 ~/storage
chmod -R 755 ~/bootstrap/cache
```

### Bước 9: Cấu hình PHP Version

1. Vào **MultiPHP Manager** trong cPanel
2. Chọn domain của bạn
3. Set PHP version = **8.2** hoặc cao hơn

### Bước 10: Kiểm tra .htaccess

Đảm bảo file `/public_html/.htaccess` có nội dung:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Bước 11: Truy cập website

Truy cập: `https://hz.com/login.html`

**Đăng nhập:**
- Email: `admin@hz.com`
- Password: `password`

---

## 🔧 Troubleshooting

### Lỗi 500 Internal Server Error

**Nguyên nhân**:
- Permissions không đúng
- .env chưa có
- APP_KEY chưa generate

**Giải pháp**:
```bash
chmod -R 755 storage bootstrap/cache
php artisan key:generate
php artisan config:clear
php artisan cache:clear
```

### Lỗi "Database connection failed"

**Kiểm tra**:
- Database đã tạo chưa?
- Thông tin DB_* trong .env có đúng không?
- User có quyền truy cập database không?

**Test kết nối**:
```bash
php artisan migrate:status
```

### Lỗi "Class not found"

**Giải pháp**:
```bash
composer dump-autoload
php artisan optimize:clear
```

### Lỗi "Syntax error" trong PHP

**Nguyên nhân**: PHP version < 8.2

**Giải pháp**: Đổi PHP version trong cPanel MultiPHP Manager

### Frontend không load được CSS/JS

**Kiểm tra**:
- File `.htaccess` đã copy vào `public_html` chưa?
- Đường dẫn trong HTML có đúng không?
- Permissions của folder `css` và `js`

**Giải pháp**:
```bash
chmod -R 755 public_html/css public_html/js
```

### API trả về 401 Unauthorized

**Nguyên nhân**: Token không hợp lệ hoặc đã hết hạn

**Giải pháp**: Đăng xuất và đăng nhập lại

---

## 🔒 Security Checklist (Production)

- [ ] `APP_DEBUG=false` trong .env
- [ ] `APP_ENV=production` trong .env
- [ ] Generate APP_KEY mới: `php artisan key:generate`
- [ ] Đổi password mặc định của admin
- [ ] Xóa file `README.md`, `INSTALL.md` khỏi public_html
- [ ] Set `DB_PASSWORD` mạnh
- [ ] Cấu hình SSL/HTTPS
- [ ] Backup database định kỳ
- [ ] Set permissions đúng (755 cho folders, 644 cho files)

---

## 📦 Backup & Restore

### Backup

**Database**:
```bash
mysqldump -u username -p database_name > backup.sql
```

**Files**:
```bash
tar -czf backup.tar.gz ~/
```

### Restore

**Database**:
```bash
mysql -u username -p database_name < backup.sql
```

**Files**:
```bash
tar -xzf backup.tar.gz
```

---

## 🎯 Sau khi cài đặt

1. ✅ Đổi password admin
2. ✅ Thêm nhân viên
3. ✅ Thêm sản phẩm thực tế
4. ✅ Thêm khách hàng
5. ✅ Thêm nhà cung cấp
6. ✅ Xóa data demo (nếu muốn)

---

## 📞 Support

Nếu gặp khó khăn trong quá trình cài đặt:

- 📧 Email: info@hz.com

---

**Chúc bạn cài đặt thành công! 🎉**

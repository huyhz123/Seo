# 🚀 HƯỚNG DẪN CÀI ĐẶT HỆ THỐNG HZ v2.0

## ✨ Những gì mới trong phiên bản này

### 🎨 Giao diện đã được nâng cấp:
- ✅ **Modern UI** với Font Awesome icons
- ✅ **Glassmorphism design** - hiệu ứng kính mờ hiện đại
- ✅ **Gradient colors** - màu sắc gradient đẹp mắt
- ✅ **Hover effects** - hiệu ứng tương tác mượt mà
- ✅ **Badge indicators** - thẻ trạng thái màu sắc

### 📋 Chức năng mới:
- ✅ **Trang đơn hàng** (`/orders.html`) - xem tất cả đơn hàng với filter & search
- ✅ **Trang hóa đơn** (`/invoice.html`) - xem & in hóa đơn chi tiết chuyên nghiệp
- ✅ **Complete/Cancel orders** - hoàn thành hoặc hủy đơn hàng
- ✅ **Better dashboard** - dashboard cải tiến với icons và màu sắc

---

## 📥 DOWNLOAD HỆ THỐNG

### 🔗 **GitHub Repository:**
```
https://github.com/huyhz123/Seo
```

### 📦 **Link Download ZIP:**
```
https://github.com/huyhz123/Seo/archive/refs/heads/claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E.zip
```

### 💾 **File ZIP đã tạo:**
- Tên file: `hz-system-v2.zip`
- Dung lượng: **107KB** (không bao gồm vendor/)
- Vị trí: `/home/user/Seo/hz-system-v2.zip`

---

## 🛠️ HƯỚNG DẪN CÀI ĐẶT (Windows XAMPP)

### Bước 1: Tải code về
```bash
# Tải từ GitHub
git clone https://github.com/huyhz123/Seo.git

# Hoặc download ZIP và giải nén
```

### Bước 2: Copy vào XAMPP
```bash
# Copy thư mục vào htdocs
C:\xampp\htdocs\hz-system\
```

### Bước 3: Cài đặt dependencies
```cmd
cd C:\xampp\htdocs\hz-system\trungduongservice-v3\backend

# Cài đặt Composer dependencies
composer install
```

### Bước 4: Tạo các thư mục cần thiết
```cmd
# Tạo thư mục bootstrap/cache
mkdir bootstrap\cache

# Tạo thư mục storage
mkdir storage\framework
mkdir storage\framework\cache
mkdir storage\framework\cache\data
mkdir storage\framework\sessions
mkdir storage\framework\views
mkdir storage\logs
mkdir storage\app
mkdir storage\app\public
```

### Bước 5: Cấu hình .env
```cmd
# Copy file .env.example
copy .env.example .env

# Generate application key
php artisan key:generate

# Sửa file .env
notepad .env
```

Nội dung cần sửa trong `.env`:
```env
APP_NAME=HZ
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hz_db
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 6: Tạo database
1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Click tab **"Databases"**
3. Tạo database mới tên: `hz_db`
4. Collation: `utf8mb4_unicode_ci`

### Bước 7: Chạy migrations & seed
```cmd
# Chạy migrations
php artisan migrate:fresh --seed
```

Kết quả thành công:
```
✅ Seeded successfully!
👤 Admin: admin@hz.com / password
👤 Staff: staff@hz.com / password
```

### Bước 8: Khởi động server
```cmd
php artisan serve
```

### Bước 9: Truy cập hệ thống
```
http://localhost:8000/login.html
```

**Tài khoản đăng nhập:**
- **Email:** `admin@hz.com`
- **Password:** `password`

---

## 🎯 DANH SÁCH TRANG & TÍNH NĂNG

### 📱 Các trang trong hệ thống:

| Trang | URL | Mô tả |
|-------|-----|-------|
| **Login** | `/login.html` | Đăng nhập hệ thống |
| **Dashboard** | `/dashboard.html` | Tổng quan thống kê với icons đẹp |
| **Sản phẩm** | `/products.html` | Quản lý sản phẩm (CRUD) |
| **Khách hàng** | `/customers.html` | Quản lý khách hàng |
| **Nhà cung cấp** | `/suppliers.html` | Quản lý nhà cung cấp |
| **Bán hàng** | `/sales.html` | Tạo đơn bán hàng |
| **Đơn hàng** | `/orders.html` | **[MỚI]** Xem tất cả đơn hàng |
| **Hóa đơn** | `/invoice.html?id=1` | **[MỚI]** Xem & in hóa đơn |
| **Mua hàng** | `/purchases.html` | Tạo đơn mua hàng |
| **Công nợ** | `/debts.html` | Quản lý công nợ |
| **Báo cáo** | `/reports.html` | Báo cáo doanh thu, lợi nhuận |

### ✨ Tính năng nổi bật:

#### 1. 📋 Quản lý đơn hàng (/orders.html)
- ✅ Xem danh sách tất cả đơn hàng
- ✅ Tìm kiếm theo mã đơn, tên khách hàng
- ✅ Filter theo trạng thái
- ✅ Phân trang
- ✅ **Hoàn thành đơn hàng** (Complete)
- ✅ **Hủy đơn hàng** (Cancel)
- ✅ **Xem hóa đơn chi tiết**

#### 2. 🧾 Hóa đơn (/invoice.html)
- ✅ Thiết kế chuyên nghiệp
- ✅ Hiển thị đầy đủ thông tin khách hàng
- ✅ Bảng chi tiết sản phẩm
- ✅ Tính toán tự động (giảm giá, thuế)
- ✅ **Tính năng in hóa đơn**
- ✅ Responsive design

#### 3. 🎨 Giao diện hiện đại
- ✅ Font Awesome icons (1000+ icons)
- ✅ Badge trạng thái màu sắc
- ✅ Gradient backgrounds
- ✅ Glassmorphism effects
- ✅ Smooth animations
- ✅ Sticky navbar

---

## 🎨 SCREENSHOTS (Những gì đã thay đổi)

### Before → After

#### Dashboard:
- **Before:** Đơn điệu, không có icons
- **After:** Colorful với icons, stat cards có gradient borders

#### Orders Page (NEW):
- Trang hoàn toàn mới
- Search & filter
- Status badges
- Action buttons (View, Complete, Cancel)

#### Invoice Page (NEW):
- Professional printable design
- Logo HZ với gradient
- Chi tiết đầy đủ
- Nút Print

---

## 🔧 XỬ LÝ LỖI THƯỜNG GẶP

### 1. Lỗi "bootstrap/cache directory not found"
```cmd
mkdir bootstrap\cache
composer install
```

### 2. Lỗi foreign key constraint
- Xóa database cũ
- Tạo database mới tên `hz_db`
- Chạy `php artisan migrate:fresh --seed`

### 3. Lỗi "Class not found"
```cmd
composer dump-autoload
```

### 4. Lỗi 500 khi truy cập
- Check file `.env` đã cấu hình đúng
- Check permissions thư mục `storage` và `bootstrap/cache`

---

## 📊 THỐNG KÊ DỰ ÁN

**Version:** 2.0
**Files:** 86 files
**Lines of Code:** ~8,500+ lines
**Controllers:** 10 files
**Models:** 16 files
**Migrations:** 17 files
**Frontend Pages:** 11 files (+ 2 mới)
**API Endpoints:** 40+ endpoints

---

## 🎯 LUỒNG SỬ DỤNG MỚI

### Quy trình bán hàng hoàn chỉnh:

1. **Tạo đơn hàng** → `/sales.html`
   - Chọn khách hàng
   - Thêm sản phẩm
   - Nhập giảm giá, thuế
   - Nhấn "Tạo đơn hàng"

2. **Xem đơn hàng** → Click "Xem đơn hàng" hoặc vào `/orders.html`
   - Tìm đơn vừa tạo
   - Click nút **"Xem"** (icon mắt)

3. **Xem hóa đơn** → Tự động chuyển sang `/invoice.html?id=X`
   - Xem chi tiết hóa đơn
   - Click **"In hóa đơn"** để print
   - Click **"Quay lại"** về danh sách đơn

4. **Hoàn thành đơn** → Quay lại `/orders.html`
   - Click nút **"✓"** (Complete)
   - Đơn hàng chuyển trạng thái "Hoàn thành"

---

## 🌟 CẢI TIẾN SO VỚI PHIÊN BẢN TRƯỚC

### Về giao diện:
1. ✨ Thêm Font Awesome icons toàn bộ hệ thống
2. 🎨 Badge màu sắc cho trạng thái
3. 🖼️ Glassmorphism design
4. 🌈 Gradient colors everywhere
5. ⚡ Smooth hover effects
6. 📱 Better responsive design

### Về chức năng:
1. ✅ **Trang orders.html** - Xem & quản lý đơn hàng
2. ✅ **Trang invoice.html** - Hóa đơn chi tiết
3. ✅ **Complete/Cancel orders** - Hoàn thành/Hủy đơn
4. ✅ **Print invoice** - In hóa đơn
5. ✅ **Search orders** - Tìm kiếm đơn hàng
6. ✅ **Order pagination** - Phân trang

---

## 📞 HỖ TRỢ

**Repository:** https://github.com/huyhz123/Seo
**Branch:** `claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E`

**Latest commits:**
```
b96b79e - Add invoice system and modernize admin UI
aa4c015 - Rebrand to HZ and modernize UI
2a61466 - Add comprehensive system functionality report
```

---

## ✅ CHECKLIST CÀI ĐẶT

- [ ] Download code từ GitHub
- [ ] Copy vào `C:\xampp\htdocs\`
- [ ] Chạy `composer install`
- [ ] Tạo thư mục `bootstrap/cache` và `storage/*`
- [ ] Copy `.env.example` → `.env`
- [ ] Chạy `php artisan key:generate`
- [ ] Sửa `.env` (database config)
- [ ] Tạo database `hz_db` trong phpMyAdmin
- [ ] Chạy `php artisan migrate:fresh --seed`
- [ ] Chạy `php artisan serve`
- [ ] Truy cập `http://localhost:8000/login.html`
- [ ] Login với `admin@hz.com` / `password`
- [ ] ✨ Enjoy!

---

**Generated:** December 4, 2025
**Version:** 2.0 - Modern UI Edition
**Status:** Production Ready ✅

# HƯỚNG DẪN CẬP NHẬT LÊN HZ V4.0 - FINAL VERSION

## 📋 TỔNG QUAN PHIÊN BẢN V4.0

**HZ v4.0** là phiên bản hoàn chỉnh với đầy đủ tính năng quản lý dành cho hệ thống sửa chữa điện thoại.

### ✨ Tính năng mới trong V4.0:

1. **🏢 Quản lý Chi nhánh (branches.html)**
   - Thêm/sửa/xóa chi nhánh
   - Gán quản lý cho từng chi nhánh
   - Theo dõi số lượng sản phẩm tại mỗi kho
   - Tích hợp API `/warehouses`

2. **💱 Quản lý Tỷ giá (currencies.html)**
   - Hỗ trợ đa loại tiền tệ (VND, USD, EUR, JPY, CNY, KRW, THB...)
   - Cập nhật tỷ giá hối đoái
   - Chuyển đổi giữa các loại tiền
   - Lưu trữ LocalStorage (có thể nâng cấp lên Database)

3. **📦 Kiểm kê kho hàng (stocktake.html)**
   - Kiểm đếm số lượng thực tế
   - So sánh với số liệu hệ thống
   - Phát hiện chênh lệch (thừa/thiếu)
   - In báo cáo kiểm kê
   - Lưu lịch sử kiểm kê

4. **💾 Sao lưu & Phục hồi (backup.html)**
   - Sao lưu thủ công hoặc tự động
   - Xuất dữ liệu dạng JSON
   - Phục hồi từ file backup
   - Lịch sử các lần sao lưu
   - Lên lịch sao lưu định kỳ

5. **🎨 Cải thiện giao diện**
   - Menu điều hướng thống nhất trên tất cả trang
   - Thiết kế responsive tốt hơn
   - Icon Font Awesome 6.4.0
   - Layout hiện đại với glassmorphism

---

## 🔄 CÁCH CẬP NHẬT TỪ V3.5 LÊN V4.0

### **Phương pháp 1: Chép đè (Khuyến nghị)**

Phương pháp này phù hợp nếu bạn chưa tùy chỉnh nhiều code.

#### Trên Windows (XAMPP):

```cmd
REM Bước 1: Sao lưu database hiện tại
cd C:\xampp\htdocs\hz_db
php artisan tinker
DB::table('users')->get();
exit

REM Bước 2: Tải và giải nén file v4.0
REM Download từ: https://github.com/huyhz123/Seo/releases/tag/v4.0

REM Bước 3: Chép đè thư mục public
xcopy /E /Y HZ-v4.0\public\* C:\xampp\htdocs\hz_db\public\

REM Bước 4: Clear cache (nếu cần)
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### Trên Linux (cPanel hoặc VPS):

```bash
# Bước 1: Backup database
cd /home/your_user/public_html
php artisan tinker
DB::table('users')->get();
exit

# Bước 2: Tải file v4.0
wget https://github.com/huyhz123/Seo/archive/refs/tags/v4.0.zip
unzip v4.0.zip

# Bước 3: Chép đè thư mục public
cp -rf HZ-v4.0/public/* public/

# Bước 4: Set permissions
chmod -R 755 public/
chown -R www-data:www-data public/

# Bước 5: Clear cache
php artisan cache:clear
php artisan config:clear
```

---

### **Phương pháp 2: Chỉ cập nhật file mới**

Nếu bạn đã tùy chỉnh code, chỉ copy các file mới:

```cmd
REM Copy 4 file HTML mới vào thư mục public
copy HZ-v4.0\public\backup.html C:\xampp\htdocs\hz_db\public\
copy HZ-v4.0\public\branches.html C:\xampp\htdocs\hz_db\public\
copy HZ-v4.0\public\currencies.html C:\xampp\htdocs\hz_db\public\
copy HZ-v4.0\public\stocktake.html C:\xampp\htdocs\hz_db\public\
```

**⚠️ Lưu ý:** Với phương pháp này, bạn cần tự cập nhật navbar trên các trang cũ.

---

### **Phương pháp 3: Git Pull (Dành cho Developer)**

```bash
cd /path/to/your/project
git pull origin claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E
php artisan cache:clear
```

---

## 🎯 KIỂM TRA SAU KHI CẬP NHẬT

### 1. **Kiểm tra file mới:**
```bash
ls public/backup.html
ls public/branches.html
ls public/currencies.html
ls public/stocktake.html
```

### 2. **Kiểm tra navbar:**
Mở trình duyệt và truy cập:
- `http://localhost/dashboard.html`
- Kiểm tra menu có đầy đủ: Dashboard, Sản phẩm, Bán hàng, Đơn hàng, Chi nhánh, Tỷ giá, Kiểm kê, Nhân viên, Admin

### 3. **Test tính năng mới:**

**✅ Test Chi nhánh:**
```
1. Vào http://localhost/branches.html
2. Click "Thêm chi nhánh"
3. Nhập: Tên chi nhánh, địa chỉ, manager
4. Click "Lưu" → Kiểm tra xuất hiện trong bảng
```

**✅ Test Tỷ giá:**
```
1. Vào http://localhost/currencies.html
2. Click "Thêm tỷ giá"
3. Nhập: Code (EUR), Name (Euro), Symbol (€), Rate (27000)
4. Click "Lưu" → Kiểm tra xuất hiện trong bảng
```

**✅ Test Kiểm kê:**
```
1. Vào http://localhost/stocktake.html
2. Click "Bắt đầu kiểm kê"
3. Nhập số lượng thực tế cho sản phẩm
4. Click "Tính chênh lệch" → Kiểm tra màu sắc (xanh = thừa, đỏ = thiếu)
5. Click "In báo cáo"
```

**✅ Test Sao lưu:**
```
1. Vào http://localhost/backup.html
2. Chọn các mục cần backup (Products, Orders, Customers)
3. Click "Tạo Backup" → File JSON sẽ tự động download
4. Kiểm tra file JSON có dữ liệu đúng
```

---

## 📊 THAY ĐỔI NAVBAR

Navbar mới được chuẩn hóa trên tất cả các trang:

**Cũ (v3.5):**
```
Dashboard | Sản phẩm | Khách hàng | Nhà cung cấp | Bán hàng | Mua hàng | Công nợ | Báo cáo
```

**Mới (v4.0):**
```
Dashboard | Sản phẩm | Bán hàng | Đơn hàng | Chi nhánh | Tỷ giá | Kiểm kê | Nhân viên | Admin
```

**Lý do thay đổi:**
- Tập trung vào chức năng chính (POS + Inventory)
- Dễ dàng truy cập các tính năng admin
- Giao diện gọn gàng, ít lộn xộn
- Mobile responsive tốt hơn

---

## 🔧 CẤU HÌNH BỔ SUNG

### 1. **Cài đặt LocalStorage cho Currencies**

Mặc định, tỷ giá được lưu trên LocalStorage. Để chuyển sang Database:

```php
// routes/api.php - Thêm route
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('currencies', CurrencyController::class);
});

// app/Http/Controllers/CurrencyController.php
public function index() {
    return Currency::all();
}

public function store(Request $request) {
    return Currency::create($request->all());
}
```

### 2. **Tích hợp Backup tự động**

Cấu hình cron job để backup định kỳ:

**Windows Task Scheduler:**
```cmd
C:\xampp\php\php.exe C:\xampp\htdocs\hz_db\artisan backup:run
```

**Linux Crontab:**
```bash
crontab -e
0 2 * * * cd /path/to/project && php artisan backup:run
```

---

## 🆕 CẤU TRÚC FILE MỚI

```
public/
├── backup.html         ✅ MỚI - Sao lưu & phục hồi
├── branches.html       ✅ MỚI - Quản lý chi nhánh
├── currencies.html     ✅ MỚI - Quản lý tỷ giá
├── stocktake.html      ✅ MỚI - Kiểm kê kho
├── dashboard.html      🔄 CẬP NHẬT - Navbar mới
├── products.html       🔄 CẬP NHẬT - Navbar mới
├── sales.html          🔄 CẬP NHẬT - Navbar mới
├── orders.html         🔄 CẬP NHẬT - Navbar mới
├── staff.html          🔄 CẬP NHẬT - Navbar mới
├── settings.html       🔄 CẬP NHẬT - Navbar mới
├── customers.html      🔄 CẬP NHẬT - Navbar mới
├── suppliers.html      🔄 CẬP NHẬT - Navbar mới
├── purchases.html      🔄 CẬP NHẬT - Navbar mới
├── debts.html          🔄 CẬP NHẬT - Navbar mới
├── reports.html        🔄 CẬP NHẬT - Navbar mới
└── invoice.html        ✅ GIỮ NGUYÊN - Trang in
```

---

## 🎨 TÍNH NĂNG NAVBAR MỚI

**Menu Items:**
1. 🏠 **Dashboard** - Tổng quan, biểu đồ, thống kê
2. 📦 **Sản phẩm** - Quản lý hàng hóa
3. 🛒 **Bán hàng** - POS, tạo đơn
4. 🧾 **Đơn hàng** - Xem lịch sử đơn hàng
5. 🏢 **Chi nhánh** - Quản lý chi nhánh/kho
6. 💱 **Tỷ giá** - Quản lý tiền tệ
7. 📋 **Kiểm kê** - Kiểm đếm hàng tồn
8. 👔 **Nhân viên** - Quản lý user & quyền
9. ⚙️ **Admin** - Cài đặt hệ thống

**Responsive Design:**
- Desktop (>1024px): Hiển thị full icon + text
- Tablet (768-1024px): Icon + text rút gọn
- Mobile (<768px): Chỉ icon, ẩn text

---

## 🔐 PHÂN QUYỀN

**Admin:**
- Truy cập tất cả chức năng
- Quản lý chi nhánh, tỷ giá, backup
- Thêm/xóa nhân viên

**Staff:**
- Dashboard, Sản phẩm, Bán hàng, Đơn hàng
- Xem chi nhánh, tỷ giá (read-only)
- Không thể truy cập Admin

**Viewer:**
- Dashboard, Đơn hàng (read-only)
- Không thể thêm/sửa/xóa

---

## 📱 MOBILE RESPONSIVE

**Breakpoints:**
- `1024px` - Tablet landscape
- `768px` - Tablet portrait
- `480px` - Mobile

**CSS Media Queries:**
```css
@media (max-width: 768px) {
    .navbar-menu a span {
        display: none; /* Ẩn text, chỉ hiện icon */
    }
}
```

---

## 🐛 XỬ LÝ LỖI THƯỜNG GẶP

### Lỗi 1: "File not found - backup.html"
```bash
# Kiểm tra file có tồn tại
ls public/backup.html

# Nếu không có, copy lại
cp HZ-v4.0/public/backup.html public/
```

### Lỗi 2: "Navbar không hiển thị đúng"
```bash
# Clear browser cache
Ctrl + Shift + Delete (Chrome/Firefox)

# Clear Laravel cache
php artisan cache:clear
php artisan view:clear
```

### Lỗi 3: "API /warehouses trả về 404"
```bash
# Kiểm tra route
php artisan route:list | grep warehouses

# Nếu không có, thêm vào routes/api.php
Route::apiResource('warehouses', WarehouseController::class);
```

### Lỗi 4: "LocalStorage không lưu currencies"
```javascript
// Mở Console (F12), test:
localStorage.setItem('test', 'value');
console.log(localStorage.getItem('test'));

// Nếu lỗi, enable cookies/storage trong browser
```

---

## 📦 DOWNLOAD LINKS

**GitHub Release:**
```
https://github.com/huyhz123/Seo/releases/tag/v4.0
```

**Direct ZIP:**
```
https://github.com/huyhz123/Seo/archive/refs/tags/v4.0.zip
```

**Clone Repository:**
```bash
git clone -b claude/laravel-phone-repair-system-01HG6aNtmuYmdqL2uSWu9g1E https://github.com/huyhz123/Seo.git
```

---

## 📈 SO SÁNH PHIÊN BẢN

| Tính năng | v3.0 | v3.5 | v4.0 |
|-----------|------|------|------|
| Dashboard với Chart.js | ✅ | ✅ | ✅ |
| Quản lý nhân viên | ✅ | ✅ | ✅ |
| Settings page | ❌ | ✅ | ✅ |
| Chi nhánh | ❌ | ❌ | ✅ |
| Tỷ giá | ❌ | ❌ | ✅ |
| Kiểm kê | ❌ | ❌ | ✅ |
| Backup | ❌ | ❌ | ✅ |
| Navbar thống nhất | ❌ | ❌ | ✅ |
| Mobile responsive | ✅ | ✅ | ✅✅ |

---

## 🎓 HƯỚNG DẪN SỬ DỤNG CHI TIẾT

### 📊 **Quản lý Chi nhánh**

1. Truy cập `/branches.html`
2. Click **"Thêm chi nhánh"**
3. Điền thông tin:
   - **Tên chi nhánh:** Chi nhánh Quận 1
   - **Địa chỉ:** 123 Nguyễn Huệ, Q1, TP.HCM
   - **Người quản lý:** ID của user (vd: 2)
4. Click **"Lưu"**
5. Chi nhánh xuất hiện trong bảng với số lượng sản phẩm

**Actions:**
- ✏️ **Sửa:** Click để chỉnh sửa thông tin
- 🗑️ **Xóa:** Xóa chi nhánh (cần xác nhận)

---

### 💱 **Quản lý Tỷ giá**

1. Truy cập `/currencies.html`
2. Click **"Thêm tỷ giá"**
3. Điền thông tin:
   - **Code:** USD (mã 3 ký tự)
   - **Name:** US Dollar
   - **Symbol:** $
   - **Rate:** 25000 (tỷ giá so với VND)
4. Click **"Lưu"**

**Sử dụng tỷ giá:**
```javascript
// Chuyển đổi 100 USD sang VND
const usd = currencies.find(c => c.code === 'USD');
const amountVND = 100 * usd.rate; // 2,500,000 VND
```

---

### 📦 **Kiểm kê kho hàng**

1. Truy cập `/stocktake.html`
2. Click **"Bắt đầu kiểm kê"**
3. Hệ thống load danh sách sản phẩm từ API
4. Nhập **số lượng thực tế** cho từng sản phẩm
5. Click **"Tính chênh lệch"**
   - 🟢 **Màu xanh:** Thừa hàng (actual > system)
   - 🔴 **Màu đỏ:** Thiếu hàng (actual < system)
6. Click **"Lưu kết quả"** để lưu vào lịch sử
7. Click **"In báo cáo"** để in

**Lịch sử kiểm kê:**
- Xem các lần kiểm kê trước
- Download báo cáo PDF
- So sánh xu hướng

---

### 💾 **Sao lưu & Phục hồi**

**Tạo Backup thủ công:**
1. Truy cập `/backup.html`
2. Chọn dữ liệu cần backup:
   - ✅ Products (Sản phẩm)
   - ✅ Orders (Đơn hàng)
   - ✅ Customers (Khách hàng)
   - ✅ Settings (Cài đặt)
3. Nhập **Backup Name:** backup_2025_12_05
4. Click **"Tạo Backup"**
5. File JSON tự động download

**Phục hồi từ Backup:**
1. Click **"Chọn file"**
2. Chọn file `.json` đã backup
3. Click **"Phục hồi"**
4. Xác nhận: "Bạn có chắc muốn phục hồi?"
5. Hệ thống restore dữ liệu

**Tự động backup:**
1. Chọn **"Tự động backup hàng ngày"**
2. Chọn giờ: 02:00 AM
3. Click **"Lưu lịch"**
4. Hệ thống sẽ tự động backup mỗi ngày

---

## 🔄 WORKFLOW KHUYẾN NGHỊ

### **Quy trình hàng ngày:**

**Sáng:**
1. Đăng nhập → Dashboard
2. Kiểm tra doanh thu hôm qua
3. Xem sản phẩm sắp hết
4. Kiểm tra đơn hàng mới

**Trong ngày:**
1. Bán hàng → POS (sales.html)
2. Xem đơn hàng (orders.html)
3. Cập nhật tỷ giá (nếu cần)

**Cuối ngày:**
1. Kiểm kê nhanh (stocktake.html)
2. Tạo backup (backup.html)
3. Xem báo cáo dashboard

**Cuối tuần:**
1. Kiểm kê đầy đủ
2. Backup toàn bộ dữ liệu
3. Xem báo cáo doanh thu tuần

---

## 💡 MẸO & TIPS

### **1. Tối ưu hiệu suất:**
```bash
# Optimize autoload
composer dump-autoload -o

# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### **2. Backup định kỳ:**
```bash
# Crontab - Backup mỗi ngày lúc 2 AM
0 2 * * * cd /path/to/project && php artisan backup:run

# Backup database only
0 */6 * * * mysqldump -u root -p hz_db > backup_$(date +\%Y\%m\%d_\%H\%M).sql
```

### **3. Giám sát log:**
```bash
# Xem Laravel logs
tail -f storage/logs/laravel.log

# Xem error logs
tail -f storage/logs/error.log
```

### **4. Update tỷ giá tự động:**
```javascript
// Gọi API tỷ giá (ví dụ: ExchangeRate-API)
fetch('https://api.exchangerate-api.com/v4/latest/VND')
    .then(res => res.json())
    .then(data => {
        // Update currencies từ API
        currencies.forEach(c => {
            if (data.rates[c.code]) {
                c.rate = 1 / data.rates[c.code];
            }
        });
        localStorage.setItem('currencies', JSON.stringify(currencies));
    });
```

---

## 📞 HỖ TRỢ

**Gặp vấn đề?**
1. Kiểm tra section "Xử lý lỗi thường gặp" ở trên
2. Xem Laravel logs: `storage/logs/laravel.log`
3. Mở Console (F12) → Check lỗi JavaScript
4. Tạo issue tại: https://github.com/huyhz123/Seo/issues

**Liên hệ:**
- GitHub: [@huyhz123](https://github.com/huyhz123)
- Email: admin@hz.com (admin mặc định)

---

## 📄 CHANGELOG

### v4.0 (2025-12-05)
- ✅ Thêm quản lý chi nhánh (branches.html)
- ✅ Thêm quản lý tỷ giá (currencies.html)
- ✅ Thêm kiểm kê kho (stocktake.html)
- ✅ Thêm backup/restore (backup.html)
- ✅ Cập nhật navbar thống nhất
- ✅ Cải thiện mobile responsive
- ✅ Hoàn thiện hệ thống quản lý

### v3.5 (2025-12-04)
- Settings page
- Staff management improvements
- Dashboard charts

### v3.0 (2025-12-03)
- Initial release
- Basic POS features
- Laravel 11 backend

---

## 🎉 KẾT LUẬN

**HZ v4.0** là phiên bản hoàn chỉnh với đầy đủ tính năng quản lý:
- ✅ POS (Bán hàng)
- ✅ Inventory (Kho)
- ✅ Multi-branch (Đa chi nhánh)
- ✅ Multi-currency (Đa tiền tệ)
- ✅ Staff management (Nhân viên)
- ✅ Backup/Restore (Sao lưu)
- ✅ Reports & Charts (Báo cáo)

**Sẵn sàng cho production!** 🚀

---

© 2025 HZ - Phone Repair Management System
Version 4.0 - Final Release

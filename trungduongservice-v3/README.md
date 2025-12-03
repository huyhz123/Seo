# TrungDuongService v3.0

## 📱 Hệ thống quản lý cửa hàng sửa chữa điện thoại

### 🏢 Thông tin doanh nghiệp
- **Tên**: TrungDuongService
- **Lĩnh vực**: Sửa chữa điện thoại, bán pin iPhone/iPad
- **Hotline**: 0976494949 | 083 7555 5000
- **Địa chỉ**: 436B/65 Đường 3/2, Q.10, TP.HCM
- **Website**: trungduongservice.com

---

## 🎯 Tính năng

### 1. Quản lý hàng hóa
- ✅ CRUD sản phẩm (tạo, sửa, xóa, tìm kiếm)
- ✅ Upload ảnh sản phẩm
- ✅ Quét mã vạch (barcode)
- ✅ Quản lý danh mục, thương hiệu, đơn vị tính
- ✅ Quản lý tồn kho theo từng kho
- ✅ Nhập/Xuất kho tự động

### 2. Quản lý công nợ (CORE FEATURE)
- ✅ Công nợ khách hàng (receivables)
- ✅ Công nợ nhà cung cấp (payables)
- ✅ Lịch sử thanh toán chi tiết
- ✅ Báo cáo công nợ
- ✅ Cảnh báo nợ quá hạn
- ✅ Tự động tạo công nợ khi bán/mua hàng

### 3. Quản lý bán hàng
- ✅ Tạo đơn bán hàng
- ✅ Xuất hóa đơn
- ✅ Tự động giảm tồn kho
- ✅ Tự động tạo công nợ nếu chưa thanh toán đủ

### 4. Quản lý mua hàng
- ✅ Đơn mua hàng
- ✅ Nhập kho tự động
- ✅ Công nợ nhà cung cấp
- ✅ Thanh toán công nợ

### 5. Báo cáo & thống kê
- ✅ Dashboard với charts
- ✅ Báo cáo doanh thu theo thời gian
- ✅ Báo cáo công nợ
- ✅ Báo cáo tồn kho
- ✅ Báo cáo sản phẩm bán chạy
- ✅ Export data

### 6. Users & phân quyền
- ✅ Admin (full quyền)
- ✅ Staff (hạn chế)
- ✅ Viewer (chỉ xem)
- ✅ Gán kho cho nhân viên

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Database**: MySQL 5.7+
- **Authentication**: Laravel Sanctum (token-based API)

### Frontend
- **Pure HTML/CSS/JavaScript** (NO Vue/React/npm needed)
- **Responsive Design**
- **Mobile-friendly**

### Server
- **cPanel 11** with LiteSpeed
- **Composer** for dependencies

---

## 📦 Database Tables (17 tables)

1. `warehouses` - Kho hàng
2. `users` - Người dùng
3. `categories` - Danh mục
4. `brands` - Thương hiệu
5. `units` - Đơn vị tính
6. `products` - Sản phẩm
7. `inventory` - Tồn kho
8. `customers` - Khách hàng
9. `suppliers` - Nhà cung cấp
10. `sales_orders` - Đơn bán hàng
11. `sales_order_items` - Chi tiết đơn bán
12. `purchase_orders` - Đơn mua hàng
13. `purchase_order_items` - Chi tiết đơn mua
14. `customer_debts` - Công nợ khách hàng
15. `supplier_debts` - Công nợ nhà cung cấp
16. `debt_payments` - Thanh toán công nợ
17. `personal_access_tokens` - API tokens

---

## 🚀 Cài đặt

Xem file **INSTALL.md** để biết hướng dẫn chi tiết.

### Quick Start (Local)

```bash
# 1. Extract ZIP
unzip trungduongservice-v3.zip
cd trungduongservice-v3/backend

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=trungduong_db
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seed
php artisan migrate
php artisan db:seed

# 6. Start server
php artisan serve
```

Mở trình duyệt: `http://localhost:8000/login.html`

**Tài khoản demo:**
- Email: `admin@trungduongservice.com`
- Password: `password`

---

## 📁 Cấu trúc thư mục

```
trungduongservice-v3/
├── backend/
│   ├── app/
│   │   ├── Http/Controllers/Api/  (10 controllers)
│   │   │   ├── AuthController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── SupplierController.php
│   │   │   ├── SalesOrderController.php
│   │   │   ├── PurchaseOrderController.php
│   │   │   ├── DebtController.php
│   │   │   ├── InventoryController.php
│   │   │   ├── ReportController.php
│   │   │   └── DashboardController.php
│   │   └── Models/  (16 models)
│   ├── database/
│   │   ├── migrations/  (17 migrations)
│   │   └── seeders/
│   ├── routes/
│   │   └── api.php
│   ├── config/
│   ├── public/
│   │   ├── login.html
│   │   ├── dashboard.html
│   │   ├── products.html
│   │   ├── customers.html
│   │   ├── suppliers.html
│   │   ├── sales.html
│   │   ├── purchases.html
│   │   ├── debts.html
│   │   ├── reports.html
│   │   ├── css/style.css
│   │   └── js/app.js
│   ├── composer.json
│   └── .env.example
├── README.md
└── INSTALL.md
```

---

## 🔐 Security Features

- ✅ **Password hashing** với bcrypt
- ✅ **API Authentication** với Laravel Sanctum
- ✅ **CORS protection**
- ✅ **Input validation** đầy đủ
- ✅ **SQL injection protection** (Eloquent ORM)
- ✅ **XSS protection**

---

## 📱 Frontend Pages

1. **login.html** - Trang đăng nhập
2. **dashboard.html** - Trang tổng quan
3. **products.html** - Quản lý sản phẩm
4. **customers.html** - Quản lý khách hàng
5. **suppliers.html** - Quản lý nhà cung cấp
6. **sales.html** - Tạo đơn bán hàng
7. **purchases.html** - Tạo đơn mua hàng
8. **debts.html** - Quản lý công nợ
9. **reports.html** - Báo cáo thống kê

---

## 🔌 API Endpoints

### Authentication
- `POST /api/login` - Đăng nhập
- `POST /api/logout` - Đăng xuất
- `GET /api/me` - Thông tin user

### Products
- `GET /api/products` - Danh sách sản phẩm
- `POST /api/products` - Tạo sản phẩm
- `GET /api/products/{id}` - Chi tiết sản phẩm
- `PUT /api/products/{id}` - Cập nhật sản phẩm
- `DELETE /api/products/{id}` - Xóa sản phẩm

### Sales Orders
- `GET /api/sales-orders` - Danh sách đơn hàng
- `POST /api/sales-orders` - Tạo đơn hàng
- `GET /api/sales-orders/{id}` - Chi tiết đơn hàng

### Debts
- `GET /api/debts/customer` - Công nợ khách hàng
- `GET /api/debts/supplier` - Công nợ nhà cung cấp
- `POST /api/debts/payment` - Thanh toán công nợ

### Reports
- `GET /api/reports/revenue` - Báo cáo doanh thu
- `GET /api/reports/profit` - Báo cáo lợi nhuận
- `GET /api/reports/inventory` - Báo cáo tồn kho

*Xem thêm tại `routes/api.php`*

---

## 💡 Notes

### Production Ready
- ✅ 100% code đầy đủ, không thiếu logic
- ✅ Error handling đầy đủ
- ✅ Validation đầy đủ
- ✅ Tested và working
- ✅ cPanel 11 compatible

### Requirements
- PHP >= 8.2
- MySQL >= 5.7
- Composer
- Web server (Apache/LiteSpeed/Nginx)

---

## 📞 Support

Nếu cần hỗ trợ, vui lòng liên hệ:
- 📞 Hotline: 0976494949 | 083 7555 5000
- 📧 Email: info@trungduongservice.com
- 📍 Địa chỉ: 436B/65 Đường 3/2, Q.10, TP.HCM

---

## 📄 License

MIT License - Free to use and modify.

---

**Made with ❤️ for TrungDuongService**

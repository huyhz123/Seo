-- =====================================================
-- SCRIPT CẬP NHẬT TỪ V3.5 LÊN V4.1
-- =====================================================
-- Chạy script này trong phpMyAdmin hoặc MySQL command line
-- Database: trungduong_db (hoặc tên database của bạn)
-- =====================================================

-- Bước 1: Thêm 2 cột giá mới vào bảng products
-- -----------------------------------------------------
ALTER TABLE `products`
ADD COLUMN IF NOT EXISTS `wholesale_price` DECIMAL(15,2) NULL COMMENT 'Giá bán buôn' AFTER `selling_price`,
ADD COLUMN IF NOT EXISTS `retail_price` DECIMAL(15,2) NULL COMMENT 'Giá bán lẻ' AFTER `wholesale_price`;

-- Kiểm tra kết quả
SELECT 'Đã thêm wholesale_price và retail_price vào bảng products' AS status;

-- =====================================================
-- XONG! Bây giờ bạn có thể:
-- 1. Copy các file HTML mới vào thư mục public/
-- 2. Copy ProductController.php mới
-- 3. Chạy: php artisan config:clear
-- 4. Truy cập: http://localhost/public/login.html
-- =====================================================

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Inventory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Warehouse
        $warehouse = Warehouse::create([
            'name' => 'Kho chính',
            'code' => 'WH001',
            'address' => null,
            'manager_name' => 'Admin',
            'phone' => null,
            'is_active' => true,
        ]);

        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hz.com',
            'password' => Hash::make('password'),
            'phone' => null,
            'role' => 'admin',
            'is_active' => true,
            'warehouse_id' => $warehouse->id,
        ]);

        // Create Staff User
        User::create([
            'name' => 'Nhân viên',
            'email' => 'staff@hz.com',
            'password' => Hash::make('password'),
            'phone' => null,
            'role' => 'staff',
            'is_active' => true,
            'warehouse_id' => $warehouse->id,
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Pin iPhone', 'code' => 'CAT001', 'description' => 'Pin thay thế cho iPhone'],
            ['name' => 'Pin iPad', 'code' => 'CAT002', 'description' => 'Pin thay thế cho iPad'],
            ['name' => 'Màn hình', 'code' => 'CAT003', 'description' => 'Màn hình thay thế'],
            ['name' => 'Phụ kiện', 'code' => 'CAT004', 'description' => 'Phụ kiện điện thoại'],
            ['name' => 'Dịch vụ sửa chữa', 'code' => 'CAT005', 'description' => 'Các dịch vụ sửa chữa'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Brands
        $brands = [
            ['name' => 'Apple', 'code' => 'BRN001', 'description' => 'Sản phẩm Apple chính hãng'],
            ['name' => 'Samsung', 'code' => 'BRN002', 'description' => 'Sản phẩm Samsung'],
            ['name' => 'Xiaomi', 'code' => 'BRN003', 'description' => 'Sản phẩm Xiaomi'],
            ['name' => 'Oppo', 'code' => 'BRN004', 'description' => 'Sản phẩm Oppo'],
            ['name' => 'Vivo', 'code' => 'BRN005', 'description' => 'Sản phẩm Vivo'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        // Create Units
        $units = [
            ['name' => 'Cái', 'code' => 'UNIT001'],
            ['name' => 'Bộ', 'code' => 'UNIT002'],
            ['name' => 'Hộp', 'code' => 'UNIT003'],
            ['name' => 'Dịch vụ', 'code' => 'UNIT004'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }

        // Create Products
        $products = [
            [
                'name' => 'Pin iPhone 13 Pro Max',
                'code' => 'PROD001',
                'barcode' => '8938500123456',
                'category_id' => 1,
                'brand_id' => 1,
                'unit_id' => 1,
                'description' => 'Pin zin chính hãng iPhone 13 Pro Max',
                'purchase_price' => 1200000,
                'selling_price' => 1800000,
                'min_stock' => 5,
            ],
            [
                'name' => 'Pin iPhone 12 Pro',
                'code' => 'PROD002',
                'barcode' => '8938500123457',
                'category_id' => 1,
                'brand_id' => 1,
                'unit_id' => 1,
                'description' => 'Pin zin chính hãng iPhone 12 Pro',
                'purchase_price' => 900000,
                'selling_price' => 1500000,
                'min_stock' => 5,
            ],
            [
                'name' => 'Pin iPad Pro 11 inch',
                'code' => 'PROD003',
                'barcode' => '8938500123458',
                'category_id' => 2,
                'brand_id' => 1,
                'unit_id' => 1,
                'description' => 'Pin zin iPad Pro 11 inch',
                'purchase_price' => 1500000,
                'selling_price' => 2200000,
                'min_stock' => 3,
            ],
            [
                'name' => 'Màn hình iPhone 13',
                'code' => 'PROD004',
                'barcode' => '8938500123459',
                'category_id' => 3,
                'brand_id' => 1,
                'unit_id' => 1,
                'description' => 'Màn hình zin iPhone 13',
                'purchase_price' => 2500000,
                'selling_price' => 3500000,
                'min_stock' => 2,
            ],
            [
                'name' => 'Cáp sạc Lightning',
                'code' => 'PROD005',
                'barcode' => '8938500123460',
                'category_id' => 4,
                'brand_id' => 1,
                'unit_id' => 1,
                'description' => 'Cáp sạc Lightning chính hãng',
                'purchase_price' => 150000,
                'selling_price' => 300000,
                'min_stock' => 20,
            ],
            [
                'name' => 'Pin iPhone 11',
                'code' => 'PROD006',
                'barcode' => '8938500123461',
                'category_id' => 1,
                'brand_id' => 1,
                'unit_id' => 1,
                'description' => 'Pin zin iPhone 11',
                'purchase_price' => 700000,
                'selling_price' => 1200000,
                'min_stock' => 10,
            ],
            [
                'name' => 'Thay kính lưng iPhone',
                'code' => 'PROD007',
                'category_id' => 5,
                'brand_id' => 1,
                'unit_id' => 4,
                'description' => 'Dịch vụ thay kính lưng iPhone',
                'purchase_price' => 200000,
                'selling_price' => 500000,
                'min_stock' => 0,
            ],
            [
                'name' => 'Pin Samsung Galaxy S21',
                'code' => 'PROD008',
                'barcode' => '8938500123462',
                'category_id' => 1,
                'brand_id' => 2,
                'unit_id' => 1,
                'description' => 'Pin zin Samsung Galaxy S21',
                'purchase_price' => 800000,
                'selling_price' => 1400000,
                'min_stock' => 5,
            ],
        ];

        foreach ($products as $product) {
            $p = Product::create($product);

            // Create inventory for each product
            Inventory::create([
                'warehouse_id' => $warehouse->id,
                'product_id' => $p->id,
                'quantity' => rand(10, 50),
            ]);
        }

        // Create Customers
        $customers = [
            [
                'name' => 'Nguyễn Văn A',
                'code' => 'CUS001',
                'phone' => '0901234567',
                'email' => 'nguyenvana@gmail.com',
                'address' => '123 Lê Lợi, Q.1, TP.HCM',
            ],
            [
                'name' => 'Trần Thị B',
                'code' => 'CUS002',
                'phone' => '0909876543',
                'email' => 'tranthib@gmail.com',
                'address' => '456 Nguyễn Huệ, Q.1, TP.HCM',
            ],
            [
                'name' => 'Lê Văn C',
                'code' => 'CUS003',
                'phone' => '0912345678',
                'email' => 'levanc@gmail.com',
                'address' => '789 Trần Hưng Đạo, Q.5, TP.HCM',
            ],
            [
                'name' => 'Phạm Thị D',
                'code' => 'CUS004',
                'phone' => '0923456789',
                'email' => 'phamthid@gmail.com',
                'address' => '321 Võ Văn Tần, Q.3, TP.HCM',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create Suppliers
        $suppliers = [
            [
                'name' => 'Công ty TNHH Phụ Kiện Di Động',
                'code' => 'SUP001',
                'phone' => '0287654321',
                'email' => 'contact@phukien.com',
                'address' => '100 Cộng Hòa, Tân Bình, TP.HCM',
            ],
            [
                'name' => 'Nhà phân phối Apple',
                'code' => 'SUP002',
                'phone' => '0281234567',
                'email' => 'sales@apple-distributor.com',
                'address' => '200 Nguyễn Văn Linh, Q.7, TP.HCM',
            ],
            [
                'name' => 'Công ty Linh Kiện Điện Tử',
                'code' => 'SUP003',
                'phone' => '0289876543',
                'email' => 'info@linhkien.vn',
                'address' => '300 Lý Thường Kiệt, Q.10, TP.HCM',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        echo "✅ Seeded successfully!\n";
        echo "👤 Admin: admin@hz.com / password\n";
        echo "👤 Staff: staff@hz.com / password\n";
    }
}

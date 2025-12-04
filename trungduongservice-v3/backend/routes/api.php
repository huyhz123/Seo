<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SalesOrderController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\DebtController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\DashboardController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/alerts', [DashboardController::class, 'getAlerts']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/form-data', [ProductController::class, 'getFormData']);
    Route::get('/products/search-barcode', [ProductController::class, 'searchByBarcode']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Customers
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
    Route::get('/customers/{id}/debts', [CustomerController::class, 'getDebts']);

    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::post('/suppliers', [SupplierController::class, 'store']);
    Route::get('/suppliers/{id}', [SupplierController::class, 'show']);
    Route::put('/suppliers/{id}', [SupplierController::class, 'update']);
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);
    Route::get('/suppliers/{id}/debts', [SupplierController::class, 'getDebts']);

    // Sales Orders
    Route::get('/sales-orders', [SalesOrderController::class, 'index']);
    Route::post('/sales-orders', [SalesOrderController::class, 'store']);
    Route::get('/sales-orders/stats', [SalesOrderController::class, 'getStats']);
    Route::get('/sales-orders/{id}', [SalesOrderController::class, 'show']);
    Route::post('/sales-orders/{id}/cancel', [SalesOrderController::class, 'cancel']);

    // Purchase Orders
    Route::get('/purchase-orders', [PurchaseOrderController::class, 'index']);
    Route::post('/purchase-orders', [PurchaseOrderController::class, 'store']);
    Route::get('/purchase-orders/stats', [PurchaseOrderController::class, 'getStats']);
    Route::get('/purchase-orders/{id}', [PurchaseOrderController::class, 'show']);
    Route::post('/purchase-orders/{id}/cancel', [PurchaseOrderController::class, 'cancel']);

    // Debts
    Route::get('/debts/customer', [DebtController::class, 'getCustomerDebts']);
    Route::get('/debts/supplier', [DebtController::class, 'getSupplierDebts']);
    Route::post('/debts/payment', [DebtController::class, 'createPayment']);
    Route::get('/debts/payments', [DebtController::class, 'getPayments']);
    Route::get('/debts/stats', [DebtController::class, 'getStats']);

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::get('/inventory/warehouse/{warehouseId}', [InventoryController::class, 'getByWarehouse']);
    Route::get('/inventory/product/{productId}', [InventoryController::class, 'getByProduct']);
    Route::get('/inventory/low-stock', [InventoryController::class, 'getLowStock']);
    Route::get('/inventory/out-of-stock', [InventoryController::class, 'getOutOfStock']);
    Route::get('/inventory/stats', [InventoryController::class, 'getStats']);

    // Reports
    Route::get('/reports/revenue', [ReportController::class, 'revenue']);
    Route::get('/reports/profit', [ReportController::class, 'profit']);
    Route::get('/reports/debts', [ReportController::class, 'debts']);
    Route::get('/reports/inventory', [ReportController::class, 'inventory']);
    Route::get('/reports/top-selling-products', [ReportController::class, 'topSellingProducts']);
    Route::get('/reports/customers', [ReportController::class, 'customers']);

});

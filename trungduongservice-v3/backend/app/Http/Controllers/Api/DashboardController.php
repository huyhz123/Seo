<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use App\Models\CustomerDebt;
use App\Models\SupplierDebt;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get date range (default: last 30 days)
        $fromDate = $request->from_date ?? Carbon::now()->subDays(30)->format('Y-m-d');
        $toDate = $request->to_date ?? Carbon::now()->format('Y-m-d');

        // Sales Statistics
        $totalSales = SalesOrder::where('status', 'completed')
            ->whereBetween('order_date', [$fromDate, $toDate])
            ->count();

        $totalRevenue = SalesOrder::where('status', 'completed')
            ->whereBetween('order_date', [$fromDate, $toDate])
            ->sum('total');

        // Purchase Statistics
        $totalPurchases = PurchaseOrder::where('status', 'completed')
            ->whereBetween('order_date', [$fromDate, $toDate])
            ->count();

        $totalPurchaseCost = PurchaseOrder::where('status', 'completed')
            ->whereBetween('order_date', [$fromDate, $toDate])
            ->sum('total');

        // Profit
        $profit = $totalRevenue - $totalPurchaseCost;

        // Debt Statistics
        $customerDebts = CustomerDebt::whereIn('status', ['pending', 'partial', 'overdue'])
            ->sum('remaining_amount');

        $supplierDebts = SupplierDebt::whereIn('status', ['pending', 'partial', 'overdue'])
            ->sum('remaining_amount');

        $overdueCustomerDebts = CustomerDebt::where('status', 'overdue')
            ->sum('remaining_amount');

        $overdueSupplierDebts = SupplierDebt::where('status', 'overdue')
            ->sum('remaining_amount');

        // Inventory Statistics
        $totalProducts = Product::where('is_active', true)->count();
        $totalStock = Inventory::sum('quantity');
        $lowStockProducts = Inventory::whereHas('product', function($q) {
            $q->whereRaw('inventory.quantity <= products.min_stock');
        })->count();
        $outOfStockProducts = Inventory::where('quantity', '<=', 0)->count();

        // Customer & Supplier counts
        $totalCustomers = Customer::where('is_active', true)->count();
        $totalSuppliers = Supplier::where('is_active', true)->count();

        // Recent Sales (Last 7 days chart data)
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $revenue = SalesOrder::where('status', 'completed')
                ->whereDate('order_date', $date)
                ->sum('total');
            $last7Days[] = [
                'date' => $date,
                'revenue' => $revenue,
            ];
        }

        // Top Selling Products (Last 30 days)
        $topProducts = DB::table('sales_order_items')
            ->join('sales_orders', 'sales_order_items.sales_order_id', '=', 'sales_orders.id')
            ->join('products', 'sales_order_items.product_id', '=', 'products.id')
            ->where('sales_orders.status', 'completed')
            ->whereBetween('sales_orders.order_date', [Carbon::now()->subDays(30), Carbon::now()])
            ->select(
                'products.name',
                DB::raw('SUM(sales_order_items.quantity) as total_quantity'),
                DB::raw('SUM(sales_order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Recent Orders
        $recentOrders = SalesOrder::with(['customer', 'warehouse'])
            ->latest('order_date')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'overview' => [
                    'total_sales' => $totalSales,
                    'total_revenue' => $totalRevenue,
                    'total_purchases' => $totalPurchases,
                    'total_purchase_cost' => $totalPurchaseCost,
                    'profit' => $profit,
                    'customer_debts' => $customerDebts,
                    'supplier_debts' => $supplierDebts,
                    'overdue_customer_debts' => $overdueCustomerDebts,
                    'overdue_supplier_debts' => $overdueSupplierDebts,
                    'total_products' => $totalProducts,
                    'total_stock' => $totalStock,
                    'low_stock_products' => $lowStockProducts,
                    'out_of_stock_products' => $outOfStockProducts,
                    'total_customers' => $totalCustomers,
                    'total_suppliers' => $totalSuppliers,
                ],
                'charts' => [
                    'last_7_days_revenue' => $last7Days,
                    'top_products' => $topProducts,
                ],
                'recent_orders' => $recentOrders,
            ],
        ]);
    }

    public function getAlerts()
    {
        $alerts = [];

        // Low stock alerts
        $lowStockProducts = Inventory::with(['product', 'warehouse'])
            ->whereHas('product', function($q) {
                $q->whereRaw('inventory.quantity <= products.min_stock')
                  ->where('is_active', true);
            })
            ->get();

        foreach ($lowStockProducts as $inventory) {
            $alerts[] = [
                'type' => 'low_stock',
                'severity' => 'warning',
                'message' => "Sản phẩm {$inventory->product->name} sắp hết hàng tại kho {$inventory->warehouse->name} (còn {$inventory->quantity})",
                'data' => $inventory,
            ];
        }

        // Overdue debt alerts
        $overdueCustomerDebts = CustomerDebt::with('customer')
            ->where('status', 'overdue')
            ->get();

        foreach ($overdueCustomerDebts as $debt) {
            $alerts[] = [
                'type' => 'overdue_debt',
                'severity' => 'danger',
                'message' => "Khách hàng {$debt->customer->name} có công nợ quá hạn " . number_format($debt->remaining_amount) . " VNĐ",
                'data' => $debt,
            ];
        }

        $overdueSupplierDebts = SupplierDebt::with('supplier')
            ->where('status', 'overdue')
            ->get();

        foreach ($overdueSupplierDebts as $debt) {
            $alerts[] = [
                'type' => 'overdue_supplier_debt',
                'severity' => 'danger',
                'message' => "Công nợ nhà cung cấp {$debt->supplier->name} quá hạn " . number_format($debt->remaining_amount) . " VNĐ",
                'data' => $debt,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $alerts,
        ]);
    }
}

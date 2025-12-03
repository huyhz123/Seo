<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use App\Models\CustomerDebt;
use App\Models\SupplierDebt;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Revenue Report
    public function revenue(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $sales = SalesOrder::where('status', 'completed')
            ->whereBetween('order_date', [$request->from_date, $request->to_date])
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('SUM(paid_amount) as total_paid'),
                DB::raw('SUM(debt_amount) as total_debt')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $summary = [
            'total_orders' => $sales->sum('total_orders'),
            'total_revenue' => $sales->sum('total_revenue'),
            'total_paid' => $sales->sum('total_paid'),
            'total_debt' => $sales->sum('total_debt'),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'daily_data' => $sales,
                'summary' => $summary,
            ],
        ]);
    }

    // Profit Report
    public function profit(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        // Get sales revenue
        $salesRevenue = SalesOrder::where('status', 'completed')
            ->whereBetween('order_date', [$request->from_date, $request->to_date])
            ->sum('total');

        // Get purchase cost
        $purchaseCost = PurchaseOrder::where('status', 'completed')
            ->whereBetween('order_date', [$request->from_date, $request->to_date])
            ->sum('total');

        $profit = $salesRevenue - $purchaseCost;
        $profitMargin = $salesRevenue > 0 ? ($profit / $salesRevenue) * 100 : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'sales_revenue' => $salesRevenue,
                'purchase_cost' => $purchaseCost,
                'profit' => $profit,
                'profit_margin' => round($profitMargin, 2),
            ],
        ]);
    }

    // Debt Report
    public function debts(Request $request)
    {
        $customerDebts = CustomerDebt::with('customer')
            ->whereIn('status', ['pending', 'partial', 'overdue']);

        $supplierDebts = SupplierDebt::with('supplier')
            ->whereIn('status', ['pending', 'partial', 'overdue']);

        if ($request->status) {
            $customerDebts->where('status', $request->status);
            $supplierDebts->where('status', $request->status);
        }

        $customerDebtsList = $customerDebts->get();
        $supplierDebtsList = $supplierDebts->get();

        $summary = [
            'total_customer_debts' => $customerDebtsList->sum('remaining_amount'),
            'total_supplier_debts' => $supplierDebtsList->sum('remaining_amount'),
            'net_debts' => $customerDebtsList->sum('remaining_amount') - $supplierDebtsList->sum('remaining_amount'),
            'overdue_customer_debts' => $customerDebtsList->where('status', 'overdue')->sum('remaining_amount'),
            'overdue_supplier_debts' => $supplierDebtsList->where('status', 'overdue')->sum('remaining_amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'customer_debts' => $customerDebtsList,
                'supplier_debts' => $supplierDebtsList,
                'summary' => $summary,
            ],
        ]);
    }

    // Inventory Report
    public function inventory(Request $request)
    {
        $query = Product::with(['category', 'brand', 'inventory.warehouse']);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'category' => $product->category->name,
                'brand' => $product->brand->name,
                'total_stock' => $product->getTotalStock(),
                'min_stock' => $product->min_stock,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'inventory_value' => $product->getTotalStock() * $product->purchase_price,
                'is_low_stock' => $product->isLowStock(),
            ];
        });

        $summary = [
            'total_products' => $products->count(),
            'total_stock' => $products->sum('total_stock'),
            'total_inventory_value' => $products->sum('inventory_value'),
            'low_stock_products' => $products->where('is_low_stock', true)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
                'summary' => $summary,
            ],
        ]);
    }

    // Top Selling Products
    public function topSellingProducts(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $limit = $request->limit ?? 10;

        $products = DB::table('sales_order_items')
            ->join('sales_orders', 'sales_order_items.sales_order_id', '=', 'sales_orders.id')
            ->join('products', 'sales_order_items.product_id', '=', 'products.id')
            ->where('sales_orders.status', 'completed')
            ->whereBetween('sales_orders.order_date', [$request->from_date, $request->to_date])
            ->select(
                'products.id',
                'products.name',
                'products.code',
                DB::raw('SUM(sales_order_items.quantity) as total_quantity'),
                DB::raw('SUM(sales_order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.code')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    // Customer Report
    public function customers(Request $request)
    {
        $customers = DB::table('customers')
            ->leftJoin('sales_orders', function($join) use ($request) {
                $join->on('customers.id', '=', 'sales_orders.customer_id')
                     ->where('sales_orders.status', 'completed');
                if ($request->from_date && $request->to_date) {
                    $join->whereBetween('sales_orders.order_date', [$request->from_date, $request->to_date]);
                }
            })
            ->select(
                'customers.id',
                'customers.name',
                'customers.code',
                'customers.phone',
                'customers.total_debt',
                DB::raw('COUNT(sales_orders.id) as total_orders'),
                DB::raw('COALESCE(SUM(sales_orders.total), 0) as total_spent')
            )
            ->groupBy('customers.id', 'customers.name', 'customers.code', 'customers.phone', 'customers.total_debt')
            ->orderByDesc('total_spent')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customers,
        ]);
    }
}

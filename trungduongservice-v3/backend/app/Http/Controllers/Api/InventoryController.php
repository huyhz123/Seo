<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with(['product.category', 'product.brand', 'warehouse']);

        // Filter by warehouse
        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Filter by product
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Search by product name or code
        if ($request->search) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter low stock
        if ($request->low_stock) {
            $query->whereHas('product', function($q) {
                $q->whereRaw('inventory.quantity <= products.min_stock');
            });
        }

        // Filter out of stock
        if ($request->out_of_stock) {
            $query->where('quantity', '<=', 0);
        }

        $perPage = $request->per_page ?? 20;
        $inventory = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $inventory,
        ]);
    }

    public function getByWarehouse($warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        $inventory = Inventory::with(['product.category', 'product.brand'])
            ->where('warehouse_id', $warehouseId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'warehouse' => $warehouse,
                'inventory' => $inventory,
            ],
        ]);
    }

    public function getByProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $inventory = Inventory::with('warehouse')
            ->where('product_id', $productId)
            ->get();

        $totalStock = $inventory->sum('quantity');

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'inventory' => $inventory,
                'total_stock' => $totalStock,
            ],
        ]);
    }

    public function getLowStock(Request $request)
    {
        $query = Inventory::with(['product.category', 'product.brand', 'warehouse'])
            ->whereHas('product', function($q) {
                $q->whereRaw('inventory.quantity <= products.min_stock');
            });

        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        $inventory = $query->get();

        return response()->json([
            'success' => true,
            'data' => $inventory,
        ]);
    }

    public function getOutOfStock(Request $request)
    {
        $query = Inventory::with(['product.category', 'product.brand', 'warehouse'])
            ->where('quantity', '<=', 0);

        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        $inventory = $query->get();

        return response()->json([
            'success' => true,
            'data' => $inventory,
        ]);
    }

    public function getStats(Request $request)
    {
        $query = Inventory::query();

        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        $totalProducts = $query->distinct('product_id')->count();
        $totalStock = $query->sum('quantity');
        $lowStockCount = Inventory::whereHas('product', function($q) {
            $q->whereRaw('inventory.quantity <= products.min_stock');
        })->count();
        $outOfStockCount = $query->where('quantity', '<=', 0)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_products' => $totalProducts,
                'total_stock' => $totalStock,
                'low_stock_count' => $lowStockCount,
                'out_of_stock_count' => $outOfStockCount,
            ],
        ]);
    }
}

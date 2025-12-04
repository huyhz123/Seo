<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'warehouse', 'user', 'items.product']);

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by supplier
        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by warehouse
        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->from_date) {
            $query->where('order_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->where('order_date', '<=', $request->to_date);
        }

        $perPage = $request->per_page ?? 20;
        $orders = $query->latest('order_date')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Generate order number
            $orderNumber = 'PO-' . date('Ymd') . '-' . str_pad(PurchaseOrder::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create order
            $order = PurchaseOrder::create([
                'order_number' => $orderNumber,
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'user_id' => $request->user()->id,
                'order_date' => $request->order_date,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($request->items as $item) {
                $orderItem = PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'] ?? 0,
                    'total' => 0,
                ]);
                $orderItem->calculateTotal();
            }

            // Calculate order totals
            $order->calculateTotals();

            // Complete order (add inventory, create debt)
            $order->complete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tạo đơn nhập hàng thành công',
                'data' => $order->load(['supplier', 'warehouse', 'items.product']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $order = PurchaseOrder::with(['supplier', 'warehouse', 'user', 'items.product', 'supplierDebt'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function cancel($id)
    {
        $order = PurchaseOrder::findOrFail($id);

        if ($order->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng đã bị hủy',
            ], 400);
        }

        if ($order->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Không thể hủy đơn hàng đã hoàn thành',
            ], 400);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Hủy đơn nhập hàng thành công',
            'data' => $order,
        ]);
    }

    public function getStats(Request $request)
    {
        $query = PurchaseOrder::query();

        // Filter by date range
        if ($request->from_date) {
            $query->where('order_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->where('order_date', '<=', $request->to_date);
        }

        $stats = [
            'total_orders' => $query->count(),
            'pending_orders' => (clone $query)->where('status', 'pending')->count(),
            'completed_orders' => (clone $query)->where('status', 'completed')->count(),
            'cancelled_orders' => (clone $query)->where('status', 'cancelled')->count(),
            'total_cost' => (clone $query)->where('status', 'completed')->sum('total'),
            'total_debt' => (clone $query)->where('status', 'completed')->sum('debt_amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}

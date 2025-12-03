<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filter by debt
        if ($request->has_debt) {
            $query->where('total_debt', '>', 0);
        }

        $perPage = $request->per_page ?? 20;
        $suppliers = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $suppliers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:suppliers,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tạo nhà cung cấp thành công',
            'data' => $supplier,
        ], 201);
    }

    public function show($id)
    {
        $supplier = Supplier::with(['purchaseOrders', 'debts'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $supplier,
        ]);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:suppliers,code,' . $id,
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật nhà cung cấp thành công',
            'data' => $supplier,
        ]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->total_debt > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa nhà cung cấp còn công nợ',
            ], 400);
        }

        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa nhà cung cấp thành công',
        ]);
    }

    public function getDebts($id)
    {
        $supplier = Supplier::findOrFail($id);
        $debts = $supplier->debts()
            ->with(['purchaseOrder', 'payments'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $debts,
        ]);
    }
}

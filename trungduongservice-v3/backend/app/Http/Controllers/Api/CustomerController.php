<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

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
        $customers = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $customers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:customers,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tạo khách hàng thành công',
            'data' => $customer,
        ], 201);
    }

    public function show($id)
    {
        $customer = Customer::with(['salesOrders', 'debts'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:customers,code,' . $id,
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật khách hàng thành công',
            'data' => $customer,
        ]);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->total_debt > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa khách hàng còn công nợ',
            ], 400);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa khách hàng thành công',
        ]);
    }

    public function getDebts($id)
    {
        $customer = Customer::findOrFail($id);
        $debts = $customer->debts()
            ->with(['salesOrder', 'payments'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $debts,
        ]);
    }
}

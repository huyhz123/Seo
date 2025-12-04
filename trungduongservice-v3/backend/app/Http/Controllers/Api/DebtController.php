<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerDebt;
use App\Models\SupplierDebt;
use App\Models\DebtPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    // Customer Debts
    public function getCustomerDebts(Request $request)
    {
        $query = CustomerDebt::with(['customer', 'salesOrder']);

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by customer
        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter overdue
        if ($request->overdue) {
            $query->where('status', 'overdue');
        }

        $perPage = $request->per_page ?? 20;
        $debts = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $debts,
        ]);
    }

    public function getSupplierDebts(Request $request)
    {
        $query = SupplierDebt::with(['supplier', 'purchaseOrder']);

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->whereHas('supplier', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by supplier
        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter overdue
        if ($request->overdue) {
            $query->where('status', 'overdue');
        }

        $perPage = $request->per_page ?? 20;
        $debts = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $debts,
        ]);
    }

    // Create payment
    public function createPayment(Request $request)
    {
        $request->validate([
            'debt_type' => 'required|in:customer,supplier',
            'debt_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,other',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Get debt
            if ($request->debt_type === 'customer') {
                $debt = CustomerDebt::findOrFail($request->debt_id);
            } else {
                $debt = SupplierDebt::findOrFail($request->debt_id);
            }

            // Check if payment amount exceeds remaining
            if ($request->amount > $debt->remaining_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số tiền thanh toán vượt quá công nợ còn lại',
                ], 400);
            }

            // Generate payment number
            $paymentNumber = 'PAY-' . date('Ymd') . '-' . str_pad(DebtPayment::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create payment
            $payment = DebtPayment::create([
                'payment_number' => $paymentNumber,
                'debt_type' => $request->debt_type,
                'debt_id' => $request->debt_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'user_id' => $request->user()->id,
            ]);

            // Update debt
            $debt->addPayment($request->amount);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán công nợ thành công',
                'data' => $payment,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Get payment history
    public function getPayments(Request $request)
    {
        $query = DebtPayment::with('user');

        // Filter by debt type
        if ($request->debt_type) {
            $query->where('debt_type', $request->debt_type);
        }

        // Filter by debt id
        if ($request->debt_id) {
            $query->where('debt_id', $request->debt_id);
        }

        // Filter by date range
        if ($request->from_date) {
            $query->where('payment_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->where('payment_date', '<=', $request->to_date);
        }

        $perPage = $request->per_page ?? 20;
        $payments = $query->latest('payment_date')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    // Get debt statistics
    public function getStats()
    {
        $customerDebts = CustomerDebt::whereIn('status', ['pending', 'partial', 'overdue'])->sum('remaining_amount');
        $supplierDebts = SupplierDebt::whereIn('status', ['pending', 'partial', 'overdue'])->sum('remaining_amount');
        $overdueCustomerDebts = CustomerDebt::where('status', 'overdue')->sum('remaining_amount');
        $overdueSupplierDebts = SupplierDebt::where('status', 'overdue')->sum('remaining_amount');

        return response()->json([
            'success' => true,
            'data' => [
                'customer_debts' => $customerDebts,
                'supplier_debts' => $supplierDebts,
                'overdue_customer_debts' => $overdueCustomerDebts,
                'overdue_supplier_debts' => $overdueSupplierDebts,
                'net_debts' => $customerDebts - $supplierDebts,
            ],
        ]);
    }
}

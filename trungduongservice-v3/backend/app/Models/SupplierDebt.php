<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SupplierDebt extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_order_id',
        'amount',
        'paid_amount',
        'remaining_amount',
        'due_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function payments()
    {
        return DebtPayment::where('debt_type', 'supplier')
            ->where('debt_id', $this->id);
    }

    // Helper methods
    public function addPayment($amount)
    {
        $this->paid_amount += $amount;
        $this->remaining_amount = $this->amount - $this->paid_amount;

        if ($this->remaining_amount <= 0) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        }

        $this->save();
        $this->supplier->updateTotalDebt();

        return $this;
    }

    public function checkOverdue()
    {
        if ($this->due_date && Carbon::parse($this->due_date)->isPast() && $this->remaining_amount > 0) {
            $this->status = 'overdue';
            $this->save();
        }
        return $this;
    }
}

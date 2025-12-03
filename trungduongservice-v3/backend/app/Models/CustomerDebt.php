<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerDebt extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sales_order_id',
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
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function payments()
    {
        return DebtPayment::where('debt_type', 'customer')
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
        $this->customer->updateTotalDebt();

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

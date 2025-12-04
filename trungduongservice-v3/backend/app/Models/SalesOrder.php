<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'warehouse_id',
        'user_id',
        'order_date',
        'subtotal',
        'discount',
        'tax',
        'total',
        'paid_amount',
        'debt_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'debt_amount' => 'decimal:2',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function customerDebt()
    {
        return $this->hasOne(CustomerDebt::class);
    }

    // Helper methods
    public function calculateTotals()
    {
        $this->subtotal = $this->items()->sum('total');
        $this->total = $this->subtotal - $this->discount + $this->tax;
        $this->debt_amount = $this->total - $this->paid_amount;
        $this->save();
        return $this;
    }

    public function complete()
    {
        $this->status = 'completed';
        $this->save();

        // Reduce inventory
        foreach ($this->items as $item) {
            $inventory = Inventory::firstOrCreate([
                'warehouse_id' => $this->warehouse_id,
                'product_id' => $item->product_id,
            ], ['quantity' => 0]);

            $inventory->reduceStock($item->quantity);
        }

        // Create debt if needed
        if ($this->debt_amount > 0) {
            CustomerDebt::create([
                'customer_id' => $this->customer_id,
                'sales_order_id' => $this->id,
                'amount' => $this->debt_amount,
                'remaining_amount' => $this->debt_amount,
                'status' => 'pending',
            ]);

            $this->customer->updateTotalDebt();
        }

        return $this;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'debt_type',
        'debt_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function debt()
    {
        if ($this->debt_type === 'customer') {
            return $this->belongsTo(CustomerDebt::class, 'debt_id');
        } else {
            return $this->belongsTo(SupplierDebt::class, 'debt_id');
        }
    }

    // Helper methods
    public function getDebt()
    {
        if ($this->debt_type === 'customer') {
            return CustomerDebt::find($this->debt_id);
        } else {
            return SupplierDebt::find($this->debt_id);
        }
    }
}

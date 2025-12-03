<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'address',
        'total_debt',
        'is_active',
    ];

    protected $casts = [
        'total_debt' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function debts()
    {
        return $this->hasMany(CustomerDebt::class);
    }

    // Helper methods
    public function updateTotalDebt()
    {
        $this->total_debt = $this->debts()
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->sum('remaining_amount');
        $this->save();
        return $this;
    }

    public function getPendingDebts()
    {
        return $this->debts()
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->get();
    }
}

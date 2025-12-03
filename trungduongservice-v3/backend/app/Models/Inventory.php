<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper methods
    public function addStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();
        return $this;
    }

    public function reduceStock($quantity)
    {
        if ($this->quantity < $quantity) {
            throw new \Exception('Không đủ hàng trong kho');
        }
        $this->quantity -= $quantity;
        $this->save();
        return $this;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'barcode',
        'category_id',
        'brand_id',
        'unit_id',
        'description',
        'purchase_price',
        'selling_price',
        'image',
        'min_stock',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean',
        'min_stock' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    // Helper methods
    public function getTotalStock()
    {
        return $this->inventory()->sum('quantity');
    }

    public function getStockInWarehouse($warehouseId)
    {
        $inventory = $this->inventory()->where('warehouse_id', $warehouseId)->first();
        return $inventory ? $inventory->quantity : 0;
    }

    public function isLowStock()
    {
        return $this->getTotalStock() <= $this->min_stock;
    }
}

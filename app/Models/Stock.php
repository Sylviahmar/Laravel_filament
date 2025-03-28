<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['product_id', 'quantity', 'purchase_price', 'batch_name'];

    public function product()
    {
        return $this->belongsTo(Product::class); // ✅ Each stock belongs to one product
    }


    public function saleItems()
    {
        return $this->hasMany(SaleItem::class); // ✅ Links Stock to Sale Items
    }
}

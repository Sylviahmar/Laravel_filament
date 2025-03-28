<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['total_price', 'discount']; // ✅ Allow mass assignment

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class); // ✅ Corrected: Now inside a function
    }
}

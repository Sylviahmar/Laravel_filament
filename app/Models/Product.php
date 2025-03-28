<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'barcode', 'description']; // ✅ Allows mass assignment
    public function stocks()
    {
        return $this->hasMany(Stock::class); // ✅ Product has many stocks
    }


}

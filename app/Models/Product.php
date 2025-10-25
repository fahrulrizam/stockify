<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'supplier_id', 'stock', 'price', 
        'purchase_price', 'description', 'status', 'image', 'stocks'
    ];

public function stockIns()
{
    return $this->hasMany(StockIn::class);
}

public function stockOuts()
{
    return $this->hasMany(StockOut::class);
}

public function category()
{
    return $this->belongsTo(Category::class);
}

public function supplier()
{
    return $this->belongsTo(Supplier::class);
}
}

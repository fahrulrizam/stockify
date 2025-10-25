<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in'; // nama tabel di database
    protected $fillable = [
        'product_id',
        'quantity',
        'date',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out'; // nama tabel di database
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

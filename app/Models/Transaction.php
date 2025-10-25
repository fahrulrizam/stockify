<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Fillable fields, tambahkan 'status' untuk konfirmasi staff
    protected $fillable = [
        'product_id',
        'quantity',
        'type',       // 'masuk' atau 'keluar'
        'total',      // opsional, bisa untuk nilai total
        'user_id',    // user yang melakukan transaksi
        'description',// keterangan
        'status'      // 'pending' / 'confirmed'
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke User yang melakukan transaksi
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

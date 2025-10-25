<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::create([
            'product_id' => 1,
            'quantity' => 5,
            'status' => 'success',
            'type' => 'in',
            'note' => 'Penambahan stok awal',
        ]);

        Transaction::create([
            'product_id' => 2,
            'quantity' => 2,
            'status' => 'pending',
            'type' => 'out',
            'note' => 'Pesanan customer',
        ]);
    }
}

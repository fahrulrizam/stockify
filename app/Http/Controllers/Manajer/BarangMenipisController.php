<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class BarangMenipisController extends Controller
{
    public function index()
    {
        $stokMenipis = Product::with('category', 'supplier')
                        ->where('stock', '<=', 5)
                        ->orderBy('stock', 'asc')
                        ->get();

        return view('manajer.barang-menipis', compact('stokMenipis'));
    }
}

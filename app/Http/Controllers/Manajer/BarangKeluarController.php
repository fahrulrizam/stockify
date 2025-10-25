<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = Transaction::with('product')
            ->where('type', 'keluar')
            ->latest()
            ->get();

        return view('manajer.barang-keluar', compact('barangKeluar'));
    }

    public function create()
    {
        $products = Product::all();
        return view('manajer.barang-keluar-create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk barang keluar!');
        }

        Transaction::create([
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'type'       => 'keluar',
        ]);

        // Kurangi stok produk
        $product->decrement('stock', $request->quantity);

        return redirect()->route('manajer.barangKeluar')
                         ->with('success', 'Barang keluar berhasil dicatat!');
    }
}

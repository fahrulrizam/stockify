<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function index()
    {
        // Ambil semua produk beserta kategori & supplier
        $products = Product::with('category', 'supplier')->get();

        // Ambil transaksi barang keluar (opsional)
        $transactions = StockOpname::with('product')->latest()->get();

        // Kirim variabel ke view
        return view('staff.stockopname', compact('products', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'integer|min:0',
            'catatan' => 'nullable|array',
        ]);

        $stokFisik = $request->input('stok_fisik', []);
        $catatan   = $request->input('catatan', []);

        DB::transaction(function() use ($stokFisik, $catatan) {
            foreach ($stokFisik as $produkId => $stok) {
                $produk = Product::findOrFail($produkId);

                StockOpname::create([
                    'product_id'  => $produkId,
                    'stok_sistem' => $produk->stock,
                    'stok_fisik'  => $stok,
                    'catatan'     => $catatan[$produkId] ?? null,
                    'user_id'     => auth()->id(),
                ]);

                $produk->update(['stock' => $stok]);
            }
        });

        return redirect()->route('staff.stockopname.index')
                         ->with('success', 'Stock opname berhasil disimpan.');
    }
}

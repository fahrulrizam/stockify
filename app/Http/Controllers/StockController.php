<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Tampilkan daftar stok barang.
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'stock', 'unit', 'price')->get();

        return view('stocks.index', compact('products'));
    }

    /**
     * Proses barang masuk (menambah stok).
     */
    public function storeIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);
            $product->increment('stock', $request->quantity);

            // Simpan ke log transaksi stok
            DB::table('stock_transactions')->insert([
                'product_id' => $product->id,
                'type'       => 'IN',
                'quantity'   => $request->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    /**
     * Proses barang keluar (mengurangi stok).
     */
    public function storeOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);

            // Pengecekan stok dipindahkan ke dalam transaction
            if ($product->stock < $request->quantity) {
                // Menggunakan throw Exception agar transaksi di-rollback secara otomatis
                throw new \Exception('Stok tidak mencukupi.', 400); 
            }

            $product->decrement('stock', $request->quantity);

            // Simpan ke log transaksi stok
            DB::table('stock_transactions')->insert([
                'product_id' => $product->id,
                'type'       => 'OUT',
                'quantity'   => $request->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
        
        return redirect()->back()->with('success', 'Barang keluar berhasil dikurangi dari stok.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class StockController extends Controller
{
    // Menampilkan daftar stok barang
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('admin.stocks.index', compact('products'));
    }

    // Form tambah stok baru (Barang Masuk)
    public function create()
    {
        $products = Product::all();
        return view('admin.stocks.create', compact('products'));
    }

    // Simpan stok baru (Barang Masuk)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);

            // Catat transaksi masuk
            Transaction::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'user_id' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // Update stok produk
            $product->increment('stock', $request->quantity);

            return redirect()->route('admin.stocks.index')
                             ->with('success', 'Stok barang masuk berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal mencatat stok: '.$e->getMessage())
                             ->withInput();
        }
    }

    // Form edit stok (Barang Keluar / Stock Opname)
    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        $products = Product::all(); // Untuk dropdown produk
        return view('admin.stocks.edit', compact('product', 'products'));
    }

    // Update stok (Barang Keluar / Stock Opname)
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
            'type' => 'required|in:out,opname_decrease,opname_increase',
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->quantity;
        $type = $request->type;

        if ($type === 'out' || $type === 'opname_decrease') {
            if ($product->stock < $quantity) {
                return redirect()->back()
                                 ->with('error', 'Jumlah barang keluar melebihi stok yang tersedia.')
                                 ->withInput();
            }
            $product->decrement('stock', $quantity);
        } elseif ($type === 'opname_increase') {
            $product->increment('stock', $quantity);
        }

        // Catat transaksi
        Transaction::create([
            'product_id' => $product->id,
            'type' => $type,
            'quantity' => $quantity,
            'user_id' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.stocks.index')
                         ->with('success', 'Stok produk berhasil diperbarui.');
    }

    // Hapus stok (tidak diizinkan)
    public function destroy($id)
    {
        return redirect()->route('admin.stocks.index')
                         ->with('error', 'Penghapusan riwayat stok tidak diizinkan.');
    }
}

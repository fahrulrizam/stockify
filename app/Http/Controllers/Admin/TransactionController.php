<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('product')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
        ]);

        // ✅ Ubah nilai agar sesuai dengan enum('in','out') di database
        $validated['type'] = $validated['type'] === 'masuk' ? 'in' : 'out';

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $products = Product::all();
        return view('admin.transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:masuk,keluar',
        ]);

        $validated['type'] = $validated['type'] === 'masuk' ? 'in' : 'out';

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi berhasil diperbarui.');
    }
}

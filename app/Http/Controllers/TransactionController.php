<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    /**
     * ===============================
     * Untuk Manajer: Barang Masuk
     * ===============================
     */
    

public function index()
{
    // Ambil transaksi terbaru, termasuk relasi product dan user, paginate 10 per halaman
    $transactions = Transaction::with(['product', 'user'])->latest()->paginate(10);

    return view('transactions.index', compact('transactions'));
}

    public function incoming()
    {
        $products = Product::all();
        $transactions = Transaction::where('type', 'in')->latest()->paginate(20);
        return view('transactions.incoming', compact('products', 'transactions'));
    }

    public function storeIncoming(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->increment('stock', $request->quantity);

        Transaction::create([
            'product_id' => $product->id,
            'type'       => 'in', // ✅ disesuaikan
            'quantity'   => $request->quantity,
            'user_id'    => Auth::id(),
            'status'     => 'pending'
        ]);

        return back()->with('success', 'Barang masuk dicatat, menunggu konfirmasi staff.');
    }

    /**
     * ===============================
     * Untuk Manajer: Barang Keluar
     * ===============================
     */
    public function outgoing()
    {
        $products = Product::all();
        $transactions = Transaction::where('type', 'out')->latest()->paginate(20);
        return view('transactions.outgoing', compact('products', 'transactions'));
    }

    public function storeOutgoing(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $product->decrement('stock', $request->quantity);

        Transaction::create([
            'product_id' => $product->id,
            'type'       => 'out', // ✅ disesuaikan
            'quantity'   => $request->quantity,
            'user_id'    => Auth::id(),
            'status'     => 'pending'
        ]);

        return back()->with('success', 'Barang keluar dicatat, menunggu konfirmasi staff.');
    }

    /**
     * ===============================
     * Untuk Staff: Konfirmasi Transaksi
     * ===============================
     */
    public function pendingIncoming()
    {
        $transactions = Transaction::where('type', 'in')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('transactions.pending_incoming', compact('transactions'));
    }

    public function confirmIncoming($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'confirmed']);
        return back()->with('success', 'Barang masuk dikonfirmasi.');
    }

    public function pendingOutgoing()
    {
        $transactions = Transaction::where('type', 'out')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('transactions.pending_outgoing', compact('transactions'));
    }

    public function confirmOutgoing($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'confirmed']);
        return back()->with('success', 'Barang keluar dikonfirmasi.');
    }

    /**
     * ===============================
     * Untuk Admin: Laporan Transaksi
     * ===============================
     */
    public function report()
    {
        $transactions = Transaction::with('product', 'user')->latest()->paginate(20);
        return view('transactions.report', compact('transactions'));
    }
}

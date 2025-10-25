<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * 📦 Menampilkan daftar barang masuk
     */
    public function indexIncoming()
    {
        $transactions = Transaction::with('product')
            ->where('type', 'in')
            ->latest()
            ->paginate(10);

        return view('staff.transactions.incoming', compact('transactions'));
    }

    /**
     * 📤 Menampilkan daftar barang keluar
     */
    public function indexOutgoing()
    {
        $transactions = Transaction::with('product')
            ->where('type', 'out')
            ->latest()
            ->paginate(10);

        return view('staff.transactions.outgoing', compact('transactions'));
    }

    /**
     * ✅ Konfirmasi barang masuk
     */
    public function confirmIncoming($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->confirmed = true;
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi barang masuk berhasil dikonfirmasi.');
    }

    /**
     * ✅ Konfirmasi barang keluar
     */
    public function confirmOutgoing($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->confirmed = true;
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi barang keluar berhasil dikonfirmasi.');
    }

    /**
     * 📊 Dashboard Staff - menampilkan total barang masuk & keluar
     */
    public function index()
    {
        // Jika hanya transaksi yang sudah dikonfirmasi:
        $barangMasuk = Transaction::where('type', 'in')->where('confirmed', true)->count();
        $barangKeluar = Transaction::where('type', 'out')->where('confirmed', true)->count();

        return view('staff.dashboard', compact('barangMasuk', 'barangKeluar'));
    }
}

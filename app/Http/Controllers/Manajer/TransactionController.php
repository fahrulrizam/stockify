<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // ===============================
    // 📥 Barang Masuk
    // ===============================
    public function incoming()
    {
        $transactions = Transaction::where('type', 'in')
            ->where('confirmed', true)
            ->latest()
            ->paginate(20);

        $totalBarangMasuk = Transaction::where('type', 'in')
            ->where('confirmed', true)
            ->sum('quantity');

        $products = Product::all();

        return view('manajer.transactions.incoming', compact('transactions', 'totalBarangMasuk', 'products'));
    }

    // ===============================
    // 📤 Barang Keluar
    // ===============================
    public function outgoing()
    {
        $transactions = Transaction::where('type', 'out')
            ->where('confirmed', true)
            ->latest()
            ->paginate(20);

        $totalBarangKeluar = Transaction::where('type', 'out')
            ->where('confirmed', true)
            ->sum('quantity');

        $products = Product::all();

        return view('manajer.transactions.outgoing', compact('transactions', 'totalBarangKeluar', 'products'));
    }

    // ===============================
    // 💾 Simpan Barang Masuk
    // ===============================
    public function storeIncoming(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);
                $product->increment('stock', $request->quantity);

                Transaction::create([
                    'product_id'  => $product->id,
                    'type'        => 'in',
                    'quantity'    => $request->quantity,
                    'description' => $request->description,
                    'user_id'     => auth()->id(),
                    'confirmed'   => true,
                ]);
            });

            return back()->with('success', 'Barang masuk berhasil dicatat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat barang masuk: ' . $e->getMessage());
        }
    }

    // ===============================
    // 💾 Simpan Barang Keluar
    // ===============================
    public function storeOutgoing(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);

                if ($product->stock < $request->quantity) {
                    throw new \Exception('Stok tidak mencukupi.');
                }

                $product->decrement('stock', $request->quantity);

                Transaction::create([
                    'product_id'  => $product->id,
                    'type'        => 'out',
                    'quantity'    => $request->quantity,
                    'description' => $request->description,
                    'user_id'     => auth()->id(),
                    'confirmed'   => true,
                ]);
            });

            return back()->with('success', 'Barang keluar berhasil dicatat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat barang keluar: ' . $e->getMessage());
        }
    }

    // ===============================
    // 📄 Export Barang Masuk PDF
    // ===============================
    public function exportIncoming()
    {
        $transactions = Transaction::with(['product', 'user'])
            ->where('type', 'in')
            ->where('confirmed', true)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('manajer.transactions.export_barang_masuk', compact('transactions'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('barang_masuk_' . date('Ymd') . '.pdf');
    }

    // ===============================
    // 📄 Export Barang Keluar PDF
    // ===============================
    public function exportOutgoing()
    {
        $transactions = Transaction::with(['product', 'user'])
            ->where('type', 'out')
            ->where('confirmed', true)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('manajer.transactions.export_barang_keluar', compact('transactions'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('barang_keluar_' . date('Ymd') . '.pdf');
    }

    // ===============================
    // 📊 Semua Transaksi
    // ===============================
    public function index()
    {
        $transactions = Transaction::with(['product', 'user'])
            ->where('confirmed', true)
            ->latest()
            ->paginate(10);

        return view('manajer.transactions.index', compact('transactions'));
    }
}

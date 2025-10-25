<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // import Log
use Illuminate\Support\Facades\Auth; // import Auth untuk user_id

class IncomingController extends Controller
{
    /**
     * Menampilkan daftar barang masuk untuk staff gudang.
     */
    public function index()
    {
        // Ambil semua transaksi tipe 'masuk' beserta data produk terkait
        $data = Transaction::where('type', 'masuk')
            ->with('product') // eager loading untuk menghindari N+1
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.barangmasuk', compact('data'));
    }

    /**
     * Konfirmasi barang masuk oleh staff.
     * Logika: menambahkan stok ke produk dan update status transaksi.
     */
    public function konfirmasi($id)
    {
        $trx = Transaction::findOrFail($id);

        // Pastikan transaksi belum dikonfirmasi
        if ($trx->status === 'selesai') {
            return redirect()
                ->route('staff.barangmasuk')
                ->with('error', 'Transaksi ini sudah dikonfirmasi sebelumnya.');
        }

        DB::beginTransaction();

        try {
            $product = Product::find($trx->product_id);

            if (!$product) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Produk tidak ditemukan. Konfirmasi dibatalkan.');
            }

            // Tambahkan kuantitas barang masuk ke stok produk
            $product->stock += $trx->quantity;
            $product->save();

            // Update status transaksi
            $trx->status = 'selesai';
            $trx->user_id_konfirmasi = Auth::id(); // pastikan staff login
            $trx->save();

            DB::commit();

            return redirect()
                ->route('staff.barangmasuk')
                ->with('success', 'Barang masuk berhasil dikonfirmasi dan stok telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal konfirmasi Barang Masuk: ' . $e->getMessage()); // pakai Log facade

            return redirect()
                ->route('staff.barangmasuk')
                ->with('error', 'Konfirmasi gagal karena masalah sistem. Silakan coba lagi.');
        }
    }
}

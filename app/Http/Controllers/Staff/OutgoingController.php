<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OutgoingController extends Controller
{
    /**
     * Tampilkan daftar transaksi barang keluar.
     */
    public function index()
    {
        // Ambil semua transaksi tipe 'keluar' beserta data produk terkait
        $data = Transaction::where('type', 'keluar')
            ->with('product')
            ->latest()
            ->get();

        return view('staff.barangkeluar', compact('data'));
    }

    /**
     * Konfirmasi barang keluar oleh staff.
     */
    public function konfirmasi($id)
    {
        $trx = Transaction::findOrFail($id);

        // Cek status transaksi
        if ($trx->status === 'selesai') {
            return redirect()->back()->with('error', 'Transaksi ini sudah dikonfirmasi sebelumnya.');
        }

        // Mulai transaksi DB
        DB::beginTransaction();

        try {
            // Ambil produk terkait
            $product = Product::find($trx->product_id);

            if (!$product) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Produk tidak ditemukan. Konfirmasi dibatalkan.');
            }

            // Validasi stok cukup
            if ($product->stock < $trx->quantity) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk konfirmasi barang keluar.');
            }

            // Kurangi stok produk
            $product->stock -= $trx->quantity;
            $product->save();

            // Update status transaksi
            $trx->status = 'selesai';
            $trx->user_id_konfirmasi = Auth::id(); // pastikan staff login
            $trx->save();

            DB::commit();

            return redirect()->back()->with('success', 'Barang keluar berhasil dikonfirmasi dan stok diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal konfirmasi Barang Keluar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Konfirmasi gagal. Silakan coba lagi.');
        }
    }
}

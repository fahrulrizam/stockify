<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman laporan (transaksi & produk)
     */
    public function index()
    {
        $transactions = Transaction::with('product')->latest()->get();
        $products = Product::with(['category', 'supplier'])->get();

        return view('admin.reports.index', compact('transactions', 'products'));
    }

    /**
     * Ekspor laporan transaksi ke file PDF
     */
    public function exportPdf(Request $request)
    {
        // Bisa tambahkan filter tanggal jika dibutuhkan
        $transactions = Transaction::with('product')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('transactions'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan_transaksi_' . now()->format('Ymd_His') . '.pdf');
    }
}

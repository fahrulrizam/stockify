<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Hanya manajer gudang yang boleh mengakses
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'manajer') {
                abort(403, 'Akses ditolak. Anda bukan Manajer Gudang.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // ===============================
        // 📊 STATISTIK DASAR
        // ===============================
        $totalProduk = Product::count();

        // Hitung total barang masuk dan keluar dari tabel transaksi
        $barangMasuk = Transaction::whereIn('type', ['in', 'masuk'])->sum('quantity');
        $barangKeluar = Transaction::whereIn('type', ['out', 'keluar'])->sum('quantity');

        // Produk stok menipis
        $stokMenipis = Product::where('stock', '<=', 5)->get();

        // ===============================
        // 🧾 DATA SUPPLIER & PRODUK
        // ===============================
        $suppliers = Supplier::latest()->take(5)->get();

        $products = Product::with(['category', 'supplier'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // ===============================
        // 📈 DATA UNTUK CHART
        // ===============================
        $topProducts = Product::orderBy('stock', 'desc')->take(5)->get();
        $chartLabels = $topProducts->pluck('name');
        $chartData = $topProducts->pluck('stock');

        // ===============================
        // 🚀 KIRIM SEMUA DATA KE VIEW
        // ===============================
        return view('manajer.dashboard', compact(
            'totalProduk',
            'barangMasuk',
            'barangKeluar',
            'stokMenipis',
            'suppliers',
            'products',
            'chartLabels',
            'chartData'
        ));
    }
}

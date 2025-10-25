<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Hanya staff gudang yang boleh mengakses
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'staff') {
                abort(403, 'Akses ditolak. Anda bukan Staff Gudang.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Total produk
        $totalProduk = Product::count();

        // Barang masuk = transaksi type 'in' atau 'masuk'
        $barangMasuk = Transaction::whereIn('type', ['in','masuk'])->sum('quantity');

        // Barang keluar = transaksi type 'out' atau 'keluar'
        $barangKeluar = Transaction::whereIn('type', ['out','keluar'])->sum('quantity');

        // Produk stok menipis (misal stok <= 5)
        $stokMenipis = Product::where('stock', '<=', 5)->get();

        // Semua produk, tambahkan status
        $products = Product::with(['category','supplier'])->get()->map(function($p) {
            if($p->stock == 0){
                $p->status = 'Habis';
                $p->statusColor = 'bg-red-500 text-white';
            } elseif($p->stock <= 5){
                $p->status = 'Menipis';
                $p->statusColor = 'bg-yellow-400 text-black';
            } else {
                $p->status = 'Aman';
                $p->statusColor = 'bg-green-500 text-white';
            }
            return $p;
        });

        // Chart Top 5 produk berdasarkan stok
        $topProducts = Product::orderBy('stock','desc')->take(5)->get();
        $chartLabels = $topProducts->pluck('name');
        $chartData = $topProducts->pluck('stock');

        return view('staff.dashboard', compact(
            'totalProduk',
            'barangMasuk',
            'barangKeluar',
            'stokMenipis',
            'products',
            'chartLabels',
            'chartData'
        ));
    }
}

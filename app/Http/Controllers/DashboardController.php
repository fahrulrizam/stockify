<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Setting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $minStockLimit = 5;

        // 🔹 Ambil setting dari database
        $settings = Setting::pluck('value', 'key')->toArray();
        $app_name = $settings['app_name'] ?? 'Stockify';
        $company_name = $settings['company_name'] ?? 'Perusahaan';

        // 🔹 Hitung jumlah produk dengan stok menipis
        $lowStockCount = Product::where('stock', '<=', $minStockLimit)->count();

        // 🔹 Filter tanggal jika ada
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // 🔹 Ambil semua produk
        $products = Product::with(['category', 'supplier'])->get();

        // 🔹 Ambil 5 produk dengan stok tertinggi untuk chart
        $topProducts = Product::orderBy('stock', 'desc')
            ->take(5)
            ->get(['name', 'stock']);

        // 🔹 Data untuk Chart.js
        $chartLabels = $topProducts->pluck('name')->all();
        $chartData   = $topProducts->pluck('stock')->all();

        // 🔹 Hitung total transaksi masuk dan keluar
        $barangMasuk = Transaction::where('type', 'masuk')->sum('quantity');
        $barangKeluar = Transaction::where('type', 'keluar')->sum('quantity');

        // 🔹 Ambil transaksi (bisa difilter tanggal)
        $transactions = Transaction::with('product')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59',
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // 🔹 Statistik global
        $totalProduk = Product::count();
        $totalMasuk = Transaction::where('type', 'masuk')->count();
        $totalKeluar = Transaction::where('type', 'keluar')->count();

        // 🔹 Statistik periode 30 hari terakhir
        $periodeAwal = Carbon::now()->subDays(30);
        $periodeAkhir = Carbon::now();

        $barangMasukPerHari = Transaction::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(quantity) as total')
            )
            ->where('type', 'masuk')
            ->whereBetween('created_at', [$periodeAwal, $periodeAkhir])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        $barangKeluarPerHari = Transaction::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(quantity) as total')
            )
            ->where('type', 'keluar')
            ->whereBetween('created_at', [$periodeAwal, $periodeAkhir])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        // 🔹 Aktivitas terbaru
        $aktivitasTerbaru = Transaction::with(['product', 'user'])
            ->latest()
            ->take(6)
            ->get();

        // 🔹 Kirim semua data ke view
        return view('admin.dashboard', compact(
            'app_name',
            'company_name',
            'products',
            'transactions',
            'topProducts',
            'barangMasuk',
            'barangKeluar',
            'chartLabels',
            'chartData',
            'lowStockCount',
            'totalProduk',
            'totalMasuk',
            'totalKeluar',
            'barangMasukPerHari',
            'barangKeluarPerHari',
            'aktivitasTerbaru'
        ));
    }
}

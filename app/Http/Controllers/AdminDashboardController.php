<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik singkat
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalTransactions = Transaction::count();

        // Data untuk chart stok barang
        $stockData = Product::select('name', 'stock')->orderBy('name')->get();

        // Data untuk grafik transaksi masuk & keluar (per bulan)
        $monthlyTransactions = Transaction::selectRaw("
                MONTH(created_at) as month,
                SUM(CASE WHEN type = 'in' THEN quantity ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN quantity ELSE 0 END) as total_out
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'totalTransactions' => $totalTransactions,
            'stockData' => $stockData,
            'monthlyTransactions' => $monthlyTransactions,
        ]);
    }
}

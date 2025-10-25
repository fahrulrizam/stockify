<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman laporan stok.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // 🔍 Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 🔍 Filter stok minimal
        if ($request->filled('min_stock')) {
            $query->where('stock', '>=', $request->min_stock);
        }

        // 🔍 Filter stok maksimal
        if ($request->filled('max_stock')) {
            $query->where('stock', '<=', $request->max_stock);
        }

        $products = $query->orderBy('name')->get();
        $categories = Category::all();

        return view('manajer.reports.index', compact('products', 'categories'));
    }

    /**
     * Ekspor laporan stok ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('name')->get();
        $pdf = Pdf::loadView('manajer.reports.pdf', compact('products'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan_stok_manajer.pdf');
    }
}

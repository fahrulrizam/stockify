<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('min_stock')) {
            $query->where('stock', '>=', $request->min_stock);
        }
        if ($request->filled('max_stock')) {
            $query->where('stock', '<=', $request->max_stock);
        }

        $products = $query->get();
        $categories = Category::all();

        return view('manajer.stocks.index', compact('products', 'categories'));
    }


    public function exportPdf(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('min_stock')) {
            $query->where('stock', '>=', $request->min_stock);
        }
        if ($request->filled('max_stock')) {
            $query->where('stock', '<=', $request->max_stock);
        }

        $products = $query->get();

        $pdf = PDF::loadView('manajer.stocks.pdf', compact('products'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan_stok_barang.pdf');
    }
}

<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

// Tambahkan use untuk export & PDF
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangMasukExport;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangMasukController extends Controller
{
    // Daftar barang masuk
    public function index(Request $request)
    {
        $barangMasuk = Transaction::with('product')
            ->where('type', 'masuk')
            ->latest()
            ->paginate(10);

        return view('manajer.barang-masuk', compact('barangMasuk'));
    }

    // Form tambah barang masuk
    public function create()
    {
        $products = Product::all();
        return view('manajer.barang-masuk-create', compact('products'));
    }

    // Simpan barang masuk
   public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $transaction = Transaction::create([
    'product_id' => $request->product_id,
    'quantity' => $request->quantity,
    'type' => 'Masuk',  // ✅ huruf kapital sesuai ENUM
    'description' => $request->description,
]);


    $product = Product::find($request->product_id);
    $product->increment('stock', $request->quantity);

    return redirect()->route('manajer.barangMasuk')->with('success', 'Barang masuk berhasil ditambahkan!');
}

    // EXPORT Excel / PDF
    public function export(Request $request)
    {
        $format = $request->query('format', 'excel');

        $query = Transaction::with('product')->where('type', 'masuk');

        if($request->filled('from')){
            $query->whereDate('created_at', '>=', $request->from);
        }
        if($request->filled('to')){
            $query->whereDate('created_at', '<=', $request->to);
        }

        $barangMasuk = $query->get();

        if($format === 'pdf'){
            $pdf = Pdf::loadView('manajer.barang-masuk-pdf', compact('barangMasuk'));
            return $pdf->download('barang_masuk.pdf');
        } else {
            return Excel::download(new BarangMasukExport($barangMasuk), 'barang_masuk.xlsx');
        }
    }
}

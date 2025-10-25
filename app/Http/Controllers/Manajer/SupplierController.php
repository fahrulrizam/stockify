<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function __construct()
    {
        // Hanya role manajer yang boleh akses
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'manajer') {
                abort(403, 'Akses ditolak. Anda bukan Manajer Gudang.');
            }
            return $next($request);
        });
    }

    /**
     * Tampilkan daftar supplier (read-only)
     */
    public function index()
    {
        // Sama seperti admin: urutkan dan paginasi
        $suppliers = Supplier::orderBy('name', 'asc')->paginate(10);

        return view('manajer.suppliers.index', compact('suppliers'));
    }

    /**
     * Detail supplier (opsional)
     */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('manajer.suppliers.show', compact('supplier'));
    }
}

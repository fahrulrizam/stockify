<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class OpnameController extends Controller
{
    public function index()
    {
        $produk = Product::all();
        return view('staff.stockopname', compact('produk'));
    }
}

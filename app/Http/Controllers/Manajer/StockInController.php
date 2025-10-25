<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\StockIn;

class StockInController extends Controller
{
    public function index()
    {
        $stockins = StockIn::with('product')->latest()->get();
        return view('manajer.stockin.index', compact('stockins'));
    }
}

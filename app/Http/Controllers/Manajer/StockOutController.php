<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\StockOut;

class StockOutController extends Controller
{
    public function index()
    {
        $stockouts = StockOut::with('product')->latest()->get();
        return view('manajer.stockout.index', compact('stockouts'));
    }
}

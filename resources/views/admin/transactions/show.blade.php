@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6 mt-10">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Detail Transaksi</h2>

    <div class="mb-3">
        <strong>Produk:</strong> {{ $transaction->product->name }}
    </div>
    <div class="mb-3">
        <strong>Tipe:</strong> 
        <span class="{{ $transaction->type === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
            {{ ucfirst($transaction->type) }}
        </span>
    </div>
    <div class="mb-3">
        <strong>Jumlah:</strong> {{ $transaction->quantity }}
    </div>
    <div class="mb-3">
        <strong>Keterangan:</strong> {{ $transaction->description ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i') }}
    </div>

    <a href="{{ route('transactions.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-3 inline-block">
        Kembali
    </a>
</div>
@endsection

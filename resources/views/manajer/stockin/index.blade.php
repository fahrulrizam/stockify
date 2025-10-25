@extends('layouts.app')

@section('title', 'Barang Masuk')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4 text-blue-600">📦 Data Barang Masuk</h1>
    <table class="w-full bg-white rounded-lg shadow">
        <thead>
            <tr class="bg-blue-100">
                <th class="p-3">Produk</th>
                <th class="p-3">Jumlah</th>
                <th class="p-3">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockins as $item)
                <tr class="border-b">
                    <td class="p-3">{{ $item->product->name ?? '-' }}</td>
                    <td class="p-3">{{ $item->quantity }}</td>
                    <td class="p-3">{{ $item->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

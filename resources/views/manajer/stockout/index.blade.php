@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4 text-red-600">🚚 Data Barang Keluar</h1>
    <table class="w-full bg-white rounded-lg shadow">
        <thead>
            <tr class="bg-red-100">
                <th class="p-3">Produk</th>
                <th class="p-3">Jumlah</th>
                <th class="p-3">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockouts as $item)
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

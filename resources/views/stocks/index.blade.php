@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Stok Barang</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->unit ?? '-' }}</td>
                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

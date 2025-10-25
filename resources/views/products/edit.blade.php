@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Produk</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2">Nama Produk</label>
        <input type="text" name="name" value="{{ $product->name }}" class="border w-full p-2 mb-3 rounded" required>

        <label class="block mb-2">SKU</label>
        <input type="text" name="sku" value="{{ $product->sku }}" class="border w-full p-2 mb-3 rounded" required>

        <label class="block mb-2">Kategori</label>
        <select name="category_id" class="border w-full p-2 mb-3 rounded">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" {{ $product->category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>

        <label class="block mb-2">Supplier</label>
        <select name="supplier_id" class="border w-full p-2 mb-3 rounded">
            <option value="">-- Pilih Supplier --</option>
            @foreach ($suppliers as $s)
                <option value="{{ $s->id }}" {{ $product->supplier_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
            @endforeach
        </select>

        <label class="block mb-2">Stok</label>
        <input type="number" name="quantity" value="{{ $product->quantity }}" class="border w-full p-2 mb-3 rounded" required>

        <label class="block mb-2">Harga</label>
        <input type="number" name="price" value="{{ $product->price }}" class="border w-full p-2 mb-3 rounded" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
        <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">Kembali</a>
    </form>
</div>
@endsection

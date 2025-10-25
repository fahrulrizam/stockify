@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto bg-white/80 backdrop-blur-xl rounded-2xl shadow-lg p-8 border border-gray-200 mt-10">
    <h2 class="text-3xl font-extrabold text-yellow-600 flex items-center mb-2">
        <i class="fas fa-edit mr-2"></i> Edit Produk
    </h2>
    <p class="text-gray-600 mb-6">Perbarui data produk berikut</p>

    <form action="{{ route('manajer.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-1">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Kategori</label>
                <select name="category_id" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @if($cat->id == $product->category_id) selected @endif>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Supplier</label>
                <select name="supplier_id" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}" @if($sup->id == $product->supplier_id) selected @endif>
                            {{ $sup->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Harga Beli</label>
                <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Harga Jual</label>
                <input type="number" name="price" value="{{ $product->price }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">{{ $product->description }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Gambar Produk</label>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar" class="w-32 h-32 object-cover rounded-lg mb-2 border">
            @endif
            <input type="file" name="image" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 bg-white">
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('manajer.products.index') }}" class="px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold flex items-center">
                <i class="fas fa-save mr-2"></i> Perbarui
            </button>
        </div>
    </form>
</div>
@endsection

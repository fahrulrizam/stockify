@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="max-w-4xl mx-auto bg-white/80 backdrop-blur-xl rounded-2xl shadow-lg p-8 border border-gray-200 mt-10">
    <h2 class="text-3xl font-extrabold text-blue-600 flex items-center mb-6">
        <i class="fas fa-box-open mr-2"></i> Detail Produk
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                 class="rounded-xl shadow-lg w-full object-cover h-64" alt="Produk">
        </div>

        <div class="space-y-3">
            <h3 class="text-xl font-bold text-gray-800">{{ $product->name }}</h3>
            <p class="text-gray-600"><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
            <p class="text-gray-600"><strong>Supplier:</strong> {{ $product->supplier->name ?? '-' }}</p>
            <p class="text-gray-600"><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-gray-600"><strong>Stok:</strong> {{ $product->stock }}</p>
            <p class="text-gray-600"><strong>Deskripsi:</strong> {{ $product->description ?? '-' }}</p>
        </div>
    </div>

    <div class="flex justify-between items-center mt-8">
        <a href="{{ route('manajer.products.index') }}" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium text-gray-700 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
        <a href="{{ route('manajer.products.edit', $product->id) }}" class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold flex items-center">
            <i class="fas fa-edit mr-2"></i> Edit Produk
        </a>
    </div>
</div>
@endsection

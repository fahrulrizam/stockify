@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-200 via-sky-100 to-fuchsia-200 py-10">
    <div class="max-w-4xl mx-auto bg-white/70 backdrop-blur-md shadow-2xl rounded-3xl p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Produk</h1>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <p><span class="font-semibold">Nama:</span> {{ $product->name }}</p>
                <p><span class="font-semibold">Kategori:</span> {{ $product->category->name ?? '-' }}</p>
                <p><span class="font-semibold">Harga:</span> Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p><span class="font-semibold">Stok:</span> 
                    <span class="{{ $product->stock <= 3 ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                        {{ $product->stock }}
                    </span>
                </p>
                <p><span class="font-semibold">Deskripsi:</span> {{ $product->description ?? '-' }}</p>
            </div>

            <div class="flex items-center justify-center">
                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}" 
                     alt="Gambar Produk" 
                     class="rounded-2xl w-60 h-60 object-cover shadow-lg">
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('products.index') }}" 
               class="bg-indigo-600 text-white px-5 py-2 rounded-xl hover:bg-indigo-700">Kembali</a>
        </div>
    </div>
</div>
@endsection

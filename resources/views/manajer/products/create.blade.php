@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white/80 backdrop-blur-xl rounded-2xl shadow-lg p-8 border border-gray-200 mt-10">
    <h2 class="text-3xl font-extrabold text-blue-700 flex items-center mb-2">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Produk Baru
    </h2>
    <p class="text-gray-600 mb-6">Masukkan data lengkap produk baru</p>

    <form action="{{ route('manajer.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Nama Produk --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nama Produk</label>
            <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama produk">
        </div>

        {{-- Kategori & Supplier --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Kategori</label>
                <select name="category_id" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Supplier</label>
                <select name="supplier_id" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Supplier</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Harga dan Stok --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Harga Beli</label>
                <input type="number" name="purchase_price" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Masukkan harga beli">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Harga Jual</label>
                <input type="number" name="price" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Masukkan harga jual">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Stok</label>
                <input type="number" name="stock" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Jumlah stok">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Masukkan deskripsi produk"></textarea>
        </div>

        {{-- Gambar --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Gambar Produk</label>
            <input type="file" name="image" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 bg-white">
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('manajer.products.index') }}" class="px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 shadow-sm text-gray-700 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection

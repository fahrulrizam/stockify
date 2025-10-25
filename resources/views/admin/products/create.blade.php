@extends('layouts.app')

@section('title', 'Tambah Produk Baru - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- HEADER --}}
        <div class="flex items-center gap-4 mb-8 pb-4 border-b border-gray-200">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-600 p-4 rounded-2xl shadow-lg flex items-center justify-center text-white text-3xl transition-transform hover:scale-105">
                <i class="fas fa-box text-2xl"></i>
            </div>

            <div>
                <h1 class="text-3xl font-extrabold text-indigo-600">
                    Tambah Produk Baru
                </h1>
                <p class="text-gray-500 text-sm">
                    Masukkan informasi lengkap produk yang akan ditambahkan
                </p>
            </div>
        </div>

        {{-- FORM TAMBAH PRODUK --}}
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Nama Produk --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Produk
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full border-gray-300 rounded-xl shadow-sm 
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                              px-4 py-2.5">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi Produk --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Produk
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border-gray-300 rounded-xl shadow-sm 
                                 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                 px-4 py-2.5">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Beli & Harga Jual --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="purchase_price" class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Beli
                    </label>
                    <input type="number" name="purchase_price" id="purchase_price" 
                           value="{{ old('purchase_price') }}" required
                           class="w-full border-gray-300 rounded-xl shadow-sm 
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                  px-4 py-2.5">
                    @error('purchase_price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Jual
                    </label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required
                           class="w-full border-gray-300 rounded-xl shadow-sm 
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                  px-4 py-2.5">
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Stok Awal --}}
            <div>
                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                    Stok Awal
                </label>
                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required
                       class="w-full border-gray-300 rounded-xl shadow-sm 
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                              px-4 py-2.5">
                @error('stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori & Supplier --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori
                    </label>
                    <select name="category_id" id="category_id" required
                            class="w-full border-gray-300 rounded-xl shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   px-4 py-2.5">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="supplier_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Supplier
                    </label>
                    <select name="supplier_id" id="supplier_id" required
                            class="w-full border-gray-300 rounded-xl shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   px-4 py-2.5">
                        <option value="">Pilih Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Upload Gambar --}}
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Produk
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-gray-700 border-gray-300 rounded-xl shadow-sm 
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                              px-4 py-2.5 bg-gray-50">
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 
                          rounded-xl shadow-md transition transform 
                          hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>

                <button type="submit" 
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 
                               text-white font-semibold px-6 py-3 rounded-xl 
                               shadow-md hover:shadow-lg hover:scale-105 
                               transition duration-200">
                     💾 <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

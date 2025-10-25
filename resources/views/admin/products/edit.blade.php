@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- HEADER --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-500 mb-4 shadow-lg text-white text-3xl">
                <i class="fas fa-box text-2xl"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-yellow-600">Edit Produk</h2>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Perbarui informasi produk dengan data terbaru</p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-gray-800" required>
            </div>

            {{-- Kategori --}}
            <div>
                <label for="category_id" class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select id="category_id" name="category_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-gray-800" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Supplier --}}
            <div>
                <label for="supplier_id" class="block text-gray-700 font-semibold mb-2">Supplier</label>
                <select id="supplier_id" name="supplier_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-gray-800" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}" {{ old('supplier_id', $product->supplier_id) == $s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Harga --}}
            <div>
                <label for="price" class="block text-gray-700 font-semibold mb-2">Harga Jual</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan harga produk"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-gray-800" required>
            </div>

            {{-- Stok --}}
            <div>
                <label for="stock" class="block text-gray-700 font-semibold mb-2">Stok</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan jumlah stok"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-gray-800" required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea id="description" name="description" 
                          placeholder="Masukkan deskripsi produk"
                          class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-gray-800"
                          rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>
                <button type="submit" 
                        class=" bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-semibold px-6 py-3 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition duration-200">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

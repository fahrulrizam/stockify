@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-10 px-4">
    <div class="max-w-xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 border border-gray-100">

        {{-- HEADER --}}
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 shadow-lg text-white text-3xl mb-4">
                 <i class="fas fa-exchange-alt text-2xl"></i>
            </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-yellow-600">Edit Transaksi</h2>
            </h2>
            <p class="text-gray-500 text-sm mt-1">Perbarui data transaksi sesuai kebutuhan</p>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-800 rounded shadow">
                ✅ {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-800 rounded shadow">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- PILIH PRODUK --}}
            <div>
                <label for="product_id" class="block text-gray-700 font-semibold mb-2">Produk</label>
                <select name="product_id" id="product_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition"
                        onchange="updateStock(this)">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ $product->id == $transaction->product_id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500" id="current-stock">
                    Stok saat ini: {{ $products->firstWhere('id', $transaction->product_id)->stock ?? 0 }}
                </p>
            </div>

            {{-- JUMLAH --}}
            <div>
                <label for="quantity" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                <input type="number" name="quantity" id="quantity" value="{{ $transaction->quantity }}" min="1"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition" required>
            </div>

            {{-- TIPE TRANSAKSI --}}
            <div>
                <label for="type" class="block text-gray-700 font-semibold mb-2">Tipe Transaksi</label>
                <select name="type" id="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition">
                    <option value="masuk" {{ $transaction->type == 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="keluar" {{ $transaction->type == 'keluar' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex justify-between gap-4 pt-4">
                <a href="{{ route('admin.transactions.index') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 
                               text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Update stok saat ganti produk
    function updateStock(select) {
        const stock = select.options[select.selectedIndex].dataset.stock || 0;
        document.getElementById('current-stock').textContent = 'Stok saat ini: ' + stock;
    }
</script>
@endsection

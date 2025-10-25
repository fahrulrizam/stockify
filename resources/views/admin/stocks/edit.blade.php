@extends('layouts.app')

@section('title', 'Edit Stok Produk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- HEADER --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 shadow-lg text-white text-3xl mb-4">
                 <i class="fas fa-boxes text-2xl"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-yellow-600">Edit Stok</h2>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Perbarui stok dan informasi terkait produk</p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('admin.stocks.update', $product->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Pilih Produk --}}
            <div>
                <label for="product_id" class="block mb-2 text-gray-700 font-medium">Produk</label>
                <select id="product_id" name="product_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-800"
                        onchange="updateStock(this)">
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" data-stock="{{ $p->stock }}" {{ $p->id == $product->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Stok saat ini: <span id="current-stock">{{ $product->stock }}</span></p>
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="quantity" class="block mb-2 text-gray-700 font-medium">Jumlah</label>
                <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-800" required>
            </div>

            {{-- Tipe --}}
            <div>
                <label for="type" class="block mb-2 text-gray-700 font-medium">Tipe Transaksi</label>
                <select id="type" name="type" class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-800">
                    <option value="out" {{ old('type', $product->type ?? '') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                    <option value="opname_decrease" {{ old('type', $product->type ?? '') == 'opname_decrease' ? 'selected' : '' }}>Stock Opname (-)</option>
                    <option value="opname_increase" {{ old('type', $product->type ?? '') == 'opname_increase' ? 'selected' : '' }}>Stock Opname (+)</option>
                </select>
            </div>

            {{-- Keterangan --}}
            <div>
                <label for="notes" class="block mb-2 text-gray-700 font-medium">Keterangan</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Opsional"
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-800">{{ old('notes', $product->notes ?? '') }}</textarea>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('admin.stocks.index') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                   ⬅️ Kembali
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-500 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateStock(select) {
    const stock = select.options[select.selectedIndex].getAttribute('data-stock');
    document.getElementById('current-stock').textContent = stock;
}
</script>
@endsection

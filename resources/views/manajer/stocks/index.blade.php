@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 p-8">
    <div class="max-w-6xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 border border-indigo-200">

        {{-- 🔹 Header --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-800 flex items-center gap-2">
                📦 Laporan Stok Barang
            </h2>
            <a href="{{ route('manajer.stocks.exportPdf', request()->query()) }}" 
               class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-5 py-2.5 rounded-lg font-semibold shadow hover:opacity-90 transition">
                ⬇️ Export PDF
            </a>
        </div>

        {{-- 🔍 Filter --}}
        <form action="{{ route('manajer.stocks.index') }}" method="GET" 
              class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1">Kategori</label>
                <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value=""> Semua Kategori </option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1">Stok Minimal</label>
                <input type="number" name="min_stock" value="{{ request('min_stock', 0) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
            </div>

            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1">Stok Maksimal</label>
                <input type="number" name="max_stock" value="{{ request('max_stock') }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
            </div>

            <div class="flex items-end">
                <button type="submit" 
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:opacity-90 transition w-full">
                    🔍 Filter
                </button>
            </div>
        </form>

        {{-- 📊 Tabel Data Stok --}}
        <div class="overflow-x-auto rounded-xl border border-gray-300 shadow-md">
            <table class="min-w-full border-collapse bg-white">
                <thead class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white">
                    <tr>
                        <th class="border px-4 py-3 text-left font-semibold">#</th>
                        <th class="border px-4 py-3 text-left font-semibold">Nama Produk</th>
                        <th class="border px-4 py-3 text-left font-semibold">Kategori</th>
                        <th class="border px-4 py-3 text-left font-semibold">Supplier</th>
                        <th class="border px-4 py-3 text-center font-semibold">Stok</th>
                        <th class="border px-4 py-3 text-left font-semibold">Harga (Rp)</th>
                        <th class="border px-4 py-3 text-left font-semibold">Total Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="border px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-3 text-gray-800 font-medium">{{ $p->name }}</td>
                        <td class="border px-4 py-3 text-gray-700">{{ $p->category->name ?? '-' }}</td>
                        <td class="border px-4 py-3 text-gray-700">{{ $p->supplier->name ?? '-' }}</td>
                        <td class="border px-4 py-3 text-center font-semibold text-indigo-700">{{ $p->stock }}</td>
                        <td class="border px-4 py-3 text-gray-700">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="border px-4 py-3 font-semibold text-gray-900">
                            Rp {{ number_format($p->stock * $p->price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="border px-4 py-5 text-center text-gray-500 italic bg-gray-50">
                            Tidak ada data stok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        

        {{-- 🔙 Tombol Kembali --}}
        <div class="text-center mt-8">
            <a href="{{ route('manajer.dashboard') }}" 
               class="inline-block bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 px-6 py-3 rounded-lg font-semibold shadow hover:opacity-80 transition">
               ⬅️ Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

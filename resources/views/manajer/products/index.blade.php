@extends('layouts.app')

@section('title', 'Manajemen Produk - Manajer')

@section('content')
<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between bg-white/80 backdrop-blur-xl shadow-lg rounded-2xl px-6 py-4 border border-gray-200">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-green-600 rounded-xl shadow text-white">
                <i class="fas fa-box text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800">Manajemen Produk</h1>
                <p class="text-gray-500 text-sm">Kelola data produk dan stok barang</p>
            </div>
        </div>

        <a href="{{ route('manajer.products.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold shadow-md flex items-center">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Produk
        </a>
    </div>

    {{-- ================= TABEL PRODUK ================= --}}
    <div class="bg-white/80 backdrop-blur-xl shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
        <table class="w-full table-auto">
            <thead class="bg-gradient-to-r from-blue-600 to-sky-500 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Nama Produk</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Supplier</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $index => $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $products->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->name }}</td>
                        <td class="px-4 py-3">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->supplier->name ?? '-' }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $item->stock }}</td>
                        <td class="px-4 py-3 flex justify-center gap-2">
                            <a href="{{ route('manajer.products.show', $item->id) }}"
                               class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-semibold shadow flex items-center">
                               <i class="fas fa-eye mr-1"></i> Detail
                            </a>

                            <a href="{{ route('manajer.products.edit', $item->id) }}"
                               class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-sm font-semibold shadow flex items-center">
                               <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <form action="{{ route('manajer.products.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold shadow flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada produk yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ================= PAGINATION ================= --}}
        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>

    {{-- ================= KEMBALI KE DASHBOARD ================= --}}
    <div class="pt-2">
        <a href="{{ route('manajer.dashboard') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium shadow-sm border border-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>

</div>
@endsection

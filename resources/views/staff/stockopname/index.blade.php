@extends('layouts.app')

@section('title', 'Stock Opname Gudang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50 via-blue-100 to-cyan-100 py-10">
    <div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl p-10 border border-white/30">

        {{-- ================= HEADER ================= --}}
        <div class="flex justify-between items-center mb-8 border-b pb-5">
            <div class="flex items-center gap-3">
                <div class="bg-sky-500 text-white p-3 rounded-2xl shadow-md">
                    <i class="bi bi-clipboard-check-fill text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-sky-800">Stock Opname Gudang</h1>
                    <p class="text-gray-500">Membantu staff dalam proses pemeriksaan stok fisik barang</p>
                </div>
            </div>
            <a href="{{ route('staff.dashboard') }}"
               class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-semibold shadow transition">
               <i class="bi bi-arrow-left-circle-fill text-lg"></i> Kembali
            </a>
        </div>

        {{-- ================= NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-5 shadow flex items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-5 shadow flex items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ================= FORM STOCK OPNAME ================= --}}
        <form action="{{ route('staff.stockopname.store') }}" method="POST">
            @csrf

            {{-- ================= TABEL STOCK OPNAME ================= --}}
            <div class="overflow-x-auto mt-4 rounded-2xl border border-gray-200 shadow-inner bg-white">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-sky-100/80 text-gray-800 uppercase text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Nama Produk</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">Supplier</th>
                            <th class="px-6 py-3 text-center">Stok Sistem</th>
                            <th class="px-6 py-3 text-center">Stok Fisik</th>
                            <th class="px-6 py-3 text-left">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($products as $p)
                            <tr class="hover:bg-sky-50 transition">
                                <td class="px-6 py-3 font-semibold text-gray-500 text-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $p->name }}</td>
                                <td class="px-6 py-3">{{ $p->category->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $p->supplier->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-center font-semibold {{ $p->stock <= 5 ? 'text-red-600' : 'text-sky-700' }}">
                                    {{ $p->stock }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <input type="number" name="stok_fisik[{{ $p->id }}]" min="0"
                                           class="w-24 border border-gray-300 rounded-lg text-center py-1 focus:ring-2 focus:ring-sky-400 focus:border-sky-400"
                                           placeholder="0" required>
                                </td>
                                <td class="px-6 py-3">
                                    <input type="text" name="catatan[{{ $p->id }}]"
                                           class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-sky-400 focus:border-sky-400"
                                           placeholder="Catatan (opsional)">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500 italic">
                                    <i class="bi bi-inbox"></i> Tidak ada data stok opname.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            @if($products->isNotEmpty())
                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                        <i class="bi bi-save-fill me-1"></i> Simpan Hasil Opname
                    </button>
                </div>
            @endif
        </form>

    </div>
</div>
@endsection

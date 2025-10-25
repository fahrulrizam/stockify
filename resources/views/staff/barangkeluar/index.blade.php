@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-100 via-indigo-50 to-blue-100 py-10">
    <div class="max-w-6xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-indigo-700 flex items-center gap-2">
                📦 Data Barang Keluar
            </h1>
            <a href="{{ route('staff.dashboard') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold shadow">
               ← Kembali
            </a>
        </div>

        {{-- Tabel Barang Keluar --}}
        <div class="overflow-x-auto mt-6 rounded-xl border border-gray-300">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-100 text-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Tanggal</th>
                        <th class="px-6 py-3 text-left font-medium">Nama Produk</th>
                        <th class="px-6 py-3 text-left font-medium">Jumlah Keluar</th>
                        <th class="px-6 py-3 text-left font-medium">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-indigo-50">
                            <td class="px-6 py-4">{{ $t->tanggal }}</td>
                            <td class="px-6 py-4">{{ $t->product->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $t->jumlah }}</td>
                            <td class="px-6 py-4">{{ $t->note ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                Tidak ada data barang keluar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

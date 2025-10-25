@extends('layouts.app')

@section('title', 'Laporan Transaksi & Produk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-100 py-10 px-4">
    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">📊 Laporan Transaksi & Produk</h1>
                <p class="text-gray-600 mt-1">Pantau aktivitas transaksi dan stok produk terbaru</p>
            </div>
            <a href="{{ route('reports.exportPdf') }}" 
               class="mt-4 md:mt-0 inline-flex items-center bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:from-blue-600 hover:to-indigo-600 transform hover:scale-105 transition">
                <i class="fa fa-file-pdf mr-2"></i> Ekspor ke PDF
            </a>
        </div>

        {{-- ================= TABEL TRANSAKSI ================= --}}
        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-md">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <tr>
                        <th class="px-5 py-3 text-center font-semibold">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3 text-center font-semibold">Jenis</th>
                        <th class="px-5 py-3 text-center font-semibold">Jumlah</th>
                        <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-5 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $t->product->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-center capitalize">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $t->type === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($t->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">{{ $t->quantity }}</td>
                            <td class="px-5 py-3 text-center">{{ $t->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-6 italic">
                                Belum ada transaksi tercatat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-8 flex justify-center">
                {{ $transactions->links('pagination::tailwind') }}
            </div>
        @endif

        {{-- ================= TOMBOL KEMBALI ================= --}}
        <div class="text-center mt-10">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
               ⬅️ Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection

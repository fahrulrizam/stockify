@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-100 py-10 px-4">
    <div class="max-w-6xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-indigo-700">💰 Daftar Transaksi</h1>
                <p class="text-gray-600 mt-1">Kelola dan pantau semua transaksi barang masuk & keluar</p>
            </div>
            <a href="{{ route('admin.transactions.create') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:from-emerald-500 hover:to-green-500 transition transform hover:scale-105">
                ➕ Tambah Transaksi
            </a>
        </div>

        {{-- ================= TABEL TRANSAKSI ================= --}}
        <div class="overflow-x-auto bg-white/80 rounded-2xl border border-gray-200 shadow-md">
            <table class="min-w-full border-collapse text-sm md:text-base">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-center font-semibold">No</th>
                        <th class="px-6 py-3 text-left font-semibold">Produk</th>
                        <th class="px-6 py-3 text-center font-semibold">Jenis</th>
                        <th class="px-6 py-3 text-center font-semibold">Jumlah</th>
                        <th class="px-6 py-3 text-center font-semibold">Tanggal</th>
                        <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-indigo-50 transition duration-150">
                            <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 font-medium">{{ $t->product->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-center capitalize">
                                @if($t->type === 'masuk')
                                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700 font-medium">Masuk</span>
                                @elseif($t->type === 'keluar')
                                    <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700 font-medium">Keluar</span>
                                @else
                                    <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700 font-medium">{{ ucfirst($t->type) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">{{ $t->quantity }}</td>
                            <td class="px-6 py-3 text-center">{{ $t->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.transactions.edit', $t->id) }}" 
                                   class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1.5 rounded-lg shadow-sm transition transform hover:scale-105 active:scale-95">
                                   ✏️ Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-6 italic">
                                Tidak ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6 flex justify-center">
                {{ $transactions->links('pagination::tailwind') }}
            </div>
        @endif

        {{-- ================= TOMBOL KEMBALI ================= --}}
        <div class="text-center mt-8">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center justify-center bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

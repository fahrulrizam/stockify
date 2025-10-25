@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-100 py-10 px-4">
    <div class="max-w-7xl mx-auto bg-white/95 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-purple-600 to-indigo-600 p-5 rounded-3xl shadow-lg text-white">
                    <i class="fas fa-exchange-alt text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-purple-700">
                        Daftar Transaksi
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Kelola semua transaksi masuk dan keluar produk
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.transactions.create') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                <i class="fas fa-plus-circle"></i> Tambah Transaksi
            </a>
        </div>

        {{-- ================= TABEL TRANSAKSI ================= --}}
        <div class="overflow-x-auto rounded-2xl shadow-md border border-gray-200">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <tr>
                        <th class="px-5 py-3 text-center font-semibold">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3 text-center font-semibold">Jenis</th>
                        <th class="px-5 py-3 text-center font-semibold">Jumlah</th>
                        <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-5 py-3 text-center text-gray-700 font-medium">
                                {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $t->product->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-center capitalize font-semibold {{ $t->type === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($t->type) }}
                            </td>
                            <td class="px-5 py-3 text-center text-gray-700">
                                {{ $t->quantity }}
                            </td>
                            <td class="px-5 py-3 text-center text-gray-700">
                                {{ $t->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.transactions.edit', $t->id) }}" 
                                       class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl shadow transition transform hover:scale-105 active:scale-95">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl shadow transition transform hover:scale-105 active:scale-95">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-6 italic">
                                <i class="fas fa-info-circle"></i> Tidak ada data transaksi
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
            <a href="{{ route('dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
               ⬅️ Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Transaksi Manajer')

@section('content')
<div class="space-y-8">
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Barang Masuk --}}
    <div class="bg-white/40 backdrop-blur-2xl shadow-2xl rounded-3xl p-6 border border-white/30">
        <h2 class="text-xl font-bold mb-4 text-gray-800"><i class="fas fa-arrow-down mr-2"></i> Barang Masuk</h2>
        <form action="{{ route('manajer.transactions.incoming') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium">Produk</label>
                <select name="product_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Jumlah</label>
                <input type="number" name="quantity" class="w-full border rounded px-3 py-2" min="1" required>
            </div>
            <button type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-green-600 transition">
                Catat Barang Masuk
            </button>
        </form>
    </div>

    {{-- Form Barang Keluar --}}
    <div class="bg-white/40 backdrop-blur-2xl shadow-2xl rounded-3xl p-6 border border-white/30">
        <h2 class="text-xl font-bold mb-4 text-gray-800"><i class="fas fa-arrow-up mr-2"></i> Barang Keluar</h2>
        <form action="{{ route('manajer.transactions.outgoing') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium">Produk</label>
                <select name="product_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Jumlah</label>
                <input type="number" name="quantity" class="w-full border rounded px-3 py-2" min="1" required>
            </div>
            <button type="submit"
                class="bg-red-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-600 transition">
                Catat Barang Keluar
            </button>
        </form>
    </div>

    {{-- Daftar Transaksi --}}
    <div class="bg-white/40 backdrop-blur-2xl shadow-2xl rounded-3xl p-6 border border-white/30">
        <h2 class="text-xl font-bold mb-4 text-gray-800"><i class="fas fa-list mr-2"></i> Daftar Transaksi Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-indigo-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Produk</th>
                        <th class="px-4 py-2 border">Tipe</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">User</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                        <tr class="text-gray-700">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $t->product->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst($t->type) }}</td>
                            <td class="px-4 py-2 border">{{ $t->quantity }}</td>
                            <td class="px-4 py-2 border">{{ $t->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $t->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection

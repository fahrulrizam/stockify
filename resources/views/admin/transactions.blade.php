@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-5 p-4 bg-green-100 text-green-800 rounded-2xl shadow-inner border border-green-300">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mb-5 p-4 bg-red-100 text-red-800 rounded-2xl shadow-inner border border-red-300">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Barang Masuk --}}
    <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl shadow-lg border border-white/40 mb-8">
        <h2 class="text-xl font-semibold text-green-700 mb-4">Barang Masuk</h2>

        <form action="{{ route('admin.transactions.storeIncoming') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <select name="product_id" class="rounded-2xl border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    <option value="">Pilih Produk</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>

                <input type="number" name="quantity" min="1" placeholder="Jumlah Barang"
                       class="rounded-2xl border-gray-300 focus:ring-green-500 focus:border-green-500" required>

                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-2xl px-4 py-2 shadow-md transition-all">
                    + Tambah Masuk
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

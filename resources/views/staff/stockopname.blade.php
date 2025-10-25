@extends('layouts.app')

@section('title', 'Stock Opname Gudang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50 via-blue-100 to-cyan-100 py-10">
    <div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl p-10 border border-white/30">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8 border-b pb-5">
            <h1 class="text-3xl font-extrabold text-sky-800">Stock Opname Gudang</h1>
            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary rounded-pill fw-semibold px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- ================= FORM STOCK OPNAME ================= --}}
        @if ($products->isEmpty())
            <div class="text-center text-muted my-5">
                Belum ada produk untuk dilakukan stock opname.
            </div>
        @else
            <form action="{{ route('staff.stockopname.store') }}" method="POST">
                @csrf
                <div class="table-responsive border rounded-4 shadow-sm overflow-hidden">
                    <table class="table align-middle mb-0">
                        <thead class="text-white" style="background: linear-gradient(90deg, #1e3a8a, #3b82f6);">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th class="text-center">Stok Sistem</th>
                                <th class="text-center">Stok Fisik</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->category->name ?? '-' }}</td>
                                    <td>{{ $p->supplier->name ?? '-' }}</td>
                                    <td class="text-center">{{ $p->stock }}</td>
                                    <td class="text-center">
                                        <input type="number" name="stok_fisik[{{ $p->id }}]" min="0" required class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="catatan[{{ $p->id }}]" placeholder="Catatan (opsional)" class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Hasil Opname
                    </button>
                </div>
            </form>
        @endif
        {{-- ================= END FORM ================= --}}
        
    </div>
</div>
@endsection

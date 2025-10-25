@extends('layouts.app')

@section('title', 'Barang Masuk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-blue-100 py-10">
    <div class="max-w-7xl mx-auto bg-white/70 backdrop-blur-xl shadow-2xl rounded-3xl p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="d-flex justify-content-between align-items-center bg-white shadow-sm px-4 py-3 rounded-3 mb-4 border border-light">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white d-flex align-items-center justify-content-center rounded-3 me-3"
                    style="width: 45px; height: 45px;">
                    <i class="bi bi-box-arrow-in-down fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Barang Masuk</h4>
                    <small class="text-muted">Pencatatan dan riwayat barang yang masuk ke gudang</small>
                </div>
            </div>
            <a href="{{ route('manajer.dashboard') }}" class="btn btn-outline-primary btn-sm fw-semibold">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- ================= NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= FORM INPUT ================= --}}
        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-header bg-success text-white fw-semibold rounded-top-4">
                <i class="bi bi-pencil-square me-2"></i> Catat Barang Masuk
            </div>
            <div class="card-body">
                <form action="{{ route('manajer.barangmasuk.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        {{-- Produk --}}
                        <div class="col-md-4">
                            <label for="product_id" class="form-label fw-semibold">Produk</label>
                            <select name="product_id" id="product_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} — (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah --}}
                        <div class="col-md-3">
                            <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control shadow-sm" min="1" required>
                        </div>

                        {{-- Keterangan --}}
                        <div class="col-md-4">
                            <label for="description" class="form-label fw-semibold">Keterangan (opsional)</label>
                            <input type="text" name="description" id="description" class="form-control shadow-sm" placeholder="">
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="col-md-1 d-grid">
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= RIWAYAT BARANG MASUK ================= --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-success text-white fw-semibold rounded-top-4 d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-clock-history me-2"></i> Riwayat Barang Masuk
                </div>
                <a href="{{ route('manajer.barangmasuk.export', ['format' => 'pdf']) }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-file-earmark-pdf text-success"></i> Export PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Masuk</th>
                            <th>Tanggal Transaksi</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($transactions as $item)
                            <tr class="transition hover:bg-green-50">
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-gray-800 text-start">{{ $item->product->name ?? '-' }}</td>
                                <td class="text-success fw-bold">{{ $item->quantity }}</td>
                                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td class="text-muted">{{ $item->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data barang masuk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

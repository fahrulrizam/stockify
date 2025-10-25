@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="container-fluid py-4">

    {{-- =================================================== --}}
    {{-- HEADER --}}
    {{-- =================================================== --}}
    <div class="d-flex justify-content-between align-items-center bg-white shadow-sm px-4 py-3 rounded-3 mb-4 border border-light">
        <div class="d-flex align-items-center">
            <div class="bg-danger text-white d-flex align-items-center justify-content-center rounded-3 me-3"
                 style="width: 45px; height: 45px;">
                <i class="bi bi-box-arrow-up fs-5"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">Barang Keluar</h4>
                <small class="text-muted">Catatan & riwayat pengeluaran barang dari gudang</small>
            </div>
        </div>
        <a href="{{ route('manajer.dashboard') }}" class="btn btn-outline-primary btn-sm fw-semibold">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- =================================================== --}}
    {{-- NOTIFIKASI --}}
    {{-- =================================================== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- =================================================== --}}
    {{-- FORM INPUT BARANG KELUAR --}}
    {{-- =================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-danger text-white fw-semibold rounded-top-4">
            <i class="bi bi-pencil-square me-2"></i> Catat Barang Keluar
        </div>
        <div class="card-body">
            <form action="{{ route('manajer.barangkeluar.store') }}" method="POST">
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
                        <button type="submit" class="btn btn-danger shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- =================================================== --}}
    {{-- TABEL BARANG KELUAR --}}
    {{-- =================================================== --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-danger text-white fw-semibold rounded-top-4 d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-box-arrow-up me-2"></i> Riwayat Barang Keluar
            </div>
            <a href="{{ route('manajer.barangkeluar.export', ['format' => 'pdf']) }}" class="btn btn-light btn-sm fw-semibold">
                <i class="bi bi-file-earmark-pdf text-danger"></i> Export PDF
            </a>
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <p class="text-center text-muted mb-0 py-3">
                    <i class="bi bi-inbox"></i> Belum ada data barang keluar.
                </p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle shadow-sm">
                        <thead class="table-danger text-center">
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start fw-semibold">{{ $item->product->name ?? '-' }}</td>
                                    <td class="fw-bold text-danger">{{ $item->quantity }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                                    <td class="text-muted">{{ $item->description ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

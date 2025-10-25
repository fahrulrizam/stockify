@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- ================= HEADER ================= -->
    <header class="d-flex justify-content-between align-items-center bg-white shadow-sm px-4 py-3 rounded-3 mb-4 border border-light">
        <div class="d-flex align-items-center">
            <div class="bg-warning text-white d-flex align-items-center justify-content-center rounded-3 me-3"
                 style="width: 40px; height: 40px;">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            </div>
            <h4 class="fw-bold text-dark mb-0">Stok Menipis</h4>
        </div>
        <div class="text-end">
            <a href="{{ route('manajer.dashboard') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
            </a>
        </div>
    </header>

    <!-- ================= TABEL STOK MENIPIS ================= -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-warning fw-semibold text-dark rounded-top-4">
            ⚠️ Produk dengan Stok Menipis (≤ 5)
        </div>
        <div class="card-body">
            @if($stokMenipis->isEmpty())
                <div class="text-center py-4">
                    <p class="text-muted mb-0">Semua stok aman 👍</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokMenipis as $i => $p)
                                <tr class="text-center">
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-start">{{ $p->name }}</td>
                                    <td>{{ $p->category->name ?? '-' }}</td>
                                    <td>{{ $p->supplier->name ?? '-' }}</td>
                                    <td class="fw-bold text-danger">{{ $p->stock }}</td>
                                    <td><span class="badge bg-danger">Menipis</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

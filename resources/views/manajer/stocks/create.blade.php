@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Produk Baru</h3>

    <form action="{{ route('manajer.stocks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Stok</label>
            <input type="number" name="stock" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="price" class="form-control" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('manajer.stocks.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

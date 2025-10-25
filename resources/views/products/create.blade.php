@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
  <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      🛒 Tambah Produk
    </h1>

    {{-- FORM PRODUK --}}
    <form action="{{ route('products.store') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label class="block text-gray-700 font-semibold mb-1">Nama Produk</label>
        <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold mb-1">SKU</label>
        <input type="text" name="sku" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
      </div>

      <div class="grid grid-cols-4 gap-2 items-end">
        <div class="col-span-3">
          <label class="block text-gray-700 font-semibold mb-1">Kategori</label>
          <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="button" id="toggleCategoryForm" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg">
          + Tambah
        </button>
      </div>

      <div class="grid grid-cols-4 gap-2 items-end">
        <div class="col-span-3">
          <label class="block text-gray-700 font-semibold mb-1">Supplier</label>
          <select name="supplier_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            <option value="">-- Pilih Supplier --</option>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="button" id="toggleSupplierForm" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg">
          + Tambah
        </button>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold mb-1">Stok</label>
        <input type="number" name="stock" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold mb-1">Harga</label>
        <input type="number" name="price" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
      </div>

      <div class="flex justify-between items-center pt-4">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali</a>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg">
          Simpan
        </button>
      </div>
    </form>

    {{-- FORM TAMBAH KATEGORI --}}
    <div id="categoryForm" class="hidden mt-10 border-t pt-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-3">Tambah Kategori Baru</h2>
      <form action="{{ route('categories.store') }}" method="POST" class="flex gap-3">
        @csrf
        <input type="text" name="name" placeholder="Nama Kategori" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        <button type="button" id="cancelCategory" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
      </form>
    </div>

    {{-- FORM TAMBAH SUPPLIER --}}
    <div id="supplierForm" class="hidden mt-10 border-t pt-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-3">Tambah Supplier Baru</h2>
      <form action="{{ route('suppliers.store') }}" method="POST" class="flex gap-3">
        @csrf
        <input type="text" name="name" placeholder="Nama Supplier" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        <button type="button" id="cancelSupplier" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
      </form>
    </div>
  </div>
</div>

<script>
  const catForm = document.getElementById('categoryForm');
  const supForm = document.getElementById('supplierForm');

  document.getElementById('toggleCategoryForm').onclick = () => catForm.classList.toggle('hidden');
  document.getElementById('cancelCategory').onclick = () => catForm.classList.add('hidden');

  document.getElementById('toggleSupplierForm').onclick = () => supForm.classList.toggle('hidden');
  document.getElementById('cancelSupplier').onclick = () => supForm.classList.add('hidden');
</script>
@endsection

@extends('layouts.app')
@section('content')
<h3>Barang Masuk</h3>
<form action="{{ route('manajer.storeIncoming') }}" method="POST">
    @csrf
    <select name="product_id">
        @foreach($products as $p)
        <option value="{{ $p->id }}">{{ $p->name }}</option>
        @endforeach
    </select>
    <input type="number" name="quantity" min="1" placeholder="Jumlah">
    <button type="submit">Tambah</button>
</form>

<table>
<tr><th>Produk</th><th>Jumlah</th><th>Status</th></tr>
@foreach($transactions as $t)
<tr>
<td>{{ $t->product->name }}</td>
<td>{{ $t->quantity }}</td>
<td>{{ $t->status }}</td>
</tr>
@endforeach
</table>
{{ $transactions->links() }}
@endsection

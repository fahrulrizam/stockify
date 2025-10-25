<h2 style="text-align:center;">Laporan Transaksi</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead style="background:#e0e7ff;">
        <tr>
            <th>#</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->product->name ?? '-' }}</td>
            <td>{{ $t->quantity }}</td>
            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

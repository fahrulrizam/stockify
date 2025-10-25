<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar</title>
    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            background-color: #fff;
            color: #333;
            font-size: 12px;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            margin: 0;
            color: #d6336c;
        }
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f8d7da;
            color: #721c24;
            text-transform: uppercase;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #fdf2f4;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #555;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature p {
            margin: 2px 0;
        }
    </style>
</head>
<body>

    {{-- =================================================== --}}
    {{-- HEADER LAPORAN --}}
    {{-- =================================================== --}}
    <div class="header">
        <h2>📤 Laporan Barang Keluar</h2>
        <p>Gudang Utama - Sistem Manajemen Stok</p>
        <p>Tanggal Cetak: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    {{-- =================================================== --}}
    {{-- TABEL DATA --}}
    {{-- =================================================== --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kuantitas</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $item->product->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="color:#888;">Tidak ada data barang keluar</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- =================================================== --}}
    {{-- FOOTER --}}
    {{-- =================================================== --}}
    <div class="footer">
        <p>Dicetak otomatis melalui sistem Stockify © {{ date('Y') }}</p>
    </div>

    <div class="signature">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>(________________________)</strong></p>
        <p><em>Manajer Gudang</em></p>
    </div>

</body>
</html>

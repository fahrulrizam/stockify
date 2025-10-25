<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BarangMasukExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function($item){
            return [
                'Produk' => $item->product->name ?? '-',
                'Jumlah Masuk' => $item->quantity,
                'Tanggal' => $item->created_at->format('d-m-Y'),
                'Keterangan' => $item->description ?? '-',
            ];
        });
    }
}

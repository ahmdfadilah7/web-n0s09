<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            <th colspan="7" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Pembelian {{ $setting->nama_website }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Supplier</th>
            <th>Produk</th>
            <th>Harga Produk</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pembelian as $no => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->nama_supplier }}</td>
                <td>
                    {{ $row->nama }}
                </td>
                <td>
                    {{ \AllHelper::rupiah($row->harga_modal) }}
                </td>               
                <td>
                    {{ $row->jumlah }}
                </td>
                <td>
                    {{ \AllHelper::rupiah($row->total) }}
                </td>
                <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
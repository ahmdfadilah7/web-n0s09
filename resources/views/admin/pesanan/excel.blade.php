<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            <th colspan="11" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Pesanan {{ $setting->nama_website }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Kode Invoice</th>
            <th>Pemesan</th>
            <th>Produk</th>
            <th>Harga Produk</th>
            <th>Jumlah</th>
            <th>SubTotal</th>
            <th>Pengiriman</th>
            <th>Total Invoice</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoice as $no => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->kode_invoice }}</td>
                <td>
                    @php
                        $user = \App\Models\User::where('id', $row->user_id);
                    @endphp    
                    @if($user->count() > 0)
                        {{ $user->first()->name }}
                    @else
                        Pembeli Toko
                    @endif
                </td>
                <td>
                    @php
                        $transaksi = \App\Models\Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                            ->join('produks', 'transaksis.produk_id', 'produks.id')
                            ->where('invoice_id', $row->id)
                            ->get();
                        $produk = '';
                        $harga = '';
                        $jumlah = '';
                        $subtotal = '';
                        foreach ($transaksi as $value) {
                            $produk .= $value->nama.'<br>';
                            $harga .= \AllHelper::rupiah($value->harga_jual).'<br>';
                            $jumlah .= $value->jumlah.'<br>';
                            $subtotal .= AllHelper::rupiah($value->total).'<br>';
                        }
                    @endphp
                    {!! $produk !!}
                </td>
                <td>
                    {!! $harga !!}
                </td>
                <td>
                    {!! $jumlah !!}
                </td>
                <td>
                    {!! $subtotal !!}
                </td>
                <td>
                    @php
                        $ongkir = \App\Models\JasaKirim::where('id', $row->jasakirim_id);
                        if ($ongkir->count() > 0) {
                            $pengiriman = $ongkir->first()->nama.' - '.AllHelper::rupiah($ongkir->first()->ongkir);
                        } else {
                            $pengiriman = 'Beli langsung di toko';
                        }
                    @endphp  
                    {{ $pengiriman }}  
                </td>
                <td>{{ AllHelper::rupiah($row->total_invoice) }}</td>
                <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                <td>
                    @if($row->status == 1 && $row->konfirmasi == 0)
                        Pesanan Belum Dibayar
                    @elseif($row->status == 1 && $row->konfirmasi == 1)
                        Pesanan Menunggu Konfirmasi
                    @elseif($row->status == 2)
                        Pesanan Sedang Diproses
                    @elseif($row->status == 3)
                        Pesanan Sedang Dikirim
                    @elseif($row->status == 4)
                        Pesanan Selesai
                    @elseif($row->status == 5)
                        Pesanan Dibatalkan
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
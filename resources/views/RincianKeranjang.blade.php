<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancangan Perkasa | Rincian</title>
    <link rel="icon" href="/Images/logo simbol.png">
</head>
<div>
    <p>Rincian Pesanan</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody id="daftar-barang">
            <?php $total_harga = 0; ?>
            @foreach ($daftar_barang as $item)
            <?php $total_harga += $item->jumlah * $item->barang->harga; ?>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ "Rp. " . number_format($item->barang->harga, 0, ',', '.') }}</td>
                <td>{{ "Rp. " . number_format($item->jumlah * $item->barang->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Total Harga : {{ "Rp. " . number_format($total_harga, 0, ',', '.') }}</p>
    <p>harga diatas belum termasuk biaya pengiriman</p>
    <p>anda akan menerima nota pembayaran setelah pesanan disetujui oleh toko</p>
</div>
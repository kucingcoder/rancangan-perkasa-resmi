<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancangan Perkasa | Nota Pembeli</title>
    <link rel="icon" href="/Images/logo simbol.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px;
        }

        th {
            background: #ddd;
            font-weight: bold;
        }

        * {
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        body {
            padding: 24px;
        }

        th,
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <p style="text-align: right;">{{ $pesanan->kode_invoice }}</p>
    <br>
    <div style="width: 100%; text-align: center; white-space: nowrap;">
        <div style="display: inline-block; vertical-align: middle; width: 60px;">
            <img src="{{ base_path('/public/Images/logo simbol.png') }}" alt="Rancangan Perkasa" style="width: 60px;">
        </div>
        <div style="display: inline-block; vertical-align: middle; text-align: left; padding-left: 10px;">
            <h1 style="font-size: 14px; font-weight: bold; margin: 0; text-align: center;">CV. RANCANGAN PERKASA</h1>
            <h2 style="font-size: 12px; font-weight: bold; margin: 0; text-align: center;">Distributor Jasa & Bahan Interior Eksterior</h2>
            <p style="font-size: 10px; margin: 0; text-align: center;">Jl. Sultan Agung No. 132 RT.006/RW. 002 Kelurahan Kejambon</p>
            <p style="font-size: 10px; margin: 0; text-align: center;">Kecamatan Tegal Timur, Kota Tegal, Jawa Tengah, Indonesia</p>
        </div>
    </div>

    <table style="width: 100%; margin-top: 10px; border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 50%; text-align: left; vertical-align: top; padding: 0; border: none;">
                <p style="margin: 0;">{{ $pembeli->nama }}</p>
                <p style="margin: 0;">{{ $pembeli->no_wa }}</p>
                <p style="margin: 0;">{{ $pembeli->alamat }}</p>
            </td>
            <td style="border: none;"></td>
            <td style="width: 50%; text-align: right; vertical-align: top; padding: 0; border: none;">
                <p style="margin: 0;">{{ $sales->nama }}</p>
                <p style="margin: 0;">{{ $sales->no_wa }}</p>
            </td>
        </tr>
    </table>


    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            <?php $total_harga = 0; ?>

            @foreach ($daftar_produk as $item)
            <?php $index++; ?>
            <?php $total_harga += $item->jumlah * $item->produk->harga; ?>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->nama }}</td>
                <td>{{ $item->jumlah }} {{ $item->produk->satuan }}</td>
                <td>{{ "Rp. " . number_format($item->produk->harga, 0, ',', '.') }}</td>
                <td>{{ "Rp. " . number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <?php $total_harga += $pengiriman->jumlah_pengiriman * $pengiriman->biaya_kirim->nominal; ?>
            <tr>
                <td>{{ $index }}</td>
                <td>Pengiriman Wilayah {{ $pengiriman->biaya_kirim->wilayah }}</td>
                <td>{{ $pengiriman->jumlah_pengiriman }} Pengiriman</td>
                <td>{{ "Rp. " . number_format($pengiriman->biaya_kirim->nominal, 0, ',', '.') }}</td>
                <td>{{ "Rp. " . number_format($pengiriman->jumlah_pengiriman * $pengiriman->biaya_kirim->nominal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <p style="font-size: 12px;"><strong>Total : {{ "Rp. " . number_format($total_harga, 0, ',', '.') }}</strong></p>

    <br>

    <p style="font-size: 12px;"><strong>Status : <strong style="color: green;">LUNAS</strong></p>

    <br>

    <p style="text-align: justify;">Terima kasih telah berbeli di Toko Rancangan Perkasa. Semoga produk yang Anda beli dapat memenuhi kebutuhan anda dengan baik.</p>
</body>

</html>
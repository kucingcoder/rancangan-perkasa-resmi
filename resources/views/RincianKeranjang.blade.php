<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancangan Perkasa | Rincian</title>
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
    <div style="width: 100%; text-align: center; white-space: nowrap;">
        <div style="display: inline-block; vertical-align: middle; width: 60px;">
            <img src="{{ base_path('/public/Images/logo simbol.png') }}" alt="Rancangan Perkasa" style="width: 60px;">
        </div>
        <div style="display: inline-block; vertical-align: middle; text-align: left; padding-left: 10px;">
            <h1 style="font-size: 14px; font-weight: bold; margin: 0;">RANCANGAN PERKASA</h1>
            <h2 style="font-size: 12px; font-weight: bold; margin: 0;">Vendor Toko Bangunan Terpercaya</h2>
            <p style="font-size: 10px; margin: 0;">Jl. Sultan Agung No. 132RT.006/RW. 002 Desa Kejambon</p>
            <p style="font-size: 10px; margin: 0;">Kecamatan Tegal Timur, Kota Tegal, Jawa Tengah, Indonesia</p>
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
            <?php $total_harga = 0; ?>
            @foreach ($daftar_produk as $item)
            <?php $total_harga += $item->jumlah * $item->produk->harga; ?>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->nama }}</td>
                <td>{{ $item->jumlah }} {{ $item->produk->satuan }}</td>
                <td>{{ "Rp. " . number_format($item->produk->harga, 0, ',', '.') }}</td>
                <td>{{ "Rp. " . number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <p style="font-size: 12px;"><strong>Total : {{ "Rp. " . number_format($total_harga, 0, ',', '.') }}</strong></p>

    <br>

    <p style="font-size: 12px;"><strong>Status : <strong style="color: red;">BELUM LUNAS</strong></p>

    <br>

    <p style="text-align: justify;">Harga di atas belum termasuk biaya pengiriman. Anda akan menerima nota pembayaran termasuk biaya pengiriman setelah pesanan diterima oleh toko Rancangan Perkasa.</p>
</body>

</html>
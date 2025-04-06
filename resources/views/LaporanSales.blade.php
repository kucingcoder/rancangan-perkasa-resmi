<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancangan Perkasa | Laporan Sales</title>
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
            font-size: 16px;
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
        <div style="display: inline-block; vertical-align: middle; width: 120px;">
            <img src="{{ base_path('/public/Images/logo.png') }}" alt="Rancangan Perkasa" style="width: 120px;">
        </div>

        <div style="display: inline-block; vertical-align: middle; text-align: left; padding-left: 10px;">
            <h1 style="font-size: 24px; font-weight: bold; margin: 0; text-align: center;">CV. RANCANGAN PERKASA</h1>
            <h2 style="font-size: 20px; font-weight: bold; margin: 0; text-align: center;">Distributor Bahan & Jasa Interior Eksterior</h2>
            <p style="font-size: 16px; margin: 0; text-align: center;">Jl. Sultan Agung No. 132 RT 006 RW 002 Kelurahan Kejambon</p>
            <p style="font-size: 16px; margin: 0; text-align: center;">Kecamatan Tegal Timur, Kota Tegal, Jawa Tengah, Indonesia</p>
        </div>

        <hr style="border: none; height: 0.5px; background-color: black; margin-bottom: 1px;">
        <hr style="border: none; height: 2px; background-color: black;">
    </div>

    <br>
    <br>

    <h1 style="font-size: 20px;">PESANAN</h1>

    <br>

    <table style="border-collapse: collapse; width: auto;">
        <tr>
            <td style="border: none; text-align: left;">Kode Invoice</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->kode_invoice }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Judul</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->judul }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Dibuat</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->created_at->format('d/m/Y') }}</td>
        </tr>
    </table>

    <br>
    <br>

    <h1 style="font-size: 20px;">PEMBELI</h1>

    <br>

    <table style="border-collapse: collapse; width: auto;">
        <tr>
            <td style="border: none; text-align: left;">Nama</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->pembeli->nama }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left; white-space: nowrap; min-width: 100px;">No Whatsapp</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->pembeli->no_wa }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Email</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->pembeli->email }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Alamat</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->pembeli->alamat }}</td>
        </tr>
    </table>

    <br>
    <br>

    <h1 style="font-size: 20px;">SALES</h1>

    <br>

    <table style="border-collapse: collapse; width: auto;">
        <tr>
            <td style="border: none; text-align: left;">Nama</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->akun->nama }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left; white-space: nowrap; min-width: 100px;">No Whatsapp</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left; white-space: nowrap; min-width: 100px;">{{ $pesanan->keranjang->akun->no_wa }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Email</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->akun->email }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Alamat</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pesanan->keranjang->akun->alamat }}</td>
        </tr>
    </table>

    <br>
    <br>

    <h1 style="font-size: 20px;">PRODUK</h1>

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
        </tbody>
    </table>

    <br>

    <table style="border-collapse: collapse; width: auto;">
        <tr>
            <td style="border: none; text-align: left;">Total Harga Produk</td>
            <td style="border: none; text-align: left;">: {{ "Rp. " . number_format($total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Total Bonus Sales</td>
            <td style="border: none; text-align: left;">: {{ "Rp. " . number_format($pesanan->biaya_sales, 0, ',', '.') }}</td>
        </tr>
    </table>

    <br>
    <br>

    <h1 style="font-size: 20px;">PENGIRIMAN</h1>

    <br>

    <table style="border-collapse: collapse; width: auto;">
        <tr>
            <td style="border: none; text-align: left;">Wilayah</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ $pengiriman->biaya_kirim->wilayah }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left; white-space: nowrap; min-width: 100px;">Jumlah Pengiriman</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left; white-space: nowrap; min-width: 100px;">{{ $pengiriman->jumlah_pengiriman }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Biaya Per Pengiriman</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ "Rp. " . number_format($pengiriman->biaya_kirim->nominal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">Total Biaya Pengiriman</td>
            <td style="border: none;">:</td>
            <td style="border: none; text-align: left;">{{ "Rp. " . number_format($pengiriman->jumlah_pengiriman * $pengiriman->biaya_kirim->nominal, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>

</html>
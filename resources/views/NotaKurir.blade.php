<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancangan Perkasa | Nota Kurir</title>
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
        <div style="display: inline-block; vertical-align: middle; width: 70px;">
            <img src="{{ base_path('/public/Images/logo.png') }}" alt="Rancangan Perkasa" style="width: 70px;">
        </div>

        <div style="display: inline-block; vertical-align: middle; text-align: left; padding-left: 10px;">
            <h1 style="font-size: 14px; font-weight: bold; margin: 0; text-align: center;">CV. RANCANGAN PERKASA</h1>
            <h2 style="font-size: 12px; font-weight: bold; margin: 0; text-align: center;">Distributor Bahan & Jasa Interior Eksterior</h2>
            <p style="font-size: 10px; margin: 0; text-align: center;">Jl. Sultan Agung No. 132 RT 006 RW 002 Kelurahan Kejambon</p>
            <p style="font-size: 10px; margin: 0; text-align: center;">Kecamatan Tegal Timur, Kota Tegal, Jawa Tengah, Indonesia</p>
        </div>

        <hr style="border: none; height: 0.5px; background-color: black; margin-bottom: 1px;">
        <hr style="border: none; height: 2px; background-color: black;">
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
                <p style="margin: 0;">{{ $pengiriman->nama_kurir }}</p>
                <p style="margin: 0;">{{ $pengiriman->no_wa_kurir }}</p>
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
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>

            @foreach ($daftar_produk as $item)
            <?php $index++; ?>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->nama }}</td>
                <td>{{ $item->jumlah }} {{ $item->produk->satuan }}</td>
            </tr>
            @endforeach

            <tr>
                <td>{{ $index }}</td>
                <td>Pengiriman Wilayah {{ $pengiriman->biaya_kirim->wilayah }}</td>
                <td>{{ $pengiriman->jumlah_pengiriman }} Pengiriman</td>
            </tr>
        </tbody>
    </table>

    <br>
    <p style="text-align: justify;">Mohon untuk segera melakukan pengriman barang sesuai diatas ke alamat pembeli. Setelah semua pengiriman selesai, mohon untuk segera melakukan konfirmasi dengan mengirim foto bukti ke Toko Rancangan Perkasa.</p>
</body>

</html>
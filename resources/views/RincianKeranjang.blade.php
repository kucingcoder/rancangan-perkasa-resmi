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
    <div class="flex gap-4 justify-center items-center">
        <div>
            <img src="{{base_path('/public/Images/logo simbol.png')}}" alt="Rancangan Perkasa" style="width: 60px;">
        </div>
        <div>
            <h1 class="text-center font-bold" style="font-size: 14px;">RANCANGAN PERKASA</h1>
            <h2 class="text-center font-bold" style="font-size: 12px;">Vendor Toko Bangunan Terpercaya</h2>
            <p class="text-center" style="font-size: 10px;">Jl. Raya Cikarang No. 1, Cikarang Timur, Bekasi</p>
        </div>
    </div>

    <div class="mt-4 flex gap-4 justify-between">
        <div class="max-w-1/2">
            <p>{{ $pembeli->nama }}</p>
            <p>{{ $pembeli->no_wa }}</p>
            <p>{{ $pembeli->alamat }}</p>
        </div>
        <div class="max-w-1/2">
            <p class="text-right">{{ $sales->nama }}</p>
            <p class="text-right">{{ $sales->no_wa }}</p>
        </div>
    </div>

    <table class="mt-4">
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

    <p class="mt-4" style="font-size: 12px;"><strong>Total : {{ "Rp. " . number_format($total_harga, 0, ',', '.') }}</strong></p>

    <p class="mt-4 text-justify">Harga di atas belum termasuk biaya pengiriman. Anda akan menerima nota pembayaran termasuk biaya pengiriman setelah pesanan disetujui oleh toko.</p>
</body>

</html>
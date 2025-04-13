@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Pesanan Detail')

@section('content')
<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Detail Pesanan</h2>

<div class="mt-6 w-full flex flex-col md:flex-row gap-4">
    <div class="w-full md:w-1/3 flex">
        <div class="w-full p-4 rounded-lg bg-grey-100 shadow-lg border border-grey-300 flex-1 h-full">
            <h1 class="text-center text-xl md:text-sm font-bold mb-4">Pembeli</h1>
            <div class="flex flex-col">
                <p>Nama : <span class="font-bold">{{$pembeli->nama}}</span></p>
                <p>Email : <span class="font-bold">{{$pembeli->email}}</span></p>
                <p>No Whatsapp : <span class="font-bold">{{$pembeli->no_wa}}</span></p>
                <p>Alamat : <span class="font-bold">{{$pembeli->alamat}}</span></p>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/3 flex">
        <div class="w-full p-4 rounded-lg bg-grey-100 shadow-lg border border-grey-300 flex-1 h-full">
            <h1 class="text-center text-xl md:text-sm font-bold mb-4">Sales</h1>
            <div class="flex flex-col">
                <p>Nama : <span class="font-bold">{{$sales->nama}}</span></p>
                <p>Email : <span class="font-bold">{{$sales->email}}</span></p>
                <p>No Whatsapp : <span class="font-bold">{{$sales->no_wa}}</span></p>
                <p>Alamat : <span class="font-bold">{{$sales->alamat}}</span></p>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/3 flex">
        <div class="w-full p-4 rounded-lg bg-grey-100 shadow-lg border border-grey-300 flex-1 h-full">
            <h1 class="text-center text-xl md:text-sm font-bold mb-4">Info Pesanan</h1>
            <div class="flex flex-col">
                <p>Status : <span class="font-bold">{{$pesanan->status}}</span></p>
                @if($pesanan->status != 'diperiksa' || $pesanan->status != 'tolak')
                <p>Total Pembelian : <span class="font-bold">{{ "Rp. " . number_format($pesanan->pendapatan, 0, ',', '.') }}</span></p>
                <p>Total Bonus : <span class="font-bold">{{ "Rp. " . number_format($pesanan->biaya_sales, 0, ',', '.') }}</span></p>
                @endif
                <p>Tanggal Dibuat : <span class="font-bold">{{$pesanan->created_at->format('d/m/Y')}}</span></p>
                <p>Tanggal Diperbaharui : <span class="font-bold">{{$pesanan->updated_at->format('d/m/Y')}}</span></p>
            </div>
        </div>
    </div>
</div>


<h2 class="mt-6 mb-4 text-xl md:text-2xl text-center md:text-left font-bold text-gray-700 mb-2">Daftar Produk</h2>

<table class="w-full bg-white border border-gray-200" id="daftar-produk">
    <thead>
        <tr>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama Produk</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Foto</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Harga</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Jumlah</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php $index = 1; ?>
        @foreach ($daftar_produk as $item)
        <tr class="border-b">
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->produk->nama }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700"><img src="{{ asset('storage/uploads/foto_produk/' . $item->produk->foto . '.webp') }}" alt="{{ $item->produk->nama_produk }}" class="w-20"></td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->produk->harga, 0, ',', '.') }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{$item->jumlah}} {{ $item->produk->satuan }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
        </tr>
        <?php $index++; ?>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    <div class="flex flex-col">
        <div class="flex gap-4 justify-left">
            <button onclick="location.href='/pesanan-masuk/{{$pesanan->id}}/laporan-internal'" class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">Download Laporan Toko</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#daftar-produk').DataTable();
    });

    function tutup() {
        const pesan = document.getElementById("alert");
        if (pesan) {
            pesan.style.display = "none";
        }
    }
</script>
@endsection
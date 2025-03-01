@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Pesanan Detail')

@section('content')

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Detail Pesanan</h2>

<div class="mt-6 w-full flex flex-col md:flex-row gap-4">
    <div class="w-full md:w-1/2 flex">
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

    <div class="w-full md:w-1/2 flex">
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

    <div class="w-full md:w-1/2 flex">
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

<div class="flex flex-col md:flex-row gap-4 mt-4">
    <button onclick="location.href='/pesanan/{{$pesanan->id}}/daftar-produk'" class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">Daftar Produk Dibeli</button>

    @if($pesanan->status != 'diperiksa' && $pesanan->status != 'ditolak')
    <button onclick="location.href='/pesanan/{{$pesanan->id}}/nota-pembeli'" class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">Download Nota</button>
    @endif

    @if($pesanan->status == 'selesai')
    <button onclick="location.href='/pesanan/{{$pesanan->id}}/laporan-sales'" class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">Download Laporan</button>
    @endif
</div>
@endsection
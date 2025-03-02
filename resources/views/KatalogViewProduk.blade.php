@extends('layouts.Landing')
@section('title', 'Rancangan Perkasa | {{ $produk->nama }}')

@section('content')
<div class="p-8">
    <div class="flex flex-col md:flex-row gap-4">
        <img class="w-full md:w-1/2 h-auto px-3 py-2 border border-gray-300 rounded" src="{{ asset('storage/uploads/foto_produk/' . $produk->foto . '.webp') }}" alt="Foto Produk">
        <div class="flex flex-col">
            <h1 class="text-2xl md:text-4xl font-bold">{{$produk->nama}}</h1>
            <h1 class="mt-4 text-xl md:text-3xl font-bold">{{ "Rp. " . number_format($produk->harga, 0, ',', '.') }} / {{$produk->satuan}}</h1>
            <h1 class="mt-4 text-xl md:text-3xl">Stok : {{floor($produk->stok->jumlah / $produk->isi)}} {{$produk->satuan}}</h1>
        </div>
    </div>

    <div class="flex flex-col">
        <h1 class="mt-8 text-2xl font-bold">Deskripsi</h1>
        <p class="mt-4 text-xl">{{$produk->deskripsi}}</p>
    </div>
</div>

<div class="absolute sticky bottom-0 bg-blue-950 p-4 text-white">
    <h1 class="text-xl">Untuk memesan hubungi <strong>{{$akun->no_wa}}</strong> (<strong>{{$akun->nama}})</strong></h1>
</div>
@endsection
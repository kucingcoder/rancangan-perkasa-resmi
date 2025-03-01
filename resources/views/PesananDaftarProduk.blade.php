@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Kelola')

@section('content')
<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Produk</h2>

<div class="mt-6 flex gap-4 flex-wrap justify-center md:justify-start items-center">
    @foreach ($daftar_produk as $item)
    <div class="w-full md:w-1/4 p-4 rounded-lg shadow-lg border border-gray-300">
        <h1 class="text-center text-xl md:text-sm font-bold mb-4">{{$item->produk->nama}}</h1>
        <div class="relative w-full pb-[100%] border border-gray-300 rounded overflow-hidden">
            <img src="{{ asset('storage/uploads/foto_produk/' . $item->produk->foto .'.webp') }}"
                alt="foto produk"
                loading="lazy"
                class="absolute top-0 left-0 w-full h-full object-cover z-0">
        </div>
        <h1 class="mt-4 text-xl md:text-sm font-bold mb-1">{{ "Rp. " . number_format($item->produk->harga, 0, ',', '.') }} / {{$item->produk->satuan}}</h1>
        <h1 class="text-lg md:text-sm">Jumlah : {{$item->jumlah}} {{$item->produk->satuan}}</h1>
    </div>
    @endforeach
</div>
@endsection
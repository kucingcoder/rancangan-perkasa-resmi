@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Pesanan')

@section('content')
<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Pesanan</h2>

<div class="mt-6 flex gap-4">
    <input type="text" name="cari" id="cari" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Kode Invoice/Nama Pembeli/Nama Keranjang" required>
    <button type="button" onclick="cari()" class="px-4 py-2 bg-blue-950 text-white rounded hover:bg-blue-700">Cari</button>
</div>

<div class="mt-6 flex gap-4 flex-wrap justify-center md:justify-start items-center">
    @foreach ($pesanan as $item)
    <div class="w-full md:w-1/4 p-4 rounded-lg bg-grey-100 shadow shadow-lg border border-grey-300">
        <h1 class="text-center text-xl md:text-sm font-bold">{{$item->keranjang->judul}}</h1>
        <h1 class="text-center text-xl md:text-sm mb-4">{{$item->keranjang->pembeli->nama}}</h1>
        <div class="flex justify-between">
            <p>{{$item->status}}</p>
            <p>{{$item->updated_at->format('d-m-Y')}}</p>
        </div>
        <div class="mt-4 flex">
            <button onclick="window.location.href='/pesanan/{{$item->id}}'" class="w-full px-4 py-2 text-sm text-white bg-blue-950 rounded hover:bg-blue-600">Lihat</button>
        </div>
    </div>
    @endforeach
</div>

<script>
    document.getElementById("cari").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            cari();
        }
    });

    function cari() {
        var cari = document.getElementById('cari').value;
        window.location.href = '/pesanan/cari/' + cari;
    }
</script>
@endsection
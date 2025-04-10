@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Tambah Produk')

@section('content')
<div class="mt-6 flex gap-4">
    <input type="text" name="cari" id="cari" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Cari Produk" required>
    <button type="button" onclick="cari()" class="px-4 py-2 bg-blue-950 text-white rounded hover:bg-blue-700">Cari</button>
</div>

<div class="mt-6 flex gap-4 flex-wrap justify-center md:justify-start items-center">
    @foreach ($produk as $item)
    <div class="w-full md:w-1/4 p-4 rounded-lg shadow-lg border border-gray-300">
        <h1 class="text-center text-xl md:text-sm font-bold mb-4">{{$item->nama}}</h1>
        <div class="relative w-full pb-[100%] border border-gray-300 rounded overflow-hidden">
            <img src="{{ asset('storage/uploads/foto_produk/' . $item->foto . '.webp') }}"
                alt="foto produk"
                loading="lazy"
                class="absolute top-0 left-0 w-full h-full object-cover z-0">
        </div>
        <h1 class="mt-4 text-xl md:text-sm font-bold mb-1">{{ "Rp. " . number_format($item->harga, 0, ',', '.') }} / {{$item->satuan}}</h1>
        <h1 class="text-lg md:text-sm">Stok : {{floor($item->stok->jumlah / $item->isi)}} {{$item->satuan}}</h1>

        <!-- Action Buttons -->
        <button onclick="location.href='/keranjang/kelola/{{$id}}/tambah-produk/{{ $item->id }}'" class="mt-4 w-full px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
            Pilih
        </button>
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
        window.location.href = '/keranjang/kelola/{{$id}}/tambah-produk/cari/' + cari;
    }
</script>
@endsection
@extends('layouts.Landing')
@section('title', 'Rancangan Perkasa | Katalog')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl mb-4 font-bold text-center md:text-left mb-8">DAFTAR PRODUK</h1>
    <div class="mt-6 flex gap-4 mb-8">
        <input type="text" name="cari" id="cari" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Cari Produk" required>
        <button type="button" onclick="cari()" class="px-4 py-2 bg-blue-950 text-white rounded hover:bg-blue-700">Cari</button>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($produk as $item)
        <a href="#"
            class="mx-auto sm:mr-0 group cursor-pointer lg:mx-auto bg-white transition-all duration-500">
            <div class="">
                <img src="{{ asset('storage/uploads/foto_produk/' . $item->foto . '.webp') }}" alt="{{$item->nama}}" loading="lazy"
                    class="w-full aspect-square rounded-2xl object-cover">
            </div>
            <div class="mt-5">
                <div class="flex flex-col">
                    <h6
                        class="font-semibold text-xl leading-8 text-black transition-all duration-500 group-hover:text-blue-950">{{$item->nama}}</h6>
                    <h6 class="font-semibold text-xl leading-8 text-green-500">{{ "Rp. " . number_format($item->harga, 0, ',', '.') }} / {{$item->satuan}}</h6>
                </div>
                <p class="mt-2 font-normal text-sm leading-6 text-gray-500">{{ Str::limit($item->deskripsi, 100) }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<script>
    function cari() {
        var cari = document.getElementById('cari').value;
        window.location.href = '/katalog/{{$id}}/' + cari;
    }
</script>
@endsection
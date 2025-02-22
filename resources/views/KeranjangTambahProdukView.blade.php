@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Info Produk')

@section('content')
@if ($errors->any())
<div id="alert" class="bg-red-300 border border-red-300 text-red-dark px-12 py-3 rounded fixed top-0 right-0 m-4 z-50" role="alert">
    <strong class="font-bold">Gagal!</strong>
    <span class="block sm:inline">{{ $errors->first() }}</span>
    <span class="absolute top-0 right-0 px-1 py-3" onclick="tutup()">
        <svg
            class="fill-current h-6 w-6 text-red cursor-pointer"
            role="button"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </span>
</div>
@endif

@if (session('success'))
<div id="alert" class="bg-green-300 border border-green-300 text-green-dark px-12 py-3 rounded fixed top-0 right-0 m-4 z-50" role="alert">
    <strong class="font-bold">Berhasil!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
    <span class="absolute top-0 right-0 px-1 py-3" onclick="tutup()">
        <svg
            class="fill-current h-6 w-6 text-red cursor-pointer"
            role="button"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </span>
</div>
@endif

<div class="mt-8 flex flex-col md:flex-row gap-4">
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

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full mx-4 md:w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">{{$produk->nama}}</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambah" action="/keranjang/kelola/{{$id}}/masukan-produk" method="POST">
            @csrf
            <input type="hidden" id="id_keranjang" name="id_keranjang" value="{{$id}}">
            <input type="hidden" id="id_produk" name="id_produk" value="{{$item_id}}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="jumlah">Jumlah {{$produk->satuan}} (Stok : {{floor($produk->stok->jumlah / $produk->isi)}} {{$produk->satuan}})</label>
                <input type="number" id="jumlah" name="jumlah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Masukan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="flex">
    <button onclick="tambah()" class="mt-8 w-full px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
        Masukan Keranjang
    </button>
</div>

<script>
    function tambah() {
        document.getElementById('dataModal').classList.remove('hidden');
    }

    function tutup() {
        pesan = document.getElementById("alert");
        pesan.style.display = "none";
    }
</script>
@endsection
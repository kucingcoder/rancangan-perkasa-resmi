@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Keranjang')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Keranjang</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg mx-4 md:mx-0">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Cari Pembeli</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambah" action="/keranjang/pembeli-cari" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_pembeli">Nama Pembeli</label>
                <input type="text" id="nama_pembeli" name="nama_pembeli" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan nama pembeli" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="flex justify-left my-4">
    <button
        class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600"
        onclick="document.getElementById('dataModal').classList.remove('hidden')">
        Buat Keranjang Baru
    </button>
</div>

<!-- Modal Dialog ubah status -->
<div id="dataModalHapus" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full mx-4 md:mx-0 md:w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Hapus Keranjang</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalHapus').classList.add('hidden')">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin menghapus keranjang ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/keranjang-hapus" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_hapus" name="id_hapus" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalHapus').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<div class="mt-6 flex gap-4 flex-wrap justify-center md:justify-start items-center">
    @foreach ($keranjang as $item)
    <div class="w-full md:w-1/4 p-4 rounded-lg bg-grey-100 shadow shadow-lg border border-grey-300">
        <h1 class="text-center text-xl md:text-sm font-bold mb-4">{{$item->judul}}</h1>
        <div class="mb-4">
            <input type="hidden" id="id" name="id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{$item->id}}" readonly required>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button onclick="window.location.href='/keranjang/kelola/{{$item->id}}'" class="w-full px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                Kelola
            </button>

            <button onclick="hapus('{{$item->id}}')" class="w-full px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                Hapus
            </button>
        </div>
    </div>
    @endforeach
</div>

<script>
    function hapus(id) {
        document.getElementById('id_hapus').value = id;
        document.getElementById('dataModalHapus').classList.remove('hidden');
    }

    function tutup() {
        pesan = document.getElementById("alert");
        pesan.style.display = "none";
    }
</script>

@endsection
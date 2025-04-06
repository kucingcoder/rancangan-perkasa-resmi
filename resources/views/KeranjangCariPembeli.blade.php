@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Cari Pembeli')

@section('content')
<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg mx-4 md:mx-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Buat Data Pembeli Baru</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambah" action="/keranjang/buat-pembeli-baru" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_pembeli">Nama Pembeli</label>
                <input type="text" id="nama_pembeli" name="nama_pembeli" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan nama lengkap pembeli" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa">No WA</label>
                <input type="text" id="no_wa" name="no_wa" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan no wa" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                <input type="text" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan email (opsional)" autocomplete="email">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat">Alamat Pengiriman</label>
                <textarea type="text" id="alamat" name="alamat" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" cols="100" rows="4" style="resize: none;"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden');">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Buat
                </button>
            </div>
        </form>
    </div>
</div>

@if ($pembeli->isEmpty())
<div class="mt-8 w-full flex justify-center items-center">
    <div class="w-full flex flex-col justify-center items-center border-2 border-dashed rounded-lg border-gray-500 p-4">
        <h1 class="text-xl md:text-2xl font-bold text-center text-blue-900">Data Pembeli</h1>
        <h1 class="text-xl md:text-2xl font-bold text-center text-blue-900">Tidak Ditemukan</h1>
        <button class="mt-4 mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600" onclick="document.getElementById('dataModal').classList.remove('hidden')">
            Buat Data Pembeli Baru
        </button>
    </div>
</div>
@else
<h1 class="mt-8 text-xl md:text-2xl font-bold text-center text-blue-900">Data Pembeli Ditemukan</h1>
<div class="mt-6 flex flex-wrap justify-center md:justify-start items-center">
    @foreach ($pembeli as $item)
    <div class="w-full mb-4 md:mb-0 md:mx-4 md:my-4 md:w-1/3 p-4 rounded-lg bg-green-100 shadow shadow-lg border border-lime-300">
        <h1 class="text-md md:text-xl font-bold text-lime-600">{{$item->nama}}</h1>
        <p class="text-md md:text-xl font-bold text-lime-600">{{$item->no_wa}}</p>
        @if (!empty($item->email))
        <p class="text-md md:text-xl font-bold text-lime-600">{{$item->email}}</p>
        @endif
        <textarea class="w-full text-md md:text-xl font-bold text-lime-600 bg-green-100" cols="100" rows="2" style="resize: none;" readonly>{{$item->alamat}}</textarea>
        <form action="/keranjang/buat-keranjang" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_pembeli" name="id_pembeli" value="{{$item->id}}" required>
            </div>

            <button type="submit" class="w-full mt-4 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                Pilih
            </button>
        </form>
    </div>
    @endforeach
</div>

<div class="fixed bottom-4 left-0 right-0 px-4 z-50 flex justify-center md:justify-end md:bottom-4 md:right-4 md:left-auto">
    <button onclick="document.getElementById('dataModal').classList.remove('hidden')"
        class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600 shadow-lg">
        Buat Pembeli Baru
    </button>
</div>

@endif
@endsection
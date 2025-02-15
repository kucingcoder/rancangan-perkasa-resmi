@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Buat Keranjang')

@section('content')
<div class="flex justify-center items-center">
    <div class="mt-8 bg-white w-full md:w-96 p-6 rounded-lg shadow-lg mx-4 md:mx-0">
        <!-- Form -->
        <form id="tambah" action="/keranjang/simpan-keranjang" method="POST">
            @csrf
            <h1 class="text-center text-xl font-bold mb-4">Keranjang Baru</h1>
            <div class="mb-4">
                <input type="hidden" id="id" name="id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{$pembeli->id}}" readonly required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_pembeli">Nama Pembeli</label>
                <input type="text" id="nama_pembeli" name="nama_pembeli" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{$pembeli->nama}}" readonly required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="judul">Nama Keranjang</label>
                <input type="text" id="judul" name="judul" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Beri nama keranjang" required>
            </div>

            <!-- Action Buttons -->
            <button type="submit" class="w-full px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                Buat
            </button>
        </form>
    </div>
</div>
@endsection
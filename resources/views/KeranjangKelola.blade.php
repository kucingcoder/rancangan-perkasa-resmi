@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Kelola')

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

<div class="mt-4 gap-4 flex flex-col md:flex-row justify-left">
    <button type="button" onclick="location.href='/keranjang/kelola/{{$id}}/tambah-produk'" class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
        Tambah Produk
    </button>
    <button type="button" onclick="location.href='/keranjang/kelola/{{$id}}/rincian'" class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
        Download Rincian
    </button>
    <button type="button" onclick="Pesan()" class="w-full md:w-fit px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
        Checkout
    </button>
</div>

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

        <!-- Action Buttons -->
        <div class="mt-4 flex gap-2">
            <button onclick="edit('{{$id}}','{{$item->produk_id}}','{{$item->jumlah}}','{{floor($item->produk->stok->jumlah / $item->produk->isi)}}','{{$item->produk->satuan}}')" class="w-full px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                Edit
            </button>

            <button onclick="hapus('{{$id}}','{{$item->produk_id}}')" class="w-full px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                Hapus
            </button>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full mx-4 md:w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Edit Jumlah</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/keranjang/kelola/{{$id}}/edit-produk" method="POST">
            @csrf
            <input type="hidden" id="id_keranjang" name="id_keranjang" value="">
            <input type="hidden" id="id_produk" name="id_produk" value="">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" id="label_jumlah" for="jumlah"></label>
                <input type="number" id="jumlah" name="jumlah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Ubah
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog ubah status -->
<div id="dataModalHapus" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full mx-4 md:mx-0 md:w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Hapus Produk</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalHapus').classList.add('hidden')">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin menghapus produk ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/keranjang/kelola/{{$id}}/hapus-produk" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_keranjang_hapus" name="id_keranjang_hapus" required>
                <input type="hidden" id="id_produk_hapus" name="id_produk_hapus" required>
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

<!-- Modal Dialog pesan keranjang -->
<div id="dataModalPesan" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full mx-4 md:mx-0 md:w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Pesan Keranjang</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalPesan').classList.add('hidden')">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin memesan keranjang ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/keranjang/kelola/{{$id}}/pesan" method="POST">
            @csrf
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalPesan').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                    Pesan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function edit(id_keranjang, id_produk, jumlah, stok, satuan) {
        document.getElementById('dataModal').classList.remove('hidden');
        document.getElementById('id_keranjang').value = id_keranjang;
        document.getElementById('id_produk').value = id_produk;
        document.getElementById('jumlah').value = jumlah;
        document.getElementById('label_jumlah').textContent = "Jumlah " + satuan + " (Stok : " + stok + " " + satuan + ")";
    }

    function hapus(id_keranjang, id_produk) {
        document.getElementById('dataModalHapus').classList.remove('hidden');
        document.getElementById('id_keranjang_hapus').value = id_keranjang;
        document.getElementById('id_produk_hapus').value = id_produk;
    }

    function Pesan() {
        document.getElementById('dataModalPesan').classList.remove('hidden');
    }

    function tutup() {
        document.getElementById('alert').classList.add('hidden');
    }
</script>
@endsection
@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Ekspedisi')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Ekspedisi</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Ekspedisi Baru</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambah" action="/ekspedisi-tambah" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_ekspedisi">Nama Ekspedisi</label>
                <input type="text" id="nama_ekspedisi" name="nama_ekspedisi" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama ekspedisi" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog edit data -->
<div id="dataModaledit" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Edit Data</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModaledit').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/ekspedisi-edit" method="POST">
            @csrf
            <input type="hidden" name="id_edit" id="id_edit" required>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_edit">Nama Ekspedisi</label>
                <input type="text" id="nama_edit" name="nama_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama ekspedisi" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModaledit').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog hapus data -->
<div id="dataModalHapus" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Hapus Data</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalHapus').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin menghapus data ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/ekspedisi-hapus" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_hapus" name="id_hapus" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalHapus').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden');">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="flex flex-col w-full">
    <!-- Button Tambah -->
    <!-- Button untuk membuka dialog -->
    <div class="flex justify-left my-4">
        <button
            class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600"
            onclick="document.getElementById('dataModal').classList.remove('hidden'); document.getElementById('daftar-kategori').classList.add('hidden')">
            Buat Ekspedisi Baru
        </button>
    </div>

    <table class="w-full bg-white border border-gray-200 table-auto" id="daftar-kategori">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama Ekspedisi</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($ekspedisi as $item)
            <tr class="">
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->nama}}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <button onclick="edit('{{ $item->id }}','{{ $item->nama }}')" class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
                    <button onclick="hapus('{{ $item->id }}')" class="mt-2 md:mt-0 px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                </td>
            </tr>
            <?php $index++; ?>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = new simpleDatatables.DataTable("#daftar-kategori", {
            perPage: 5,
            perPageSelect: [5, 10, 15, 20, 50]
        });
    });

    function edit(id, nama_ekspedisi) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModaledit').classList.remove('hidden')
        document.getElementById('id_edit').value = id
        document.getElementById('nama_edit').value = nama_ekspedisi
    }

    function hapus(id) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModalHapus').classList.remove('hidden')
        document.getElementById('id_hapus').value = id
    }

    function tutup() {
        pesan = document.getElementById("alert");
        pesan.style.display = "none";
    }
</script>
@endsection
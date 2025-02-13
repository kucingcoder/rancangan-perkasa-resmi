@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Barang')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Barang</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Tambah Data Barang</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden'); document.getElementById('daftar-barang').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambahBarang" action="/barang-tambah" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_barang">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama barang" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan harga" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="stok">Stok</label>
                            <input type="number" id="stok" name="stok" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah stok" required>
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto">Foto (PNG, JPG, JPEG)</label>
                        <input type="file" id="foto" name="foto" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="4" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" id="spesifikasi"></textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden'); document.getElementById('daftar-barang').classList.remove('hidden')">
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
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Edit Data</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModaledit').classList.add('hidden'); document.getElementById('daftar-barang').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/barang-edit" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_edit" id="id_edit" required>

            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_barang_edit">Nama Barang</label>
                        <input type="text" id="nama_barang_edit" name="nama_barang_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama barang" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="kategori_edit">Kategori</label>
                        <select id="kategori_edit" name="kategori_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="harga_edit">Harga</label>
                            <input type="number" id="harga_edit" name="harga_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan harga" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="stok_edit">Stok</label>
                            <input type="number" id="stok_edit" name="stok_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah stok" required>
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_edit">Foto (PNG, JPG, JPEG)</label>
                        <input type="file" id="foto_edit" name="foto_edit" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="deskripsi_edit">Deskripsi</label>
                        <textarea name="deskripsi_edit" id="deskripsi_edit" cols="30" rows="4" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" id="spesifikasi"></textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModaledit').classList.add('hidden'); document.getElementById('daftar-barang').classList.remove('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                    Perbaharui
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
                onclick="document.getElementById('dataModalHapus').classList.add('hidden'); document.getElementById('daftar-barang').classList.remove('hidden');">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin menghapus data ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/barang-hapus" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_hapus" name="id_hapus" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalHapus').classList.add('hidden'); document.getElementById('daftar-barang').classList.remove('hidden');">
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
    <div class="flex justify-left my-4 mx-4">
        <button
            class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600"
            onclick="tambah()">
            Tambah Data
        </button>
    </div>

    <table class="w-full bg-white border border-gray-200" id="daftar-barang">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama Barang</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Kategori</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Harga</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Stok</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Spesifikasi</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Deskripsi</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Foto</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($barang as $item)
            <tr class="border-b">
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->nama_barang }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->kategori->nama_kategori }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->harga, 0, ',', '.') }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->stok }} {{ $item->kategori->satuan }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <pre>{{ $item->kategori->spesifikasi }}</pre>
                </td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <pre>{{ $item->deskripsi }}</pre>
                </td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <img style="cursor: pointer" onclick="window.open(`{{ asset('storage/uploads/foto_barang/' . $item->foto . '.webp') }}`, '_blank');" src="{{ asset('storage/uploads/foto_barang/' . $item->foto . '.webp') }}" alt="Foto {{ $item->nama_barang }}" class="h-16 w-16 object-cover rounded">
                </td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <button onclick="edit('{{ $item->id }}','{{ $item->nama_barang }}','{{ $item->kategori_id }}','{{ $item->harga }}','{{ $item->stok }}', `{{ $item->deskripsi }}`)" class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
                    <button onclick="hapus('{{ $item->id }}')" class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                </td>
            </tr>
            <?php $index++; ?>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = new simpleDatatables.DataTable("#daftar-barang");
    });

    function edit(id, nama_barang, kategori, harga, stok, deskripsi) {
        document.getElementById('daftar-barang').classList.add('hidden');
        document.getElementById('dataModaledit').classList.remove('hidden');

        document.getElementById('id_edit').value = id;
        document.getElementById('nama_barang_edit').value = nama_barang;
        document.getElementById('kategori_edit').value = kategori;
        document.getElementById('harga_edit').value = harga;
        document.getElementById('stok_edit').value = stok;
        document.getElementById('deskripsi_edit').value = deskripsi;
    }

    function tambah() {
        document.getElementById('daftar-barang').classList.add('hidden');
        document.getElementById('dataModal').classList.remove('hidden');
    }

    function hapus(id) {
        document.getElementById('daftar-barang').classList.add('hidden');
        document.getElementById('dataModalHapus').classList.remove('hidden');
        // Set nilai id barang yang akan dihapus
        document.getElementById('id_hapus').value = id;
    }


    function tutup() {
        const pesan = document.getElementById("alert");
        if (pesan) {
            pesan.style.display = "none";
        }
    }
</script>
@endsection
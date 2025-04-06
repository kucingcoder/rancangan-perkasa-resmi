@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Produk')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar produk</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Produk Baru</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambahproduk" action="/produk-tambah" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama">Nama produk</label>
                        <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama produk" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="stok_id">Stok</label>
                        <select id="stok_id" name="stok_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Pilih Stok</option>
                            @foreach ($Stok as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="isi">Isi</label>
                            <input type="number" id="isi" name="isi" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan isi" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="satuan">Satuan Pembelian</label>
                            <input type="text" id="satuan" name="satuan" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan satuan" required>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="modal_produk">Modal</label>
                            <input type="number" id="modal_produk" name="modal_produk" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan modal" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="biaya_sales">Biaya Sales</label>
                            <input type="number" id="biaya_sales" name="biaya_sales" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan biaya sales" required>
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

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="harga">Harga Jual</label>
                        <input type="number" id="harga" name="harga" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan harga" required>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModal').classList.add('hidden')">
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
<div id="dataModaledit" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Edit Data</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModaledit').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/produk-edit" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_edit" id="id_edit" required>

            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_edit">Nama produk</label>
                        <input type="text" id="nama_edit" name="nama_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama produk" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="stok_id_edit">Stok</label>
                        <select id="stok_id_edit" name="stok_id_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Pilih Stok</option>
                            @foreach ($Stok as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="isi_edit">Isi</label>
                            <input type="number" id="isi_edit" name="isi_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan isi" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="satuan_edit">Satuan Pembelian</label>
                            <input type="text" id="satuan_edit" name="satuan_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan satuan" required>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="modal_produk_edit">Modal</label>
                            <input type="number" id="modal_produk_edit" name="modal_produk_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan modal" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="biaya_sales_edit">Biaya Sales</label>
                            <input type="number" id="biaya_sales_edit" name="biaya_sales_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan biaya sales" required>
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

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="harga_edit">Harga</label>
                        <input type="number" id="harga_edit" name="harga_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan harga" required>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModaledit').classList.add('hidden')">
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
<div id="dataModalHapus" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Hapus Data</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalHapus').classList.add('hidden');">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin menghapus data ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/produk-hapus" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_hapus" name="id_hapus" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalHapus').classList.add('hidden');">
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
            Buat produk Baru
        </button>
    </div>

    <table class="w-full bg-white border border-gray-200" id="daftar-produk">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama Produk</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Foto</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Deskripsi</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Isi</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Satuan Pembelian</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Modal</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Biaya Sales</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Harga</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Stok</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($Produk as $item)
            <tr class="border-b">
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->nama }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <img style="cursor: pointer" onclick="window.open(`{{ asset('storage/uploads/foto_produk/' . $item->foto . '.webp') }}`, '_blank');" src="{{ asset('storage/uploads/foto_produk/' . $item->foto . '.webp') }}" alt="Foto {{ $item->nama_produk }}" class="h-16 w-16 object-cover rounded">
                </td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700 max-w-80">
                    <pre class="whitespace-pre-wrap">{{ $item->deskripsi }}</pre>
                </td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->isi }} {{ $item->stok->satuan }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->satuan }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->modal, 0, ',', '.') }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->biaya_sales, 0, ',', '.') }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->harga, 0, ',', '.') }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ floor($item->stok->jumlah / $item->isi) }} {{ $item->satuan }}</td>

                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700 flex flex-col gap-2">
                    <button onclick="edit('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->stok_id }}', '{{ $item->isi }}', '{{ $item->satuan }}', '{{ $item->modal }}', '{{ $item->harga }}', '{{ $item->biaya_sales }}', `{{ $item->deskripsi }}`)" class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
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
        const table = new simpleDatatables.DataTable("#daftar-produk");
    });

    function edit(id, nama_produk, stok, isi, satuan, modal, harga, biaya_sales, deskripsi) {
        document.getElementById('dataModaledit').classList.remove('hidden');

        document.getElementById('id_edit').value = id;
        document.getElementById('nama_edit').value = nama_produk;
        document.getElementById('stok_id_edit').value = stok;
        document.getElementById('isi_edit').value = isi;
        document.getElementById('satuan_edit').value = satuan;
        document.getElementById('modal_produk_edit').value = modal;
        document.getElementById('harga_edit').value = harga;
        document.getElementById('biaya_sales_edit').value = biaya_sales;
        document.getElementById('deskripsi_edit').value = deskripsi;
    }

    function tambah() {
        document.getElementById('dataModal').classList.remove('hidden');
    }

    function hapus(id) {
        document.getElementById('dataModalHapus').classList.remove('hidden');
        // Set nilai id produk yang akan dihapus
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
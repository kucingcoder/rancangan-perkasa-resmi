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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Karyawan</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Karyawan Baru</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambahkaryawan" action="/karyawan-tambah" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama">Nama Karyawan</label>
                        <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama karyawan" required>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_kelamin">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                <option selected disabled value="">Pilih Jenis Kelamin</option>
                                <option value="laki-laki">Laki - Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah stok" required>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa">No WA</label>
                            <input type="text" id="no_wa" name="no_wa" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan no wa" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="gaji">Gaji</label>
                            <input type="number" id="gaji" name="gaji" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan gaji" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan alamat" required>
                    </div>
                </div>

                <div class="ml-4 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto">Foto (PNG, JPG, JPEG)</label>
                        <input type="file" id="foto" name="foto" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="8" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                </div>
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

<!-- Modal Dialog Detail data -->
<div id="dataModaldetail" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Detail Karyawan</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModaldetail').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form>
            @csrf
            <input type="hidden" name="id_detail" id="id_detail" required>
            <div class="flex">
                <div class="kiri w-1/3 mr-4">
                    <label class="block text-sm font-medium text-white mb-1" for="foto_detail">Foto Orang</label>
                    <img class="w-full h-auto px-3 py-2 border border-gray-300 rounded" id="foto_detail" src="" alt="foto orang">
                    <button type="button" onclick="downloadFile()" class="w-full mt-4 px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Download</button>
                </div>
                <div class="tengah w-1/3 mr-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_detail">Nama</label>
                        <input type="text" id="nama_detail" name="nama_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_kelamin_detail">Jenis Kelamin</label>
                        <input type="text" id="jenis_kelamin_detail" name="jenis_kelamin_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="tanggal_lahir_detail">Tanggal Lahir</label>
                        <input type="text" id="tanggal_lahir_detail" name="tanggal_lahir_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="deskripsi_detail">Deskripsi</label>
                        <textarea type="text" id="deskripsi_detail" name="deskripsi_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" cols="100" rows="4" style="resize: none;" readonly></textarea>
                    </div>
                </div>
                <div class="kanan w-1/3">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_detail">Alamat</label>
                        <input type="text" id="alamat_detail" name="alamat_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_detail">Nomor Whatsapp</label>
                        <input type="text" id="no_wa_detail" name="no_wa_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_detail">Gaji</label>
                        <input type="text" id="gaji_detail" name="gaji_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModaldetail').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                    Ok
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
                onclick="document.getElementById('dataModaledit').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/karyawan-edit" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_edit" id="id_edit" required>

            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_edit">Nama Karyawan</label>
                        <input type="text" id="nama_edit" name="nama_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama karyawan" required>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_kelamin_edit">Jenis Kelamin</label>
                            <select id="jenis_kelamin_edit" name="jenis_kelamin_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                <option selected disabled value="">Pilih Jenis Kelamin</option>
                                <option value="laki-laki">Laki - Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="tanggal_lahir_edit">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir_edit" name="tanggal_lahir_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah stok" required>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_edit">No WA</label>
                            <input type="text" id="no_wa_edit" name="no_wa_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan no wa" required>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="gaji_edit">Gaji</label>
                            <input type="number" id="gaji_edit" name="gaji_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan gaji" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_edit">Alamat</label>
                        <textarea name="alamat_edit" id="alamat_edit" cols="30" rows="1" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                </div>

                <div class="ml-4 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_edit">Foto (PNG, JPG, JPEG)</label>
                        <input type="file" id="foto_edit" name="foto_edit" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="deskripsi_edit">Deskripsi</label>
                        <textarea name="deskripsi_edit" id="deskripsi_edit" cols="30" rows="8" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModaledit').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                    Perbaharui
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog ubah status -->
<div id="dataModalHapus" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Ubah Status</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalHapus').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden');">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin mengubah status karyawan ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/karyawan-ubah-status" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_status" name="id_status" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalHapus').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden');">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                    Ubah Status
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
            Buat Karyawan Baru
        </button>
    </div>

    <table class="w-full bg-white border border-gray-200" id="daftar-kategori">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No WA</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Deskripsi</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($karyawan as $item)
            <tr>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->nama}}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->no_wa}}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <pre>{{ $item->deskripsi }}</pre>
                </td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700 flex flex-col gap-2">
                    <?php $link_foto = asset('storage/uploads/foto_orang/' . $item->foto) ?>
                    <button onclick="detail('{{$item->id}}', '{{$item->nama}}', '{{$item->jenis_kelamin}}', `{{$item->tanggal_lahir->format('d-m-Y')}}`, `{{$item->alamat}}`, '{{$item->no_wa}}', '{{$item->gaji}}', '{{$link_foto}}', `{{$item->deskripsi}}`)" class="w-fit px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Detail</button>
                    <button onclick="edit('{{$item->id}}', '{{$item->nama}}', '{{$item->jenis_kelamin}}', `{{$item->tanggal_lahir->format('Y-m-d')}}`, `{{$item->alamat}}`, '{{$item->no_wa}}', '{{$item->gaji}}', `{{$item->deskripsi}}`)" class="w-fit px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
                    <?php if ($item->status == "aktif") {
                        echo '<button onclick="status(\'' . $item->id . '\')" class="w-fit px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Nonaktifkan</button>';
                    } else {
                        echo '<button onclick="status(\'' . $item->id . '\')" class="w-fit px-3 py-1 text-sm text-white bg-green-500 rounded hover:bg-green-600">Aktifkan</button>';
                    }
                    ?>
                </td>
            </tr>
            <?php $index++; ?>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = new simpleDatatables.DataTable("#daftar-kategori");
    });

    function tutup() {
        pesan = document.getElementById("alert");
        pesan.style.display = "none";
    }

    function downloadFile() {
        let imgSrc = document.getElementById('foto_detail').src;
        let fileName = imgSrc.substring(imgSrc.lastIndexOf('/') + 1);

        let link = document.createElement('a');
        link.href = imgSrc;
        link.download = fileName;
        link.click();
    }

    function tambah() {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModal').classList.remove('hidden')
    }

    function detail(id, nama, jenis_kelamin, tanggal_lahir, alamat, no_wa, gaji, foto, deskripsi) {
        document.getElementById('id_detail').value = id
        document.getElementById('nama_detail').value = nama
        document.getElementById('jenis_kelamin_detail').value = jenis_kelamin
        document.getElementById('tanggal_lahir_detail').value = tanggal_lahir
        document.getElementById('alamat_detail').value = alamat
        document.getElementById('no_wa_detail').value = no_wa
        document.getElementById('gaji_detail').value = gaji
        document.getElementById('deskripsi_detail').value = deskripsi
        document.getElementById('foto_detail').src = foto

        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModaldetail').classList.remove('hidden')
    }

    function edit(id, nama, jenis_kelamin, tanggal_lahir, alamat, no_wa, gaji, deskripsi) {
        document.getElementById('id_edit').value = id
        document.getElementById('nama_edit').value = nama
        document.getElementById('jenis_kelamin_edit').value = jenis_kelamin
        document.getElementById('tanggal_lahir_edit').value = tanggal_lahir
        document.getElementById('alamat_edit').value = alamat
        document.getElementById('no_wa_edit').value = no_wa
        document.getElementById('gaji_edit').value = gaji
        document.getElementById('deskripsi_edit').value = deskripsi

        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModaledit').classList.remove('hidden')
    }

    function status(id) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModalHapus').classList.remove('hidden')
        document.getElementById('id_status').value = id
    }
</script>
@endsection
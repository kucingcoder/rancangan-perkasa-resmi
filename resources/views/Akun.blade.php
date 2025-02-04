@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Akun')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Akun</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModaltambah" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Tambah Data</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModaltambah').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambah" action="/akun-tambah" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_tambah" id="id_tambah" required>
            <div class="flex justify-center">
                <div class="kiri w-1/2 mr-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_tambah">Nama</label>
                        <input type="text" id="nama_tambah" name="nama_tambah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_kelamin_tambah">Jenis Kelamin</label>
                        <select id="jenis_kelamin_tambah" name="jenis_kelamin_tambah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option selected disabled value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki - Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_tambah">Alamat</label>
                        <textarea type="text" id="alamat_tambah" name="alamat_tambah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" cols="100" rows="5"
                            placeholder="Masukan alamat" required style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="kanan w-1/2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email_tambah">Email</label>
                        <input type="text" id="email_tambah" name="email_tambah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Masukan email" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_tambah">Nomor Whatapp</label>
                        <input type="text" id="no_wa_tambah" name="no_wa_tambah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Masukan Nomor Whatapp" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_akun_tambah">Jenis Akun</label>
                        <select id="jenis_akun_tambah" name="jenis_akun_tambah" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="owner">Owner</option>
                            <option value="admin">Admin</option>
                            <option selected value="sales">Sales</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_tambah">Foto (PNG, JPG, JPEG)</label>
                            <input type="file" id="foto_tambah" name="foto_tambah" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModaltambah').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
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
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Detail Akun</h2>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_detail">Alamat</label>
                        <textarea type="text" id="alamat_detail" name="alamat_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" cols="100" rows="4" style="resize: none;" readonly></textarea>
                    </div>
                </div>
                <div class="kanan w-1/3">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email_detail">Email</label>
                        <input type="text" id="email_detail" name="email_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_detail">Nomor Whatapp</label>
                        <input type="text" id="no_wa_detail" name="no_wa_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_akun_detail">Jenis Akun</label>
                        <input type="text" id="jenis_akun_detail" name="jenis_akun_detail" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
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
        <form id="edit" action="/akun-edit" method="POST">
            @csrf
            <input type="hidden" name="id_edit" id="id_edit" required>
            <div class="flex justify-center">
                <div class="kiri w-1/2 mr-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_edit">Nama</label>
                        <input type="text" id="nama_edit" name="nama_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_kelamin_edit">Jenis Kelamin</label>
                        <select id="jenis_kelamin_edit" name="jenis_kelamin_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="laki-laki">Laki - Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_edit">Alamat</label>
                        <textarea type="text" id="alamat_edit" name="alamat_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" cols="100" rows="4"
                            placeholder="Masukan alamat" required style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="kanan w-1/2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email_edit">Email</label>
                        <input type="text" id="email_edit" name="email_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Masukan email" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_edit">Nomor Whatapp</label>
                        <input type="text" id="no_wa_edit" name="no_wa_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Masukan Nomor Whatapp" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis_akun_edit">Jenis Akun</label>
                        <select id="jenis_akun_edit" name="jenis_akun_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="owner">Owner</option>
                            <option value="admin">Admin</option>
                            <option value="sales">Sales</option>
                        </select>
                    </div>
                </div>
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

<!-- Modal Dialog Ganti kata Sandi akun -->
<div id="dataModalgantisandi" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Ganti Kata Sandi</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalgantisandi').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="dataModalgantisandi" action="/akun-ganti-sandi" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_ganti_sandi" name="id_ganti_sandi" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="sandi">Ganti Kata Sandi</label>
                <input type="text" id="sandi" name="sandi" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Masukan Kata Sandi Baru" required>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalgantisandi').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden');">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                    Ganti Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog Ganti foto akun -->
<div id="dataModalgantifoto" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Ganti Kata Sandi</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalgantifoto').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="dataModalgantifoto" action="/akun-ganti-foto" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id_ganti_foto" name="id_ganti_foto" required>
            </div>

            <div class="mb-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="foto">Foto (PNG, JPG, JPEG)</label>
                    <input type="file" id="foto" name="foto" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalgantifoto').classList.add('hidden'); document.getElementById('daftar-kategori').classList.remove('hidden');">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                    Ganti Foto
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

        <h1>Apakah anda yakin ingin mengubah status data ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/akun-ubah-status" method="POST">
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
            Tambah Data
        </button>
    </div>

    <table class="w-full bg-white border border-gray-200" id="daftar-kategori">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Jenis Akun</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($akun as $item)
            <tr>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->nama}}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->jenis_akun}}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <?php $link_foto = asset('storage/uploads/foto_orang/' . $item->foto) ?>
                    <button onclick="detail('{{ $item->id }}', '{{ $link_foto }}','{{ $item->nama }}','{{ $item->email }}','{{ $item->no_wa}}','{{ $item->jenis_kelamin}}','{{ $item->alamat}}','{{ $item->jenis_akun}}')" class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Detail</button>
                    <button onclick="edit('{{ $item->id }}','{{ $item->nama }}','{{ $item->email }}','{{ $item->no_wa}}','{{ $item->jenis_kelamin}}','{{ $item->alamat}}','{{ $item->jenis_akun}}')" class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
                    <button onclick="password('{{ $item->id }}')" class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Ganti Sandi</button>
                    <button onclick="foto('{{ $item->id }}')" class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Ganti Foto</button>
                    <?php if ($item->status == "aktif") {
                        echo '<button onclick="status(\'' . $item->id . '\')" class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Nonaktifkan</button>';
                    } else {
                        echo '<button onclick="status(\'' . $item->id . '\')" class="px-3 py-1 text-sm text-white bg-green-500 rounded hover:bg-green-600">Aktifkan</button>';
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

    function tambah() {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModaltambah').classList.remove('hidden')
    }

    function detail(id, foto, nama, email, no_wa, jenis_kelamin, alamat, jenis_akun) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModaldetail').classList.remove('hidden')

        let jk = "";

        if (jenis_kelamin == "laki-laki") {
            jk = "Laki-laki";
        } else {
            jk = "Perempuan";
        }

        let ja = "";

        if (jenis_akun == "owner") {
            ja = "Owner";
        } else if (jenis_akun == "admin") {
            ja = "Admin";
        } else {
            ja = "Sales";
        }

        document.getElementById('foto_detail').src = foto
        document.getElementById('id_detail').value = id
        document.getElementById('nama_detail').value = nama
        document.getElementById('email_detail').value = email
        document.getElementById('no_wa_detail').value = no_wa
        document.getElementById('jenis_kelamin_detail').value = jk
        document.getElementById('alamat_detail').value = alamat
        document.getElementById('jenis_akun_detail').value = ja
    }

    function edit(id, nama, email, no_wa, jenis_kelamin, alamat, jenis_akun_id) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModaledit').classList.remove('hidden')

        document.getElementById('id_edit').value = id
        document.getElementById('nama_edit').value = nama
        document.getElementById('email_edit').value = email
        document.getElementById('no_wa_edit').value = no_wa
        document.getElementById('jenis_kelamin_edit').value = jenis_kelamin
        document.getElementById('alamat_edit').value = alamat
        document.getElementById('jenis_akun_edit').value = jenis_akun_id
    }

    function password(id) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModalgantisandi').classList.remove('hidden')
        document.getElementById('id_ganti_sandi').value = id
    }

    function foto(id) {
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModalgantifoto').classList.remove('hidden')
        document.getElementById('id_ganti_foto').value = id
    }

    function status(id) {
        console.log(id);
        document.getElementById('daftar-kategori').classList.add('hidden')
        document.getElementById('dataModalHapus').classList.remove('hidden')
        document.getElementById('id_status').value = id
    }

    function tutup() {
        pesan = document.getElementById("alert");
        pesan.style.display = "none";
    }
</script>
@endsection
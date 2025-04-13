@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Lembur')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Lembur</h2>

<!-- Modal Dialog tambah data -->
<div id="dataModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Lembur Baru</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModal').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="tambah" action="/lembur-tambah" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="judul">Judul</label>
                <input type="text" id="judul" name="judul" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan judul" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
                <div class="max-h-40 overflow-y-auto border border-gray-300 rounded p-2 space-y-2">
                    @foreach($karyawan as $k)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="karyawan_id[]" value="{{ $k->id }}" id="karyawan_{{ $k->id }}" class="text-blue-500 focus:ring-blue-400" onchange="toggleInput('{{ $k->id }}')">
                        <label for="karyawan_{{ $k->id }}" class="text-sm text-gray-700 w-32">{{ $k->nama }}</label>
                        <input type="number" name="uang_lembur[{{ $k->id }}]" id="uang_lembur_{{ $k->id }}" placeholder="Uang lembur" class="border rounded p-1 text-sm w-32" disabled>
                    </div>
                    @endforeach
                </div>
            </div>

            <script>
                function toggleInput(id) {
                    const checkbox = document.getElementById(`karyawan_${id}`);
                    const input = document.getElementById(`uang_lembur_${id}`);
                    const isChecked = checkbox.checked;

                    input.disabled = !isChecked;
                    input.required = isChecked;
                }
            </script>

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

<!-- Modal Dialog detail data -->
<div id="dataModalDetail" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Data Lembur</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModalDetail').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form>
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="detail_judul">Judul</label>
                <input type="text" id="detail_judul" name="detail_judul" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="detail_tgl">Tanggal</label>
                <input type="text" id="detail_tgl" name="detail_tgl" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
                <div class="max-h-40 overflow-y-auto border border-gray-300 rounded p-2 space-y-2">
                    <div id="detail_karyawan"></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalDetail').classList.add('hidden')">
                    Ok
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
                onclick="document.getElementById('dataModalHapus').classList.add('hidden')">
                ✖
            </button>
        </div>

        <h1>Apakah anda yakin ingin menghapus data ini?</h1>

        <!-- Form -->
        <form id="dataModalHapus" action="/lembur-hapus" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" id="id" name="id" required>
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

<!-- Tabel -->
<div class="flex flex-col w-full">
    <!-- Button Tambah -->
    <!-- Button untuk membuka dialog -->
    <div class="flex justify-left my-4">
        <button
            class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600"
            onclick="document.getElementById('dataModal').classList.remove('hidden')">
            Buat Lembur Baru
        </button>
    </div>

    <table class="w-full bg-white border border-gray-200 table-auto" id="daftar-stok">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Judul</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Tanggal</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($lembur as $item)
            <tr class="">
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->judul }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->created_at->format('d-m-Y') }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <button onclick="detail('{{ $item->id }}')" class="mt-2 md:mt-0 px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Detail</button>
                    <button onclick="hapus('{{ $item->id }}')" class="mt-2 md:mt-0 px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                </td>
            </tr>
            <?php $index++; ?>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#daftar-stok').DataTable();
    });

    async function detail(id) {
        try {
            const response = await fetch(`/lembur-detail/${id}`);
            const data = await response.json();

            // Set judul
            document.getElementById('detail_judul').value = data.lembur.judul;

            // Set tanggal
            const rawDate = new Date(data.lembur.created_at);

            const day = String(rawDate.getDate()).padStart(2, '0');
            const month = String(rawDate.getMonth() + 1).padStart(2, '0'); // getMonth() dimulai dari 0
            const year = rawDate.getFullYear();

            const formattedDate = `${day}-${month}-${year}`;

            document.getElementById('detail_tgl').value = formattedDate;

            // Kosongkan elemen sebelumnya
            const detailKaryawan = document.getElementById('detail_karyawan');
            detailKaryawan.innerHTML = '';

            // Tambahkan daftar karyawan
            data.daftarKaryawan.forEach((item, index) => {
                const div = document.createElement('div');
                div.classList.add('flex', 'justify-between', 'items-center', 'bg-gray-100', 'p-2', 'rounded');

                div.innerHTML = `
                    <span>${item.karyawan.nama}</span>
                    <span class="text-sm text-green-600 font-medium">Rp ${item.uang_lembur}</span>
                `;
                detailKaryawan.appendChild(div);
            });

            // Tampilkan modal
            document.getElementById('dataModalDetail').classList.remove('hidden');
        } catch (error) {
            console.error('Gagal mengambil data:', error);
            alert('Terjadi kesalahan saat mengambil data.');

        }
    }

    function hapus(id) {
        document.getElementById('dataModalHapus').classList.remove('hidden')
        document.getElementById('id').value = id
    }

    function tutup() {
        pesan = document.getElementById("alert");
        pesan.style.display = "none";
    }
</script>
@endsection
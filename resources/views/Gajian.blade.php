@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Gajian')

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

<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Gaji Karyawan Bulan Ini</h2>

<!-- Modal Dialog detail data -->
<div id="dataModalDetail" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Data Gaji</h2>
            <button class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('dataModalDetail').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form>
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="detail_judul">Nama</label>
                <input type="text" id="detail_nama" name="detail_nama" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
            </div>

            <div class="flex gap-2">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="detail_judul">Gaji Pokok</label>
                    <input type="text" id="detail_gaji" name="detail_gaji" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="detail_judul">Total Gaji</label>
                    <input type="text" id="detail_total" name="detail_total" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lembur</label>
                <div class="max-h-40 overflow-y-auto border border-gray-300 rounded p-2 space-y-2">
                    <div id="detail_lembur"></div>
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

<!-- Tabel -->
<div class="flex flex-col w-full">
    <table class="w-full bg-white border border-gray-200 table-auto" id="daftar-stok">
        <thead>
            <tr>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Total Gaji</th>
                <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($karyawan as $item)
            <tr class="">
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->nama }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->gaji, 0, ',', '.') }}</td>
                <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">
                    <button onclick="detail('{{ $item->id }}', '{{ $item->gaji }}')" class="mt-2 md:mt-0 px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Detail</button>
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

    async function detail(id, total) {
        try {
            const response = await fetch(`/gajian/${id}`);
            const data = await response.json();

            // Set nama
            document.getElementById('detail_nama').value = data.karyawan.nama;

            // Set gaji
            document.getElementById('detail_gaji').value = data.karyawan.gaji;

            // Set total
            document.getElementById('detail_total').value = total;

            // Kosongkan elemen sebelumnya
            const detailLembur = document.getElementById('detail_lembur');
            detailLembur.innerHTML = '';

            // Tambahkan elemen baru
            data.lemburan.forEach(lemburan => {
                const lemburDiv = document.createElement('div');
                lemburDiv.innerHTML = `
                    <div class="flex justify-between">
                        <span>${lemburan.lembur.judul}</span>
                        <span>${lemburan.uang_lembur}</span>
                    </div>
                `;
                detailLembur.appendChild(lemburDiv);
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
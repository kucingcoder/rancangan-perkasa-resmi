@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Pesanan Detail')

@section('content')
<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Detail Pesanan</h2>

<div class="mt-6 w-full flex flex-col md:flex-row gap-4">
    <div class="w-full md:w-1/2 flex">
        <div class="w-full p-4 rounded-lg bg-grey-100 shadow-lg border border-grey-300 flex-1 h-full">
            <h1 class="text-center text-xl md:text-sm font-bold mb-4">Pembeli</h1>
            <div class="flex flex-col">
                <p>Nama : <span class="font-bold">{{$pembeli->nama}}</span></p>
                <p>Email : <span class="font-bold">{{$pembeli->email}}</span></p>
                <p>No Whatsapp : <span class="font-bold">{{$pembeli->no_wa}}</span></p>
                <p>Alamat : <span class="font-bold">{{$pembeli->alamat}}</span></p>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/2 flex">
        <div class="w-full p-4 rounded-lg bg-grey-100 shadow-lg border border-grey-300 flex-1 h-full">
            <h1 class="text-center text-xl md:text-sm font-bold mb-4">Sales</h1>
            <div class="flex flex-col">
                <p>Nama : <span class="font-bold">{{$sales->nama}}</span></p>
                <p>Email : <span class="font-bold">{{$sales->email}}</span></p>
                <p>No Whatsapp : <span class="font-bold">{{$sales->no_wa}}</span></p>
                <p>Alamat : <span class="font-bold">{{$sales->alamat}}</span></p>
            </div>
        </div>
    </div>
</div>


<h2 class="mt-6 mb-4 text-xl md:text-2xl text-center md:text-left font-bold text-gray-700 mb-2">Daftar Produk</h2>

<table class="w-full bg-white border border-gray-200" id="daftar-produk">
    <thead>
        <tr>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">No</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Nama Produk</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Foto</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Harga</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Jumlah</th>
            <th class="bg-gray-200 border-gray-800 px-4 py-2 text-sm text-gray-600">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php $index = 1; ?>
        @foreach ($daftar_produk as $item)
        <tr class="border-b">
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $index }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ $item->produk->nama }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700"><img src="{{ asset('storage/uploads/foto_produk/' . $item->produk->foto . '.webp') }}" alt="{{ $item->produk->nama_produk }}" class="w-20"></td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->produk->harga, 0, ',', '.') }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{$item->jumlah}} {{ $item->produk->satuan }}</td>
            <td class="border-gray-200 px-4 py-2 text-sm text-gray-700">{{ "Rp. " . number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
        </tr>
        <?php $index++; ?>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    <div class="flex flex-col">
        <div class="flex gap-4 justify-left">
            <button onclick="location.href='/pesanan-masuk/{{$pesanan->id}}/laporan-internal'" class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">Download Laporan Toko</button>
        </div>
    </div>
</div>

<!-- Modal Dialog Buat Pengiriman data -->
<div id="dataModalBuatPengiriman" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Buat Skema Pengiriman</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalBuatPengiriman').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/pesanan-masuk/{{$pesanan->id}}/buat-skema-pengiriman" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_kurir">Nama Kurir</label>
                        <input type="text" id="nama_kurir" name="nama_kurir" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama kurir" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_kurir">No WA Kurir</label>
                        <input type="text" id="no_wa_kurir" name="no_wa_kurir" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan no WA kurir" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="biaya_kirim_id">Wilayah Kirim</label>
                        <select id="biaya_kirim_id" name="biaya_kirim_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Pilih Wilayah Kirim</option>
                            @foreach ($biaya_kirim as $item)
                            <option value="{{ $item->id }}">{{ $item->wilayah }} ({{ "Rp. " . number_format($item->nominal, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="ekspedisi_id">Ekspedisi</label>
                            <select id="ekspedisi_id" name="ekspedisi_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                <option value="" disabled selected>Pilih Ekspedisi</option>
                                @foreach ($ekspedisi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="jumlah_pengiriman">Jumlah Pengiriman</label>
                            <input type="number" id="jumlah_pengiriman" name="jumlah_pengiriman" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah pengiriman" required>
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_kurir">Foto Kurir (PNG, JPG, JPEG)</label>
                        <input type="file" id="foto_kurir" name="foto_kurir" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_tujuan">Alamat Tujuan</label>
                        <textarea name="alamat_tujuan" id="alamat_tujuan" cols="30" rows="8" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{$pembeli->alamat}}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalBuatPengiriman').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@if($pengiriman)
<!-- Modal Dialog Edit Pengiriman data -->
<div id="dataModalEditPengiriman" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Edit Skema Pengiriman</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalEditPengiriman').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/pesanan-masuk/{{$pesanan->id}}/edit-skema-pengiriman" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                <div class="ml-4 flex flex-col">
                </div>
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_kurir_edit">Nama Kurir</label>
                        <input type="text" id="nama_kurir_edit" name="nama_kurir_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan nama kurir" required value="{{ $pengiriman->nama_kurir }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_wa_kurir_edit">No WA Kurir</label>
                        <input type="text" id="no_wa_kurir_edit" name="no_wa_kurir_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan no WA kurir" required value="{{ $pengiriman->no_wa_kurir }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="biaya_kirim_id_edit">Wilayah Kirim</label>
                        <select id="biaya_kirim_id_edit" name="biaya_kirim_id_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required value="{{ $pengiriman->biaya_kirim_id }}">
                            <option value="" disabled>Pilih Wilayah Kirim</option>
                            @foreach ($biaya_kirim as $item)
                            <option value="{{ $item->id }}">{{ $item->wilayah }} ({{ "Rp. " . number_format($item->nominal, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="ekspedisi_id_edit">Ekspedisi</label>
                            <select id="ekspedisi_id_edit" name="ekspedisi_id_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required value="{{ $pengiriman->ekspedisi_id }}">
                                <option value="" disabled>Pilih Ekspedisi</option>
                                @foreach ($ekspedisi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ml-4 mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="jumlah_pengiriman_edit">Jumlah Pengiriman</label>
                            <input type="number" id="jumlah_pengiriman_edit" name="jumlah_pengiriman_edit" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukan jumlah pengiriman" required value="{{ $pengiriman->jumlah_pengiriman }}">
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_kurir_edit">Foto Kurir (PNG, JPG, JPEG)</label>
                        <input type="file" id="foto_kurir_edit" name="foto_kurir_edit" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat_tujuan_edit">Alamat Tujuan</label>
                        <textarea name="alamat_tujuan_edit" id="alamat_tujuan_edit" cols="30" rows="8" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ $pengiriman->alamat_tujuan }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalEditPengiriman').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endif


<!-- Modal Dialog Tolak data -->
<div id="dataModalTolak" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Tolak Pesanan</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalTolak').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/pesanan-masuk/{{$pesanan->id}}/tolak" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="alasan">Alasan</label>
                <textarea name="alasan" id="alasan" cols="30" rows="8" style="resize: none;" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" id="spesifikasi"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalTolak').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog Proses data -->
<div id="dataModalProses" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Proses Pesanan</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalProses').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/pesanan-masuk/{{$pesanan->id}}/proses" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="bukti_pelunasan">Foto Bukti Pembayaran (PNG, JPG, JPEG)</label>
                <input type="file" id="bukti_pelunasan" name="bukti_pelunasan" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalProses').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Proses
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Dialog Selesai data -->
<div id="dataModalSelesai" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-3/6 p-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-lg font-bold text-gray-700">Selesai Pesanan</h2>
            <button
                class="text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('dataModalSelesai').classList.add('hidden')">
                ✖
            </button>
        </div>

        <!-- Form -->
        <form id="edit" action="/pesanan-masuk/{{$pesanan->id}}/selesai" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_bukti">Foto Bukti Pengiriman (PNG, JPG, JPEG)</label>
                <input type="file" id="foto_bukti" name="foto_bukti" accept=".png, .jpg, .jpeg" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="button" class="mx-2 px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onclick="document.getElementById('dataModalSelesai').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="mx-2 px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                    Selesai
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#daftar-produk').DataTable();
    });

    function tutup() {
        const pesan = document.getElementById("alert");
        if (pesan) {
            pesan.style.display = "none";
        }
    }
</script>
@endsection
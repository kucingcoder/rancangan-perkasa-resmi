<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BiayaKirimController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LandingPage;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananMasukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StokController;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingPage::class, 'Ikhtisar']);
Route::get('/ikhtisar', [LandingPage::class, 'Ikhtisar']);
Route::get('/kontak', [LandingPage::class, 'Kontak']);
Route::get('/katalog', [LandingPage::class, 'Katalog']);
Route::get('/katalog/{id}', [LandingPage::class, 'KatalogUser']);
Route::get('/katalog/{id}/{cari}', [LandingPage::class, 'KatalogCari']);
Route::get('/katalog/{id}/produk/{id_produk}', [LandingPage::class, 'KatalogViewProduk']);
Route::get('/jam-kerja', [LandingPage::class, 'JamKerja']);

Route::middleware('NonSesi')->group(
    function () {
        Route::get('/masuk', [MasukController::class, 'index']);
        Route::post('/masuk', [MasukController::class, 'masuk']);
    }
);

Route::middleware('Sesi')->group(
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::get('/keranjang', [KeranjangController::class, 'index']);
        Route::post('/keranjang-hapus', [KeranjangController::class, 'HapusKeranjang']);
        Route::post('/keranjang/pembeli-cari', [KeranjangController::class, 'CariPembeli']);
        Route::post('/keranjang/buat-pembeli-baru', [KeranjangController::class, 'BuatPembeliBaru']);
        Route::post('/keranjang/buat-keranjang', [KeranjangController::class, 'BuatKeranjangBaru']);
        Route::post('/keranjang/simpan-keranjang', [KeranjangController::class, 'SimpanKeranjang']);

        Route::get('/keranjang/kelola/{id}', [KeranjangController::class, 'Kelola']);
        Route::get('/keranjang/kelola/{id}/tambah-produk', [KeranjangController::class, 'TambahProduk']);
        Route::get('/keranjang/kelola/{id}/tambah-produk/cari/{keyword}', [KeranjangController::class, 'TambahProdukCari']);
        Route::get('/keranjang/kelola/{id}/tambah-produk/{item_id}', [KeranjangController::class, 'TambahProdukView']);
        Route::post('/keranjang/kelola/{id}/masukan-produk', [KeranjangController::class, 'MasukanProduk']);
        Route::post('/keranjang/kelola/{id}/edit-produk', [KeranjangController::class, 'EditProduk']);
        Route::post('/keranjang/kelola/{id}/hapus-produk', [KeranjangController::class, 'HapusProduk']);
        Route::get('/keranjang/kelola/{id}/rincian', [KeranjangController::class, 'Rincian']);
        Route::post('/keranjang/kelola/{id}/pesan', [KeranjangController::class, 'Pesan']);

        Route::get('/pesanan', [PesananController::class, 'index']);
        Route::get('/pesanan/cari/{keyword}', [PesananController::class, 'Cari']);
        Route::get('/pesanan/{id}', [PesananController::class, 'detail']);
        Route::get('/pesanan/{id}/daftar-produk', [PesananController::class, 'DaftarProduk']);
        Route::get('/pesanan/{id}/nota-pembeli', [PesananMasukController::class, 'DownloadNotaPembeli']);
        Route::get('/pesanan/{id}/laporan-sales', [PesananMasukController::class, 'DownloadLaporanSales']);

        Route::get('/profil', [ProfilController::class, 'index']);
        Route::post('/profil-edit', [ProfilController::class, 'edit']);
        Route::post('/profil-ganti-sandi', [ProfilController::class, 'GantiSandi']);
        Route::get('/keluar', [KeluarController::class, 'keluar']);
    }
);

Route::middleware('Admin')->group(
    function () {
        Route::get('/pesanan-masuk', [PesananMasukController::class, 'index']);
        Route::get('/pesanan-masuk/cari/{keyword}', [PesananMasukController::class, 'Cari']);
        Route::get('/pesanan-masuk/{id}', [PesananMasukController::class, 'detail']);
        Route::post('/pesanan-masuk/{id}/buat-skema-pengiriman', [PesananMasukController::class, 'BuatSkemaPengiriman']);
        Route::post('/pesanan-masuk/{id}/edit-skema-pengiriman', [PesananMasukController::class, 'EditSkemaPengiriman']);
        Route::get('/pesanan-masuk/{id}/cetak-nota-pembeli', [PesananMasukController::class, 'CetakNotaPembeli']);
        Route::post('/pesanan-masuk/{id}/proses', [PesananMasukController::class, 'Proses']);
        Route::post('/pesanan-masuk/{id}/tolak', [PesananMasukController::class, 'Tolak']);
        Route::get('/pesanan-masuk/{id}/nota-kurir', [PesananMasukController::class, 'DownloadNotaKurir']);
        Route::get('/pesanan-masuk/{id}/laporan-internal', [PesananMasukController::class, 'DownloadLaporanInternal']);
        Route::get('/pesanan-masuk/{id}/kirim', [PesananMasukController::class, 'Kirim']);
        Route::post('/pesanan-masuk/{id}/selesai', [PesananMasukController::class, 'Selesai']);
        Route::get('/pesanan-masuk/{id}/foto-kurir', [PesananMasukController::class, 'DownloadFotoKurir']);
        Route::get('/pesanan-masuk/{id}/foto-bukti-pembayaran', [PesananMasukController::class, 'DownloadBuktiPembayaran']);
        Route::get('/pesanan-masuk/{id}/foto-bukti-pengiriman', [PesananMasukController::class, 'DownloadBuktiPengiriman']);

        Route::get('/stok', [StokController::class, 'index']);
        Route::post('/stok-tambah', [StokController::class, 'tambah']);
        Route::post('/stok-edit', [StokController::class, 'edit']);
        Route::post('/stok-hapus', [StokController::class, 'hapus']);

        Route::get('/produk', [ProdukController::class, 'index']);
        Route::post('/produk-tambah', [ProdukController::class, 'tambah']);
        Route::post('/produk-edit', [ProdukController::class, 'edit']);
        Route::post('/produk-hapus', [ProdukController::class, 'hapus']);

        Route::get('/akun', [AkunController::class, 'index']);
        Route::post('/akun-tambah', [AkunController::class, 'tambah']);
        Route::post('/akun-edit', [AkunController::class, 'edit']);
        Route::post('/akun-ganti-foto', [AkunController::class, 'GantiFoto']);
        Route::post('/akun-ganti-sandi', [AkunController::class, 'GantiSandi']);
        Route::post('/akun-ubah-status', [AkunController::class, 'UbahStatus']);

        Route::get('/karyawan', [KaryawanController::class, 'index']);
        Route::post('/karyawan-tambah', [KaryawanController::class, 'tambah']);
        Route::post('/karyawan-edit', [KaryawanController::class, 'edit']);
        Route::post('/karyawan-ubah-status', [KaryawanController::class, 'UbahStatus']);

        Route::get('/biaya-kirim', [BiayaKirimController::class, 'index']);
        Route::post('/biaya-kirim-tambah', [BiayaKirimController::class, 'tambah']);
        Route::post('/biaya-kirim-edit', [BiayaKirimController::class, 'edit']);
        Route::post('/biaya-kirim-hapus', [BiayaKirimController::class, 'hapus']);

        Route::get('/ekspedisi', [EkspedisiController::class, 'index']);
        Route::post('/ekspedisi-tambah', [EkspedisiController::class, 'tambah']);
        Route::post('/ekspedisi-edit', [EkspedisiController::class, 'edit']);
        Route::post('/ekspedisi-hapus', [EkspedisiController::class, 'hapus']);
    }
);

<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BiayaPengirimanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\ProfilController;
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
        Route::get('/keranjang/kelola/{id}/tambah-barang', [KeranjangController::class, 'TambahBarang']);
        Route::get('/keranjang/kelola/{id}/tambah-barang/{item_id}', [KeranjangController::class, 'TambahBarangViewBarang']);
        Route::post('/keranjang/kelola/{id}/masukan-barang', [KeranjangController::class, 'MasukanBarangBaru']);
        Route::post('/keranjang/kelola/{id}/edit-barang', [KeranjangController::class, 'EditBarangBaru']);
        Route::post('/keranjang/kelola/{id}/hapus-barang', [KeranjangController::class, 'HapusBarangBaru']);
        Route::get('/keranjang/kelola/{id}/rincian', [KeranjangController::class, 'Rincian']);
        Route::get('/keranjang/kelola/{id}/pesan', [KeranjangController::class, 'Pesan']);

        Route::get('/profil', [ProfilController::class, 'index']);
        Route::post('/profil-edit', [ProfilController::class, 'edit']);
        Route::post('/profil-ganti-sandi', [ProfilController::class, 'GantiSandi']);
        Route::get('/keluar', [KeluarController::class, 'keluar']);
    }
);

Route::middleware('Admin')->group(
    function () {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang-tambah', [BarangController::class, 'tambah']);
        Route::post('/barang-edit', [BarangController::class, 'edit']);
        Route::post('/barang-hapus', [BarangController::class, 'hapus']);

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

        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori-tambah', [KategoriController::class, 'tambah']);
        Route::post('/kategori-edit', [KategoriController::class, 'edit']);
        Route::post('/kategori-hapus', [KategoriController::class, 'hapus']);

        Route::get('/biaya-pengiriman', [BiayaPengirimanController::class, 'index']);
        Route::post('/biaya-pengiriman-tambah', [BiayaPengirimanController::class, 'tambah']);
        Route::post('/biaya-pengiriman-edit', [BiayaPengirimanController::class, 'edit']);
        Route::post('/biaya-pengiriman-hapus', [BiayaPengirimanController::class, 'hapus']);

        Route::get('/ekspedisi', [EkspedisiController::class, 'index']);
        Route::post('/ekspedisi-tambah', [EkspedisiController::class, 'tambah']);
        Route::post('/ekspedisi-edit', [EkspedisiController::class, 'edit']);
        Route::post('/ekspedisi-hapus', [EkspedisiController::class, 'hapus']);
    }
);

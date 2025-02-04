<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BiayaPengirimanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\MasukController;
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
        Route::get('/keluar', [KeluarController::class, 'keluar']);
    }
);

Route::middleware('Sesi')->group(
    function () {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang-tambah', [BarangController::class, 'tambah']);
        Route::post('/barang-edit', [BarangController::class, 'edit']);
        Route::post('/barang-hapus', [BarangController::class, 'hapus']);

        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori-tambah', [KategoriController::class, 'tambah']);
        Route::post('/kategori-edit', [KategoriController::class, 'edit']);
        Route::post('/kategori-hapus', [KategoriController::class, 'hapus']);

        Route::get('/biaya-pengiriman', [BiayaPengirimanController::class, 'index']);
        Route::post('/biaya-pengiriman-tambah', [BiayaPengirimanController::class, 'tambah']);
        Route::post('/biaya-pengiriman-edit', [BiayaPengirimanController::class, 'edit']);
        Route::post('/biaya-pengiriman-hapus', [BiayaPengirimanController::class, 'hapus']);
    }
);

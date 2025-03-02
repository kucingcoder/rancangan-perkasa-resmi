<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Produk;
use Illuminate\Http\Request;

class LandingPage extends Controller
{
    public function Ikhtisar()
    {
        return view('Ikhtisar');
    }

    public function Kontak()
    {
        return view('Kontak');
    }

    public function Katalog()
    {
        return redirect('/katalog/6bde6ca2-f0f3-11ef-a016-1063c8e04372');
    }

    public function KatalogUser($id)
    {
        $akun = Akun::where('id', $id)->where('status', 'aktif')->first();

        if (!$akun) {
            return redirect('/katalog/6bde6ca2-f0f3-11ef-a016-1063c8e04372');
        }

        $produk = Produk::where('status', 'aktif')->orderBy('nama', 'asc')->get();

        $data = [
            'id' => $id,
            'akun' => $akun,
            'produk' => $produk
        ];

        return view('Katalog', $data);
    }

    public function KatalogCari($id, $cari)
    {
        $akun = Akun::where('id', $id)->where('status', 'aktif')->first();

        if (!$akun) {
            return redirect('/katalog/6bde6ca2-f0f3-11ef-a016-1063c8e04372');
        }

        $produk = Produk::where('status', 'aktif')
            ->whereRaw("MATCH(nama, deskripsi) AGAINST(? IN NATURAL LANGUAGE MODE)", [$cari])
            ->orderByRaw("MATCH(nama, deskripsi) AGAINST(? IN NATURAL LANGUAGE MODE) DESC", [$cari])
            ->get();

        $data = [
            'id' => $id,
            'akun' => $akun,
            'produk' => $produk
        ];

        return view('Katalog', $data);
    }

    public function KatalogViewProduk($id, $id_produk)
    {
        $akun = Akun::where('id', $id)->where('status', 'aktif')->first();

        if (!$akun) {
            return redirect('/katalog/6bde6ca2-f0f3-11ef-a016-1063c8e04372');
        }

        $produk = Produk::where('id', $id_produk)->where('status', 'aktif')->first();

        $data = [
            'id' => $id,
            'akun' => $akun,
            'produk' => $produk
        ];

        return view('KatalogViewProduk', $data);
    }

    public function JamKerja()
    {
        return view('JamKerja');
    }
}

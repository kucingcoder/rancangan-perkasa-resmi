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

        $produk = Produk::where('status', 'aktif')->get();

        $data = [
            'akun' => $akun,
            'produk' => $produk
        ];

        return view('Katalog', $data);
    }

    public function JamKerja()
    {
        return view('JamKerja');
    }
}

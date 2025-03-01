<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\DaftarProduk;
use App\Models\Pembeli;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $pesanan = Pesanan::with('keranjang')
            ->whereHas('keranjang', function ($query) use ($request) {
                $query->where('akun_id', $request->session()->get('id'));
            })
            ->orderBy('updated_at', 'desc')
            ->get();


        $data = [
            'pesanan' => $pesanan
        ];

        return view('Pesanan', $data);
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with('keranjang')->where('id', $id)->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $pembeli = Pembeli::where('id', $pesanan->keranjang->pembeli_id)->first();
        $sales = Akun::where('id', $pesanan->keranjang->akun_id)->first();

        $data = [
            'pesanan' => $pesanan,
            'pembeli' => $pembeli,
            'sales' => $sales,
        ];

        return view('PesananDetail', $data);
    }

    public function DaftarProduk($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $dafter_produk = DaftarProduk::with('produk')->where('keranjang_id', $pesanan->keranjang_id)->get();

        $data = [
            'daftar_produk' => $dafter_produk,
        ];

        return view('PesananDaftarProduk', $data);
    }
}

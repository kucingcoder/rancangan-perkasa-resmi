<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\BiayaKirim;
use App\Models\DaftarProduk;
use App\Models\Ekspedisi;
use App\Models\Pembeli;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::Where('status', 'selesai')->orderBy('created_at', 'desc')->get();

        $data = [
            'pesanan' => $pesanan
        ];

        return view('Laporan', $data);
    }

    public function cari($keyword)
    {
        $pesanan = Pesanan::where(function ($query) use ($keyword) {
            $search = $keyword;
            if ($search) {
                $query->where('kode_invoice', 'like', '%' . $search . '%')
                    ->orWhereHas('keranjang', function ($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%') // nama keranjang
                            ->orWhereHas('pembeli', function ($qp) use ($search) {
                                $qp->where('nama', 'like', '%' . $search . '%'); // nama pembeli
                            });
                    });
            }
        })
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'pesanan' => $pesanan
        ];

        return view('Laporan', $data);
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with('keranjang')->where('id', $id)->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $dafter_produk = DaftarProduk::where('keranjang_id', $pesanan->keranjang_id)->get();
        $pengiriman = Pengiriman::where('id', $pesanan->pengiriman_id)->first();
        $pembeli = Pembeli::where('id', $pesanan->keranjang->pembeli_id)->first();
        $sales = Akun::where('id', $pesanan->keranjang->akun_id)->first();

        $ekspedisi = Ekspedisi::where('status', 'aktif')->get();
        $biaya_kirim = BiayaKirim::where('status', 'aktif')->get();

        $data = [
            'pesanan' => $pesanan,
            'daftar_produk' => $dafter_produk,
            'pengiriman' => $pengiriman,
            'pembeli' => $pembeli,
            'sales' => $sales,
            'ekspedisi' => $ekspedisi,
            'biaya_kirim' => $biaya_kirim
        ];

        return view('LaporanDetail', $data);
    }

    public function DownloadLaporanInternal($id)
    {
        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['diperiksa', 'diterima', 'ditolak'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->laporan_internal) {
            return back()->withErrors('Laporan internal tidak ditemukan');
        }

        return response()->download(
            storage_path("app/public/uploads/laporan_internal/{$pesanan->laporan_internal}.pdf"),
            "laporan toko - {$pesanan->kode_invoice}_{$pesanan->keranjang->pembeli->nama}_{$pesanan->keranjang->akun->nama}.pdf"
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\DaftarProduk;
use App\Models\Keranjang;
use App\Models\Pembeli;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $sales = $request->session()->get('id');
        $keranjang = Keranjang::where('status', 'aktif')
            ->where('akun_id', $sales)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'keranjang' => $keranjang
        ];

        return view('Keranjang', $data);
    }

    public function Cari(Request $request, $keyword)
    {
        $sales = $request->session()->get('id');

        $keranjang = Keranjang::where('akun_id', $sales)
            ->where('status', 'aktif')
            ->where(function ($query) use ($keyword) {
                $query->where('judul', 'like', '%' . $keyword . '%')
                    ->orWhereHas('pembeli', function ($q) use ($keyword) {
                        $q->where('nama', 'like', '%' . $keyword . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'keranjang' => $keranjang
        ];

        return view('Keranjang', $data);
    }

    public function CariPembeli(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required',
        ]);

        $keyword = $request->input('nama_pembeli');

        $pembeli = Pembeli::whereRaw("MATCH(nama) AGAINST(? IN NATURAL LANGUAGE MODE)", [$keyword])
            ->orderByRaw("MATCH(nama) AGAINST(? IN NATURAL LANGUAGE MODE) DESC", [$keyword])
            ->get();

        $data = [
            'pembeli' => $pembeli,
        ];

        return view('KeranjangCariPembeli', $data);
    }

    public function BuatPembeliBaru(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required',
            'alamat' => 'required',
            'no_wa' => 'required',
        ]);

        $pembeli = new Pembeli();
        $pembeli->nama = $request->input('nama_pembeli');
        $pembeli->alamat = $request->input('alamat');
        $pembeli->no_wa = $request->input('no_wa');

        if ($request->input('email')) {
            $pembeli->email = $request->input('email');
        }

        try {
            $pembeli->save();

            $data = [
                'pembeli' => $pembeli
            ];

            return view('KeranjangBuatKeranjang', $data);
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function BuatKeranjangBaru(Request $request)
    {
        $request->validate([
            'id_pembeli' => 'required',
        ]);

        $pembeli = Pembeli::where('id', $request->input('id_pembeli'))->first();

        if ($pembeli) {
            $data = [
                'pembeli' => $pembeli
            ];

            return view('KeranjangBuatKeranjang', $data);
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function SimpanKeranjang(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'judul' => 'required',
        ]);

        $pembeli_id = $request->input('id');
        $judul = $request->input('judul');
        $sales = $request->session()->get('id');

        $keranjang = new Keranjang();
        $keranjang->judul = $judul;
        $keranjang->akun_id = $sales;
        $keranjang->pembeli_id = $pembeli_id;

        try {
            $keranjang->save();

            return redirect('/keranjang');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function HapusKeranjang(Request $request)
    {
        $request->validate([
            'id_hapus' => 'required',
        ]);

        $id = $request->input('id_hapus');

        $keranjang = Keranjang::where('id', $id)->where('status', 'aktif')->first();

        if (!$keranjang) {
            return back()->withErrors('Keranjang tidak ditemukan');
        }

        try {
            DaftarProduk::where('keranjang_id', $id)->delete();
            $keranjang->delete();

            return back()->with('success', 'Keranjang ' . $keranjang->judul . ' berhasil dihapus');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function Kelola($id)
    {
        $daftar_produk = DaftarProduk::with('produk')
            ->with('produk.stok')
            ->where('keranjang_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'daftar_produk' => $daftar_produk,
            'id' => $id,
        ];
        return view('KeranjangKelola', $data);
    }

    public function TambahProduk($id)
    {
        $produk = Produk::where('status', 'aktif')->orderBy('nama', 'asc')->get();

        $data = [
            'produk' => $produk,
            'id' => $id
        ];

        return view('KeranjangTambahProduk', $data);
    }

    public function TambahProdukCari($id, $keyword)
    {
        $produk = Produk::where('status', 'aktif')
            ->where(function ($query) use ($keyword) {
                $query->whereRaw("MATCH(nama, deskripsi) AGAINST(? IN NATURAL LANGUAGE MODE)", [$keyword])
                    ->orWhere('nama', 'LIKE', "%$keyword%")
                    ->orWhere('deskripsi', 'LIKE', "%$keyword%");
            })
            ->orderByRaw("MATCH(nama, deskripsi) AGAINST(? IN NATURAL LANGUAGE MODE) DESC", [$keyword])
            ->get();

        $data = [
            'produk' => $produk,
            'id' => $id
        ];

        return view('KeranjangTambahProduk', $data);
    }

    public function TambahProdukView($id, $item_id)
    {
        $produk = Produk::with('stok')->where('id', $item_id)->first();

        $data = [
            'produk' => $produk,
            'id' => $id,
            'item_id' => $item_id
        ];

        return view('KeranjangTambahProdukView', $data);
    }

    public function MasukanProduk(Request $request)
    {
        $request->validate([
            'id_keranjang' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        $id_keranjang = $request->input('id_keranjang');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');

        $cek_keranjang = Keranjang::where('id', $id_keranjang)->where('status', 'aktif')->first();

        if (!$cek_keranjang) {
            return back()->withErrors('Keranjang tidak ditemukan');
        }

        $daftar_sudah_ada = DaftarProduk::where('keranjang_id', $id_keranjang)
            ->where('produk_id', $id_produk)
            ->first();

        $daftar = null;

        if ($daftar_sudah_ada) {
            $daftar = $daftar_sudah_ada;
            $daftar->jumlah = $daftar_sudah_ada->jumlah + $jumlah;
        } else {
            $daftar = new DaftarProduk();
            $daftar->jumlah = $jumlah;
        }

        $produk = Produk::where('id', $id_produk)->first();

        if (!$produk) {
            return back()->withErrors('Produk tidak ditemukan');
        }

        if ($daftar->jumlah < 1) {
            return back()->withErrors('Minimum jumlah produk adalah 1');
        }

        if (floor($produk->stok->jumlah / $produk->isi) < $daftar->jumlah) {
            return back()->withErrors('Stok produk tidak mencukupi');
        }

        $daftar->keranjang_id = $id_keranjang;
        $daftar->produk_id = $id_produk;
        $daftar->updated_at = now();

        $keranjang = Keranjang::where('id', $id_keranjang)->first();
        $keranjang->updated_at = now();

        try {
            $daftar->save();
            $keranjang->save();
            return redirect('/keranjang/kelola/' . $id_keranjang);
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Produk ' . $produk->nama . ' gagal ditambahkan');
        }
    }

    public function EditProduk(Request $request)
    {
        $request->validate([
            'id_keranjang' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        $id_keranjang = $request->input('id_keranjang');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');

        $cek_keranjang = Keranjang::where('id', $id_keranjang)->where('status', 'aktif')->first();

        if (!$cek_keranjang) {
            return back()->withErrors('Keranjang tidak ditemukan');
        }

        $daftar = DaftarProduk::where('keranjang_id', $id_keranjang)
            ->where('produk_id', $id_produk)
            ->first();

        if (!$daftar) {
            return back()->withErrors('Produk tidak ditemukan');
        }

        $daftar->jumlah = $jumlah;

        $produk = Produk::where('id', $id_produk)->first();

        if (!$produk) {
            return back()->withErrors('Produk tidak ditemukan');
        }

        if ($daftar->jumlah < 1) {
            return back()->withErrors('Minimum jumlah produk adalah 1');
        }

        if (floor($produk->stok->jumlah / $produk->isi) < $daftar->jumlah) {
            return back()->withErrors('Stok produk tidak mencukupi');
        }

        $daftar->updated_at = now();

        $keranjang = Keranjang::where('id', $id_keranjang)->first();
        $keranjang->updated_at = now();

        try {
            $daftar->save();
            $keranjang->save();
            return back()->with('success', 'Produk ' . $daftar->produk->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Produk ' . $daftar->produk->nama . ' tidak diubah');
        }
    }

    public function HapusProduk(Request $request)
    {
        $request->validate([
            'id_keranjang_hapus' => 'required',
            'id_produk_hapus' => 'required',
        ]);

        $id_keranjang = $request->input('id_keranjang_hapus');
        $id_produk = $request->input('id_produk_hapus');

        $cek_keranjang = Keranjang::where('id', $id_keranjang)->where('status', 'aktif')->first();

        if (!$cek_keranjang) {
            return back()->withErrors('Keranjang tidak ditemukan');
        }

        $daftar = DaftarProduk::where('keranjang_id', $id_keranjang)
            ->where('produk_id', $id_produk)
            ->first();

        if (!$daftar) {
            return back()->withErrors('Produk tidak ditemukan');
        }

        $keranjang = Keranjang::where('id', $id_keranjang)->first();
        $keranjang->updated_at = now();

        try {
            $daftar->delete();
            $keranjang->save();
            return back()->with('success', 'Produk ' . $daftar->produk->nama . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Produk ' . $daftar->produk->nama . ' tidak dihapus');
        }
    }

    public function Rincian($id)
    {
        $keranjang = Keranjang::where('id', $id)->first();

        $sales = Akun::where('id', $keranjang->akun_id)->first();
        $pembeli = Pembeli::where('id', $keranjang->pembeli_id)->first();

        $daftar_produk = DaftarProduk::with('produk')
            ->where('keranjang_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $nama = md5(now());

        $data = [
            'daftar_produk' => $daftar_produk,
            'sales' => $sales,
            'pembeli' => $pembeli
        ];

        $pdf = PDF::loadView('RincianKeranjang', $data)->setPaper('a6', 'portrait');

        return $pdf->download($nama . '.pdf');
    }

    private function getNextCode($code)
    {
        preg_match('/([A-Z]{3})(\d{3})/', $code, $matches);
        $letters = $matches[1];
        $numbers = intval($matches[2]);

        if ($numbers < 999) {
            $numbers++;
        } else {
            $numbers = 1;
            $letters = $this->incrementLetters($letters);
        }

        return $letters . str_pad($numbers, 3, '0', STR_PAD_LEFT);
    }

    private function incrementLetters($letters)
    {
        for ($i = 2; $i >= 0; $i--) {
            if ($letters[$i] !== 'Z') {
                $letters[$i] = chr(ord($letters[$i]) + 1);
                return $letters;
            } else {
                $letters[$i] = 'A';
            }
        }
        return $letters;
    }

    public function Pesan($id)
    {
        $daftar_produk = DaftarProduk::with('produk')
            ->with('produk.stok')
            ->where('keranjang_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $biaya_sales = 0;

        foreach ($daftar_produk as $item) {
            $biaya_sales += $item->jumlah * $item->produk->biaya_sales;
        }

        $keranjang = Keranjang::where('id', $id)->first();
        $keranjang->status = 'nonaktif';
        $keranjang->updated_at = now();

        $lastInvoice = Pesanan::latest()->first();
        $lastCode = $lastInvoice ? $lastInvoice->kode_invoice : 'AAA000';

        $newCode = $this->getNextCode($lastCode);

        $pesanan = new Pesanan();
        $pesanan->keranjang_id = $id;
        $pesanan->biaya_sales = $biaya_sales;
        $pesanan->kode_invoice = $newCode;

        try {
            $pesanan->save();
            $keranjang->save();
            return redirect('/pesanan');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Pesanan tidak dibuat');
        }
    }
}

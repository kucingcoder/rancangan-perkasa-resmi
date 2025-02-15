<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DaftarBarang;
use App\Models\Keranjang;
use App\Models\Pembeli;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $sales = $request->session()->get('id');
        $keranjang = Keranjang::where('status', 'belum dipesan')
            ->where('akun_id', $sales)
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

        $keranjang = Keranjang::where('id', $id)->first();

        if (!$keranjang) {
            return back()->withErrors('Keranjang tidak ditemukan');
        }

        try {
            DaftarBarang::where('keranjang_id', $id)->delete();
            $keranjang->delete();

            return back()->with('success', 'Keranjang dihapus');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function Kelola($id)
    {
        $daftar_barang = DaftarBarang::with('barang')
            ->with('barang.kategori')
            ->where('keranjang_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'daftar_barang' => $daftar_barang,
            'id' => $id,
        ];
        return view('KeranjangKelola', $data);
    }

    public function TambahBarang($id)
    {
        $barang = Barang::where('status', 'aktif')->orderBy('nama_barang', 'asc')->get();

        $data = [
            'barang' => $barang,
            'id' => $id
        ];

        return view('KeranjangTambahBarang', $data);
    }

    public function TambahBarangViewBarang($id, $item_id)
    {
        $barang = Barang::with('kategori')->where('id', $item_id)->first();

        $data = [
            'barang' => $barang,
            'id' => $id,
            'item_id' => $item_id
        ];

        return view('KeranjangTambahBarangViewBarang', $data);
    }

    public function MasukanBarangBaru(Request $request)
    {
        $request->validate([
            'id_keranjang' => 'required',
            'id_barang' => 'required',
            'jumlah' => 'required',
        ]);

        $id_keranjang = $request->input('id_keranjang');
        $id_barang = $request->input('id_barang');
        $jumlah = $request->input('jumlah');

        $daftar_sudah_ada = DaftarBarang::where('keranjang_id', $request->input('id_keranjang'))
            ->where('barang_id', $request->input('id_barang'))
            ->first();

        $daftar = null;

        if ($daftar_sudah_ada) {
            $daftar = $daftar_sudah_ada;
            $daftar->jumlah = $daftar_sudah_ada->jumlah + $jumlah;
        } else {
            $daftar = new DaftarBarang();
            $daftar->jumlah = $jumlah;
        }

        $barang = Barang::where('id', $request->input('id_barang'))->first();
        if ($barang->stok < $daftar->jumlah) {
            return back()->withErrors('Stok barang tidak mencukupi');
        }

        $daftar->keranjang_id = $id_keranjang;
        $daftar->barang_id = $id_barang;
        $daftar->updated_at = now();

        $keranjang = Keranjang::where('id', $id_keranjang)->first();
        $keranjang->updated_at = now();

        try {
            $daftar->save();
            $keranjang->save();
            return redirect('/keranjang/kelola/' . $id_keranjang);
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Barang tidak ditambahkan');
        }
    }

    public function EditBarangBaru(Request $request)
    {
        $request->validate([
            'id_keranjang' => 'required',
            'id_barang' => 'required',
            'jumlah' => 'required',
        ]);

        $id_keranjang = $request->input('id_keranjang');
        $id_barang = $request->input('id_barang');
        $jumlah = $request->input('jumlah');

        $daftar = DaftarBarang::where('keranjang_id', $id_keranjang)
            ->where('barang_id', $id_barang)
            ->first();

        if (!$daftar) {
            return back()->withErrors('Barang tidak ditemukan');
        }

        $daftar->jumlah = $jumlah;

        $barang = Barang::where('id', $id_barang)->first();
        if ($barang->stok < $daftar->jumlah) {
            return back()->withErrors('Stok barang tidak mencukupi');
        }

        $daftar->updated_at = now();

        $keranjang = Keranjang::where('id', $id_keranjang)->first();
        $keranjang->updated_at = now();

        try {
            $daftar->save();
            $keranjang->save();
            return back()->with('success', 'Barang diubah');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Barang tidak diubah');
        }
    }

    public function HapusBarangBaru(Request $request)
    {
        $request->validate([
            'id_keranjang_hapus' => 'required',
            'id_barang_hapus' => 'required',
        ]);

        $id_keranjang = $request->input('id_keranjang_hapus');
        $id_barang = $request->input('id_barang_hapus');

        $daftar = DaftarBarang::where('keranjang_id', $id_keranjang)
            ->where('barang_id', $id_barang)
            ->first();

        if (!$daftar) {
            return back()->withErrors('Barang tidak ditemukan');
        }

        $keranjang = Keranjang::where('id', $id_keranjang)->first();
        $keranjang->updated_at = now();

        try {
            $daftar->delete();
            $keranjang->save();
            return back()->with('success', 'Barang dihapus');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Barang tidak dihapus');
        }
    }

    public function Rincian($id)
    {
        $daftar_barang = DaftarBarang::with('barang')
            ->with('barang.kategori')
            ->where('keranjang_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $pdf = Pdf::loadview('RincianKeranjang', ['daftar_barang' => $daftar_barang]);
        $pdf->setPaper('A4', 'portrait');
        $nama = md5(now());

        return $pdf->download($nama . '.pdf');

        // $data = [
        //     'daftar_barang' => $daftar_barang,
        // ];

        // return view('RincianKeranjang', $data);
    }

    public function Pesan($id)
    {
        $daftar_barang = DaftarBarang::with('barang')
            ->with('barang.kategori')
            ->where('keranjang_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $biaya_sales = 0;

        foreach ($daftar_barang as $item) {
            $biaya_sales += $item->jumlah * $item->barang->kategori->biaya_sales;
        }

        $keranjang = Keranjang::where('id', $id)->first();
        $keranjang->status = 'dipesan';
        $keranjang->updated_at = now();

        $pesanan = new Pesanan();
        $pesanan->keranjang_id = $id;
        $pesanan->biaya_sales = $biaya_sales;

        try {
            $pesanan->save();
            $keranjang->save();
            return back()->with('success', 'Keranjang dipesan');
        } catch (\Throwable $th) {
            Log::error('KeranjangController : ' . $th);
            return back()->withErrors('Pesanan tidak dibuat');
        }
    }
}

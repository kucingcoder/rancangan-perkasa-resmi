<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::where('status', 'aktif')->orderBy('nama_kategori', 'asc')->get();

        $data = [
            'kategori' => $kategori,
        ];

        return view('Kategori', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'satuan' => 'required',
            'spesifikasi' => 'required',
            'biaya_sales' => 'required',
        ]);

        $cek_kategori = Kategori::where('nama_kategori', $request->input('nama_kategori'))->where('status', 'aktif')->first();

        if ($cek_kategori) {
            return back()->withErrors('Kategori sudah ada');
        }

        $nama_kategori = $request->input('nama_kategori');
        $satuan = $request->input('satuan');
        $spesifikasi = $request->input('spesifikasi');
        $biaya_sales = $request->input('biaya_sales');

        $kategoribaru = new Kategori();
        $kategoribaru->nama_kategori = $nama_kategori;
        $kategoribaru->spesifikasi = $spesifikasi;
        $kategoribaru->satuan = $satuan;
        $kategoribaru->biaya_sales = $biaya_sales;

        try {
            $kategoribaru->save();
            return back()->with('success', 'Kategori ' . $kategoribaru->nama_kategori . ' tersimpan');
        } catch (\Throwable $th) {
            Log::error('KategoriController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_kategori_edit' => 'required',
            'satuan_edit' => 'required',
            'spesifikasi_edit' => 'required',
            'biaya_sales_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $nama_kategori = $request->input('nama_kategori_edit');
        $satuan = $request->input('satuan_edit');
        $spesifikasi = $request->input('spesifikasi_edit');
        $biaya_sales = $request->input('biaya_sales_edit');

        $kategori = Kategori::where('id', $id)->first();

        if (!$kategori) {
            return back()->withErrors('Kategori tidak ditemukan');
        }

        $kategori->nama_kategori = $nama_kategori;
        $kategori->satuan = $satuan;
        $kategori->spesifikasi = $spesifikasi;
        $kategori->biaya_sales = $biaya_sales;

        try {
            $kategori->save();
            return back()->with('success', 'Kategori ' . $kategori->nama_kategori . ' diubah');
        } catch (\Throwable $th) {
            Log::error('KategoriController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id_hapus');
        $kategori = Kategori::where('id', $id)->first();

        if (!$kategori) {
            return back()->withErrors('Kategori tidak ditemukan');
        }

        $kategori->status = 'nonaktif';
        $kategori->updated_at = now();

        try {
            $kategori->save();
            return back()->with('success', 'Kategori ' . $kategori->nama_kategori . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('KategoriController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

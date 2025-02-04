<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        $data = [
            'kategori' => $kategori,
        ];

        return view('Kategori', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'ukuran' => 'required',
            'satuan' => 'required',
            'biaya_sales' => 'required',
        ]);

        $nama_kategori = $request->input('nama_kategori');
        $ukuran = $request->input('ukuran');
        $satuan = $request->input('satuan');
        $biaya_sales = $request->input('biaya_sales');

        $kategoribaru = new Kategori();
        $kategoribaru->nama_kategori = $nama_kategori;
        $kategoribaru->ukuran = $ukuran;
        $kategoribaru->satuan = $satuan;
        $kategoribaru->biaya_sales = $biaya_sales;

        try {
            $kategoribaru->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_kategori_edit' => 'required',
            'ukuran_edit' => 'required',
            'satuan_edit' => 'required',
            'biaya_sales_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $nama_kategori = $request->input('nama_kategori_edit');
        $ukuran = $request->input('ukuran_edit');
        $satuan = $request->input('satuan_edit');
        $biaya_sales = $request->input('biaya_sales_edit');

        $kategori = Kategori::where('id', $id)->first();

        if (!$kategori) {
            return back()->withErrors('Kategori tidak ditemukan');
        }

        $kategori->nama_kategori = $nama_kategori;
        $kategori->ukuran = $ukuran;
        $kategori->satuan = $satuan;
        $kategori->biaya_sales = $biaya_sales;

        try {
            $kategori->save();
            return back();
        } catch (\Throwable $th) {
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

        if ($kategori->delete()) {
            return back();
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

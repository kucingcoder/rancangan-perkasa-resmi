<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::where('status', 'aktif')->get();

        $data = [
            'stok' => $stok
        ];

        return view('Stok', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
        ]);

        $cek_stok = Stok::where('nama', $request->input('nama'))->where('status', 'aktif')->first();

        if ($cek_stok) {
            return back()->withErrors('Stok sudah ada');
        }

        $nama = $request->input('nama');
        $jumlah = $request->input('jumlah');
        $satuan = $request->input('satuan');

        $stokbaru = new Stok();
        $stokbaru->nama = $nama;
        $stokbaru->jumlah = $jumlah;
        $stokbaru->satuan = $satuan;

        try {
            $stokbaru->save();
            return back()->with('success', 'Stok ' . $stokbaru->nama . ' tersimpan');
        } catch (\Throwable $th) {
            Log::error('StokController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_edit' => 'required',
            'jumlah_edit' => 'required',
            'satuan_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $nama = $request->input('nama_edit');
        $jumlah = $request->input('jumlah_edit');
        $satuan = $request->input('satuan_edit');

        $stok = Stok::where('id', $id)->first();

        if (!$stok) {
            return back()->withErrors('Stok tidak ditemukan');
        }

        $stok->nama = $nama;
        $stok->jumlah = $jumlah;
        $stok->satuan = $satuan;
        $stok->updated_at = now();

        try {
            $stok->save();
            return back()->with('success', 'Stok ' . $stok->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('StokController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id_hapus');
        $stok = Stok::where('id', $id)->first();

        if (!$stok) {
            return back()->withErrors('Stok tidak ditemukan');
        }

        $stok->status = 'nonaktif';
        $stok->updated_at = now();

        try {
            $stok->save();
            return back()->with('success', 'Stok ' . $stok->nama . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('StokController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

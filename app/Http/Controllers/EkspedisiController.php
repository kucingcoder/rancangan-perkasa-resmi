<?php

namespace App\Http\Controllers;

use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EkspedisiController extends Controller
{
    public function index()
    {
        $ekspedisi = Ekspedisi::where('status', 'aktif')->orderBy('nama', 'asc')->get();

        $data = [
            'ekspedisi' => $ekspedisi
        ];
        return view('Ekspedisi', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_ekspedisi' => 'required',
        ]);

        $nama = $request->input('nama_ekspedisi');

        $ekspedisi = Ekspedisi::where('nama', $nama)->where('status', 'aktif')->first();

        if ($ekspedisi) {
            return back()->withErrors('Ekspedisi ' . $ekspedisi->nama . ' sudah ada');
        }

        $ekspedisibaru = new Ekspedisi();
        $ekspedisibaru->nama = $nama;

        try {
            $ekspedisibaru->save();
            return back()->with('success', 'Barang ' . $ekspedisibaru->nama . ' tersimpan');
        } catch (\Throwable $th) {
            Log::error('EkspedisiController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $nama = $request->input('nama_edit');

        $ekspedisi = Ekspedisi::where('id', $id)->first();

        if (!$ekspedisi) {
            return back()->withErrors('Ekspedisi tidak ditemukan');
        }

        $ekspedisi->nama = $nama;
        $ekspedisi->updated_at = now();

        try {
            $ekspedisi->save();
            return back()->with('success', 'Ekspedisi ' . $ekspedisi->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('EkspedisiController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->input('id_hapus');
        $ekspedisi = Ekspedisi::where('id', $id)->first();

        if (!$ekspedisi) {
            return back()->withErrors('Ekspedisi tidak ditemukan');
        }

        $ekspedisi->status = 'nonaktif';
        $ekspedisi->updated_at = now();

        try {
            $ekspedisi->save();
            return back()->with('success', 'Ekspedisi ' . $ekspedisi->nama . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('EkspedisiController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

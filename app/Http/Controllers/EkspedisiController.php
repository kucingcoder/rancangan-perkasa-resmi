<?php

namespace App\Http\Controllers;

use App\Models\Ekspedisi;
use Illuminate\Http\Request;

class EkspedisiController extends Controller
{
    public function index()
    {
        $ekspedisi = Ekspedisi::all();

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

        $ekspedisibaru = new Ekspedisi();
        $ekspedisibaru->nama = $nama;

        try {
            $ekspedisibaru->save();
            return back();
        } catch (\Throwable $th) {
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

        try {
            $ekspedisi->save();
            return back();
        } catch (\Throwable $th) {
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

        if ($ekspedisi->delete()) {
            return back();
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

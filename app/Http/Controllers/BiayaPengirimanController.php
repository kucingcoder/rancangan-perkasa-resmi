<?php

namespace App\Http\Controllers;

use App\Models\BiayaPengiriman;
use Illuminate\Http\Request;

class BiayaPengirimanController extends Controller
{
    function index()
    {
        $biayaPengiriman = BiayaPengiriman::all();

        $data = [
            'biayaPengiriman' => $biayaPengiriman,
        ];

        return view('BiayaPengiriman', $data);
    }

    public function tambah(Request $request)
    {
        request()->validate([
            'wilayah' => 'required',
            'nominal' => 'required',
        ]);

        $wilayah = $request->input('wilayah');
        $nominal = $request->input('nominal');

        $Biaya_Pengiriman = new BiayaPengiriman();
        $Biaya_Pengiriman->wilayah = $wilayah;
        $Biaya_Pengiriman->nominal = $nominal;

        try {
            $Biaya_Pengiriman->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'wilayah_edit' => 'required',
            'nominal_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $wilayah = $request->input('wilayah_edit');
        $nominal = $request->input('nominal_edit');

        $biayaPengiriman = BiayaPengiriman::where('id', $id)->first();

        if (!$biayaPengiriman) {
            return back()->withErrors('Biaya Pengiriman tidak ditemukan');
        }

        $biayaPengiriman->wilayah = $wilayah;
        $biayaPengiriman->nominal = $nominal;

        try {
            $biayaPengiriman->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id_hapus' => 'required',
        ]);

        $id = $request->input('id_hapus');
        $biayaPengiriman = BiayaPengiriman::where('id', $id)->first();

        if (!$biayaPengiriman) {
            return back()->withErrors('Biaya Pengiriman tidak ditemukan');
        }

        if ($biayaPengiriman->delete()) {
            return back();
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

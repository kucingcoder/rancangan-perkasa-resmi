<?php

namespace App\Http\Controllers;

use App\Models\BiayaPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BiayaPengirimanController extends Controller
{
    function index()
    {
        $biayaPengiriman = BiayaPengiriman::where('status', 'aktif')->orderBy('wilayah', 'asc')->get();

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

        $biayaPengiriman = BiayaPengiriman::where('wilayah', $wilayah)->where('status', 'aktif')->first();

        if ($biayaPengiriman) {
            return back()->withErrors('Wilayah ' . $biayaPengiriman->wilayah . ' sudah ada');
        }

        $Biaya_Pengiriman = new BiayaPengiriman();
        $Biaya_Pengiriman->wilayah = $wilayah;
        $Biaya_Pengiriman->nominal = $nominal;

        try {
            $Biaya_Pengiriman->save();
            return back()->with('success', 'Biaya Pengiriman ' . $Biaya_Pengiriman->wilayah . ' tersimpan');
        } catch (\Throwable $th) {
            Log::error('BiayaPengirimanController : ' . $th);
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
        $biayaPengiriman->updated_at = now();

        try {
            $biayaPengiriman->save();
            return back()->with('success', 'Biaya Pengiriman ' . $biayaPengiriman->wilayah . ' diubah');
        } catch (\Throwable $th) {
            Log::error('BiayaPengirimanController : ' . $th);
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

        $biayaPengiriman->status = 'nonaktif';
        $biayaPengiriman->updated_at = now();

        try {
            $biayaPengiriman->save();
            return back()->with('success', 'Biaya Pengiriman ' . $biayaPengiriman->wilayah . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('BiayaPengirimanController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

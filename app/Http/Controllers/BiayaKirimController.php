<?php

namespace App\Http\Controllers;

use App\Models\BiayaKirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BiayaKirimController extends Controller
{
    public function index()
    {
        $BiayaKirim = BiayaKirim::where('status', 'aktif')->orderBy('wilayah', 'asc')->get();

        $data = [
            'BiayaKirim' => $BiayaKirim,
        ];

        return view('BiayaKirim', $data);
    }

    public function tambah(Request $request)
    {
        request()->validate([
            'wilayah' => 'required',
            'nominal' => 'required',
        ]);

        $wilayah = $request->input('wilayah');
        $nominal = $request->input('nominal');

        $cek_wilayah = BiayaKirim::where('wilayah', $wilayah)->where('status', 'aktif')->first();

        if ($cek_wilayah) {
            return back()->withErrors('Wilayah ' . $cek_wilayah->wilayah . ' sudah ada');
        }

        $Biaya_Kirim = new BiayaKirim();
        $Biaya_Kirim->wilayah = $wilayah;
        $Biaya_Kirim->nominal = $nominal;

        try {
            $Biaya_Kirim->save();
            return back()->with('success', 'Biaya Kirim ' . $Biaya_Kirim->wilayah . ' tersimpan');
        } catch (\Throwable $th) {
            Log::error('BiayaKirimController : ' . $th);
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

        $Biaya_Kirim = BiayaKirim::where('id', $id)->first();

        if (!$Biaya_Kirim) {
            return back()->withErrors('Biaya Kirim tidak ditemukan');
        }

        $Biaya_Kirim->wilayah = $wilayah;
        $Biaya_Kirim->nominal = $nominal;
        $Biaya_Kirim->updated_at = now();

        try {
            $Biaya_Kirim->save();
            return back()->with('success', 'Biaya Kirim ' . $Biaya_Kirim->wilayah . ' diubah');
        } catch (\Throwable $th) {
            Log::error('BiayaKirimController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id_hapus' => 'required',
        ]);

        $id = $request->input('id_hapus');
        $Biaya_Kirim = BiayaKirim::where('id', $id)->first();

        if (!$Biaya_Kirim) {
            return back()->withErrors('Biaya Kirim tidak ditemukan');
        }

        $Biaya_Kirim->status = 'nonaktif';
        $Biaya_Kirim->updated_at = now();

        try {
            $Biaya_Kirim->save();
            return back()->with('success', 'Biaya Kirim ' . $Biaya_Kirim->wilayah . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('BiayaKirimController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

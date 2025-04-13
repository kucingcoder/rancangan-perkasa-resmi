<?php

namespace App\Http\Controllers;

use App\Models\DaftarKaryawan;
use App\Models\Karyawan;

class GajianController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();

        foreach ($karyawan as $k) {
            $lemburan = DaftarKaryawan::where('karyawan_id', $k->id)
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->get();

            foreach ($lemburan as $l) {
                $k->gaji += $l->uang_lembur;
            }
        }

        $data = [
            'karyawan' => $karyawan
        ];

        return view('Gajian', $data);
    }

    public function detail($id)
    {
        $karyawan = Karyawan::find($id);
        $lemburan = DaftarKaryawan::with('lembur')->where('karyawan_id', $karyawan->id)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();

        $data = [
            'karyawan' => $karyawan,
            'lemburan' => $lemburan
        ];

        return response()->json($data);
    }
}

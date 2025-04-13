<?php

namespace App\Http\Controllers;

use App\Models\DaftarKaryawan;
use App\Models\Karyawan;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LemburController extends Controller
{
    public function index()
    {
        $lemburs = Lembur::all();
        $karyawan = Karyawan::all();

        $data = [
            'lembur' => $lemburs,
            'karyawan' => $karyawan
        ];

        return view('Lembur', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'karyawan_id' => 'required|array',
        ]);

        try {
            $judul = $request->input('judul');

            $lembur = new Lembur();
            $lembur->judul = $judul;
            $lembur->save();

            foreach ($request->karyawan_id as $idKaryawan) {
                $uangLembur = $request->input("uang_lembur")[$idKaryawan] ?? 0;

                $daftarKaryawan = new DaftarKaryawan();
                $daftarKaryawan->karyawan_id = $idKaryawan;
                $daftarKaryawan->lembur_id = $lembur->id;
                $daftarKaryawan->uang_lembur = $uangLembur;
                $daftarKaryawan->save();
            }

            return back()->with('success', 'Lembur ' . $judul . ' berhasil dibuat');
        } catch (\Throwable $th) {
            Log::error('LemburController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function detail($id)
    {
        $lembur = Lembur::where('id', $id)->first();

        if (!$lembur) {
            return back()->with('error', 'Lembur tidak ditemukan');
        }

        $daftarKaryawan = DaftarKaryawan::with('karyawan')->where('lembur_id', $id)->get();

        $data = [
            'lembur' => $lembur,
            'daftarKaryawan' => $daftarKaryawan
        ];

        return response()->json($data);
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        try {
            $id = $request->input('id');
            $lembur = Lembur::where('id', $id)->first();

            if (!$lembur) {
                return back()->with('error', 'Lembur tidak ditemukan');
            }

            $daftarKaryawan = DaftarKaryawan::where('lembur_id', $id)->get();

            foreach ($daftarKaryawan as $daftar) {
                $daftar->delete();
            }

            $lembur->delete();

            return back()->with('success', 'Lembur berhasil dihapus');
        } catch (\Throwable $th) {
            Log::error('LemburController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

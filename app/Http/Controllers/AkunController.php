<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    function index()
    {
        $akun = Akun::where('jenis_akun', '==', 'sales')->get();

        $data = [
            'akun' => $akun,
        ];

        return view('Akun', $data);
    }

    public function tambah(Request $request)
    {
        $akun = new Akun();
        $akun->nama = $request->input('nama');
        $akun->email = $request->input('email');
        $akun->no_wa = $request->input('no_wa');
        $akun->jenis_kelamin = $request->input('jenis_kelamin');
        $akun->alamat = $request->input('alamat');
        $akun->jenis_akun_id = $request->input('jenis_akun');

        if ($request->hasFile('foto')) {
            $lokasi_full = $request->file('foto')->store('uploads/foto_barang', 'public');
            $$akun->foto = basename($lokasi_full);
        }

        try {
            $akun->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('id_edit');
        $nama = $request->input('nama_edit');
        $email = $request->input('email_edit');
        $no_wa = $request->input('no_wa_edit');
        $jenis_kelamin = $request->input('jenis_kelamin_edit');
        $alamat = $request->input('alamat_edit');
        $jenis_akun_id = $request->input('jenis_akun_edit');

        $akun = Akun::where('id', $id)->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        $akun->nama = $nama;
        $akun->email = $email;
        $akun->no_wa = $no_wa;
        $akun->jenis_kelamin = $jenis_kelamin;
        $akun->alamat = $alamat;
        $akun->jenis_akun_id = $jenis_akun_id;

        if ($akun->save()) {
            return back();
        }
    }

    function GantiFoto(Request $request) {}

    function GantiSandi(Request $request)
    {
        $id = $request->input('id_ganti_sandi');
        $sandi_baru = md5($request->input('sandi'));

        $akun = Akun::where('id', $id)->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        $akun->password = $sandi_baru;

        if ($akun->save()) {
            return back();
        }
    }

    function Aktifkan(Request $request) {}
    function Nonaktifkan(Request $request) {}
}

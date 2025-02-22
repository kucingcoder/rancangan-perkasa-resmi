<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AkunController extends Controller
{
    function index()
    {
        $akun = Akun::orderBy('nama', 'asc')->get();

        $data = [
            'akun' => $akun,
        ];

        return view('Akun', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_tambah' => 'required',
            'email_tambah' => 'required',
            'no_wa_tambah' => 'required',
            'jenis_kelamin_tambah' => 'required',
            'alamat_tambah' => 'required',
            'jenis_akun_tambah' => 'required',
        ]);

        if (Akun::where('nama', $request->input('nama_tambah'))->exists()) {
            return back()->withErrors('Akun ' . $request->input('nama_tambah') . ' sudah terdaftar');
        }

        if (Akun::where('email', $request->input('email_tambah'))->exists()) {
            return back()->withErrors('Email ' . $request->input('email_tambah') . ' sudah terdaftar');
        }

        if (Akun::where('no_wa', $request->input('no_wa_tambah'))->exists()) {
            return back()->withErrors('No WA ' . $request->input('no_wa_tambah') . ' sudah terdaftar');
        }

        $akun = new Akun();
        $akun->nama = $request->input('nama_tambah');
        $akun->email = $request->input('email_tambah');
        $akun->no_wa = $request->input('no_wa_tambah');
        $akun->jenis_kelamin = $request->input('jenis_kelamin_tambah');
        $akun->alamat = $request->input('alamat_tambah');
        $akun->jenis_akun = $request->input('jenis_akun_tambah');
        $akun->password = md5('!Akses99!');

        if ($request->hasFile('foto_tambah')) {
            $lokasi_full = $request->file('foto_tambah')->store('uploads/foto_orang', 'public');
            $akun->foto = basename($lokasi_full);
        }

        try {
            $akun->save();

            $pesan = "Halo, kami dari Rancangan Perkasa\n\n";
            $pesan .= "Berikut akses akun anda\n\n";
            $pesan .= "Email : $akun->email\n";
            $pesan .= "Password : !Akses99!\n\n";
            $pesan .= "Terimakasih telah bergabung dengan kami.";

            $pesan_terenkripsi = urlencode($pesan);
            $nomor_wa = "62" . substr($akun->no_wa, 1);

            $link = "https://wa.me/$nomor_wa?text=$pesan_terenkripsi";

            session()->flash('link', $link);
            session()->flash('email', $akun->email);

            return back()->with('pesan', 'Akun ' . $akun->nama . ' berhasil dibuat');
        } catch (\Throwable $th) {
            Log::error('AkunController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_edit' => 'required',
            'email_edit' => 'required',
            'no_wa_edit' => 'required',
            'jenis_kelamin_edit' => 'required',
            'alamat_edit' => 'required',
            'jenis_akun_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $nama = $request->input('nama_edit');
        $email = $request->input('email_edit');
        $no_wa = $request->input('no_wa_edit');
        $jenis_kelamin = $request->input('jenis_kelamin_edit');
        $alamat = $request->input('alamat_edit');
        $jenis_akun = $request->input('jenis_akun_edit');

        $akun = Akun::where('id', $id)->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        $akun->nama = $nama;
        $akun->email = $email;
        $akun->no_wa = $no_wa;
        $akun->jenis_kelamin = $jenis_kelamin;
        $akun->alamat = $alamat;
        $akun->jenis_akun = $jenis_akun;
        $akun->updated_at = now();

        try {
            $akun->save();
            return back()->with('success', 'Akun ' . $akun->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('AkunController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    function GantiFoto(Request $request)
    {
        $request->validate([
            'id_ganti_foto' => 'required',
        ]);

        $id = $request->input('id_ganti_foto');
        $akun = Akun::where('id', $id)->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        if ($request->hasFile('foto')) {
            if ($akun->foto) {
                try {
                    Storage::disk('public')->delete('uploads/foto_orang/' . $akun->foto);
                } catch (\Throwable $th) {
                    Log::error('AkunController : ' . $th);
                }
            }

            $lokasi_full = $request->file('foto')->store('uploads/foto_orang', 'public');
            $akun->foto = basename($lokasi_full);
            $akun->updated_at = now();
        }

        try {
            $akun->save();
            return back()->with('success', 'Foto ' . $akun->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('AkunController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    function GantiSandi(Request $request)
    {
        $id = $request->input('id_ganti_sandi');
        $sandi_baru = md5($request->input('sandi'));

        $akun = Akun::where('id', $id)->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        $akun->password = $sandi_baru;
        $akun->updated_at = now();

        try {
            $akun->save();
            return back()->with('success', 'Sandi ' . $akun->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('AkunController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    function UbahStatus(Request $request)
    {
        $request->validate([
            'id_status' => 'required',
        ]);

        $id = $request->input('id_status');
        $akun = Akun::where('id', $id)->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        if ($akun->status == 'aktif') {
            $akun->status = 'nonaktif';
        } else {
            $akun->status = 'aktif';
        }

        $akun->updated_at = now();

        try {
            $akun->save();
            return back()->with('success', 'Status ' . $akun->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('AkunController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        $akun = Akun::where('id', $request->session()->get('id'))->first();

        $data = [
            'akun' => $akun
        ];

        return view('Profil', $data);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'no_wa' => 'required',
        ]);

        $akun = Akun::where('id', $request->session()->get('id'))->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        $akun->nama = $request->input('nama');
        $akun->jenis_kelamin = $request->input('jenis_kelamin');
        $akun->alamat = $request->input('alamat');
        $akun->email = $request->input('email');
        $akun->no_wa = $request->input('no_wa');

        try {
            $akun->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function GantiSandi(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required',
            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        $akun = Akun::where('id', $request->session()->get('id'))->first();

        if (!$akun) {
            return back()->withErrors('Akun tidak ditemukan');
        }

        $password_lama = md5($request->input('password_lama'));

        if ($password_lama != $akun->password) {
            return back()->withErrors('Password lama salah');
        }

        $akun->password = md5($request->input('password_baru'));

        if ($akun->save()) {
            return back();
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}

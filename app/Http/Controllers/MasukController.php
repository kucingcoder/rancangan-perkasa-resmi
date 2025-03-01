<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class MasukController extends Controller
{
    public function index()
    {
        return view('Masuk');
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $request->input('email');
        $password = md5($request->input('password'));

        $akun = Akun::where('email', $email)->where('password', $password)->first();
        if ($akun) {
            if ($akun->status == 'non aktif') {
                return back()->withErrors('Akun anda dinonaktifkan oleh admin');
            }

            $request->session()->put('id', $akun->id);
            $request->session()->put('jenis', $akun->jenis_akun);

            if ($akun->jenis_akun == 'admin') {
                return redirect('/pesanan-masuk');
            } elseif ($akun->jenis_akun == 'sales') {
                return redirect('/keranjang');
            }

            return redirect('/dashboard');
        } else {
            return back()->withErrors('Email atau password salah');
        }
    }
}

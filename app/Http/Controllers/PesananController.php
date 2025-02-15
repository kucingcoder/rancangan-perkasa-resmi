<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $pesanan = Pesanan::with('keranjang')
            ->whereHas('keranjang', function ($query) use ($request) {
                $query->where('akun_id', $request->session()->get('id'));
            })
            ->orderBy('updated_at', 'desc')
            ->get();


        $data = [
            'pesanan' => $pesanan
        ];

        return view('Pesanan', $data);
    }
}

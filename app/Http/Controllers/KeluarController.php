<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeluarController extends Controller
{
    function keluar(Request $request)
    {
        $request->session()->flush();
        return redirect('/masuk');
    }
}

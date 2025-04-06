<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NonSesi
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('id')) {
            if ($request->session()->get('jenis') == 'admin' || $request->session()->get('jenis') == 'owner') {
                return redirect('/statistik');
            } else {
                return redirect('/pesanan');
            }
        }

        return $next($request);
    }
}

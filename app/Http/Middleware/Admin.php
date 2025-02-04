<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('id')) {
            if ($request->session()->get('jenis') == 'admin' || $request->session()->get('jenis') == 'owner') {
                return $next($request);
            }
        }
        return redirect('/');
    }
}

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
            return redirect('/dashboard');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PtLoginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->id_phanquyen == 4) {
            return $next($request);
        } else {
            return redirect('/admin')->with('thongbao', 'Bạn không có quyền truy cập trang PT.');
        }
    }
}

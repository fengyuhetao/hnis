<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        判断该用户是否拥有该权限
//        if(!session('user')) {
//            return redirect('admin/login');
//        }
        return $next($request);
    }
}

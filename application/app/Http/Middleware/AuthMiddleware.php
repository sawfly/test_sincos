<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware
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
        $u = \DB::table('users')->where(['id'=>$request->cookie('uid'), 'remember_token'=>$request->cookie('token')])
            ->get();
        return (!empty($u) && $request->route()->parameter('users') == $u[0]->id) ? $next($request) : redirect('/');
    }
}

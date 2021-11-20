<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ForceChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::user()!=NULL){
            if (Hash::check(Auth::user()->nim_alumni, Auth::user()->password)) {
                return redirect()->route('alumni-password-edit')->with('error', 'Ganti password anda terlebih dahulu!');;
            }
        }


        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifiedAlumniMiddleware
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
        if(Auth::user()->status != 'Konfirmasi'){
            abort(403, 'Forbidden.');
        };
        if(!session('alumni')){
            return redirect('/alumni/login');
        };
        return $next($request);
    }
}

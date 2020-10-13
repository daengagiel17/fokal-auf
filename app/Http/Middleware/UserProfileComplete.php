<?php

namespace App\Http\Middleware;

use Closure;

class UserProfileComplete
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
        // Please note here complete = 1 means user has completed his profile 
        if(!auth()->user()->anggota->is_verify) { 
            return redirect(route('profil.anggota.show'));
        }

        return $next($request);
    }
}
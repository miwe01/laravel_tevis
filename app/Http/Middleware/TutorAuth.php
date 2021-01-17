<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TutorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($_SESSION['language']))
            \App::setLocale($_SESSION['language']);

        if (isset($_SESSION['WiMi_UserId']))
        {
            return $next($request);
        }
        else if (isset($_SESSION['HiWi_UserId']))
        {
            return $next($request);
        }

        return redirect()->route('login');

    }
}

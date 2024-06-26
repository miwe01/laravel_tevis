<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfAuth
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

        if (!isset($_SESSION['Prof_UserId']))
        {
            session_destroy();
            return redirect()->route('login');
        }
        return $next($request);

    }
}

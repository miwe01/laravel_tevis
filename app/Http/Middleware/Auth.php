<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth
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
        // Überprüft ob Session gesetzt wurde
        // Session kann nur gesetzt werden wenn es Benutzer mit dem Passwort gibt
        if (isset($_SESSION['PA_UserId']))
            return $next($request);
        else if (isset($_SESSION['HiWi_UserId']))
            return $next($request);
        else if (isset($_SESSION['WiMi_UserId']))
            return $next($request);
        else if (isset($_SESSION['Student_UserId']))
            return $next($request);
        else if (isset($_SESSION['Prof_UserId']))
            return $next($request);

        return redirect()->route('login');
    }
}

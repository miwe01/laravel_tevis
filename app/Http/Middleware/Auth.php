<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Wenn Get "language" Parameter gesetzt wurde, speichere langugae in Session
        // Ändere Sprache um
        if (isset($_SESSION['language']))
        \App::setLocale($_SESSION['language']);

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

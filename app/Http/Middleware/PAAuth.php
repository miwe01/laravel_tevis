<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PAAuth
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

        if (!isset($_SESSION['PA_UserId']))
        {
            return redirect()->route('login');
        }
        return $next($request);

    }
}

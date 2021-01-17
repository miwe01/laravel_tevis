<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentAuth
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

        if (!isset($_SESSION['Student_UserId']))
        {
            return redirect()->route('login');
        }
        return $next($request);

    }
}

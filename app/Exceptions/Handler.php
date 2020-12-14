<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

//
//
//
// Wenn auskommentiert(use, und render Methode) wird jede Url die falsch ist
// (URl versucht auf Seiten zu kommen die nicht existieren)
// wird zurück auf Login geworfen
//
//
//


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /*
    public function render($request, Throwable $e){
        if ($e instanceof MethodNotAllowedHttpException)
        {
            return redirect()->route('login');
        }
    }
    */
}

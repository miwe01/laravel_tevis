<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', '\App\Http\Controllers\PruefungsamtController@index')->name('dashboard');
Route::post('/', '\App\Http\Controllers\PruefungsamtController@index')->name('dashboard');
Route::post('/addPerson', '\App\Http\Controllers\PruefungsamtController@benutzerAdd');
Route::post('/fileUpload', '\App\Http\Controllers\PruefungsamtController@fileUpload');
Route::post('/klausurZulassung', '\App\Http\Controllers\PruefungsamtController@klausurZulassung');
/*
Route::post('/benutzerAdd', '\App\Http\Controllers\PruefungsamtController@check');
Route::post('/benutzerDelete', '\App\Http\Controllers\PruefungsamtController@check');
*/
// Route::get('/benutzerAdd', '\App\Http\Controllers\PruefungsamtController@check');

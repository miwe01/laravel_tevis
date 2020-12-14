<?php
if(!isset($_SESSION)){
    session_start();
}
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruefungsamtController;
use App\Http\Controllers\AuthenticationController;
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
Route::view('/', 'Login.index', [])->name('login');
Route::post('/authentication', [AuthenticationController::class, 'authenticate']);
//Route::get('/', '\App\Http\Controllers\PruefungsamtController@index')->name('dashboard');



Route::middleware('auth')->prefix('pruefungsamt')->group(function(){
    $PC = PruefungsamtController::class;

    Route::get('', [$PC, 'index'])->name('dashboard');
    Route::post('', [$PC, 'index'])->name('dashboard');

    Route::post('/logout', [$PC,  'logout']);
    Route::post('/addPerson', [$PC,  'benutzerAdd']);
    Route::post('/fileUpload', [$PC, 'fileUpload']);
    Route::post('/klausurZulassung', [$PC, 'klausurZulassung']);
    Route::post('/klausurZulassungen',[$PC, 'klausurZulassungen']);
    Route::post('/praktikumAnerkennen', [$PC, 'praktikumAnerkennen']);
    Route::post('/Testatbogen', [PruefungsamtController::class, 'Testatbogen']);

    Route::get('/konto', '\App\Http\Controllers\PruefungsamtController@konto')->name('konto');
    Route::post('/konto/passwortAendern', '\App\Http\Controllers\PruefungsamtController@passwortAendern');
});




/*
Route::post('/benutzerAdd', '\App\Http\Controllers\PruefungsamtController@check');
Route::post('/benutzerDelete', '\App\Http\Controllers\PruefungsamtController@check');
*/
// Route::get('/benutzerAdd', '\App\Http\Controllers\PruefungsamtController@check');

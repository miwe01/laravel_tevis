<?php
if(!isset($_SESSION)){
    session_start();
}

use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruefungsamtController;
use App\Http\Controllers\AuthenticationController;
//$_SESSION['HiWi_UserId'] = 1;
//$_SESSION['WiMi_UserId'] = 1;
//$_SESSION['Student_UserId'] = 1;


//login/logout route + authentication
Route::view('/', 'Login.index', [])->name('login');
Route::post('/authentication', [AuthenticationController::class, 'authenticate']);
Route::post('/logout', [AuthenticationController::class, 'logout']);


//Pruefungsamt routes
Route::middleware('auth')->prefix('pruefungsamt')->group(function(){
    $PC = PruefungsamtController::class;

//    Route::get('', [$PC, 'index'])->name('dashboard');
    Route::any('', [$PC, 'index'])->name('dashboard');

    Route::post('/addPerson', [$PC,  'benutzerAdd']);
    Route::post('/fileUpload', [$PC, 'fileUpload']);
    Route::post('/klausurZulassung', [$PC, 'klausurZulassung']);
    Route::post('/klausurZulassungen',[$PC, 'klausurZulassungen']);
    Route::post('/praktikumAnerkennen', [$PC, 'praktikumAnerkennen']);
    Route::post('/Testatbogen', [PruefungsamtController::class, 'Testatbogen']);


    Route::get('/konto', [AuthenticationController::class, 'konto'])->name('konto');
    Route::post('/konto', [AuthenticationController::class, 'passwortAendern']);
  //  Route::get('/konto', '\App\Http\Controllers\PruefungsamtController@konto')->name('konto');
 //   Route::post('/konto/passwortAendern', '\App\Http\Controllers\PruefungsamtController@passwortAendern');
});


// professor routes
Route::middleware('auth')->prefix('Professor')->group(function() {
    Route::get('/Professor', [ProfessorController::class, 'index'])->name('Professor');;
    Route::get('/meine_kurse', function () {
        return view('/Professor/meine_kurse', ['title'=>'meine_kurse']);
    });
    Route::post('/kurs', function () {
        return view('/Professor/kurs', ['title'=>'kurs']);
    });
    Route::post('/gruppe', [ProfessorController::class, 'gruppe']);

    Route::get('/konto', [AuthenticationController::class, 'konto'])->name('konto');
    Route::post('/konto', [AuthenticationController::class, 'passwortAendern']);
});

// student routes
Route::middleware('auth')->prefix('Student')->group(function() {

    Route::get('/dashboard', [StudentController::class, 'index'])->name('Student/dashboard');
    Route::post('/testatbogen', [StudentController::class, 'show']);
    Route::post('/dashboard', [StudentController::class, 'index']);
    Route::post('/dashboard/{testat}', [StudentController::class, 'testat']);
    Route::get('/konto', [AuthenticationController::class, 'konto'])->name('konto');
    Route::post('/konto', [AuthenticationController::class, 'passwortAendern']);
});

// Tutor routes
Route::middleware('auth')->prefix('Tutor')->group(function(){

    Route::get('/dashboard', [TutorController::class, 'index'])->name('Tutor/dashboard');
    Route::post('/dashboard/{testatverwaltung}', [TutorController::class, 'testatverwaltung']);
    Route::get('/dashboard/{testatverwaltung}', [TutorController::class, 'testatverwaltung'])->name('Tutor/testatverwaltung');
    Route::post('/dashboard/{testatverwaltung}/{testat}', [TutorController::class, 'testat'])->name('Tutor/testat');
    Route::get('/konto', [AuthenticationController::class, 'konto'])->name('konto');
    Route::post('/konto', [AuthenticationController::class, 'passwortAendern']);
});


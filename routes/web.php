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
Route::get('/konto', [AuthenticationController::class, 'konto'])->name('konto');
Route::post('/konto', [AuthenticationController::class, 'passwortAendern']);

//Pruefungsamt routes
Route::middleware('PAAuth')->prefix('pruefungsamt')->group(function(){
    $PC = PruefungsamtController::class;

//    Route::get('', [$PC, 'index'])->name('dashboard');
    Route::any('', [$PC, 'index'])->name('dashboard');

    Route::post('/addPerson', [$PC,  'benutzerAdd']);
    Route::post('/fileUpload', [$PC, 'fileUpload']);
    Route::post('/klausurZulassung', [$PC, 'klausurZulassung']);
    Route::post('/klausurZulassungen',[$PC, 'klausurZulassungen']);
    Route::post('/praktikumAnerkennen', [$PC, 'praktikumAnerkennen']);
    Route::post('/Testatbogen', [PruefungsamtController::class, 'Testatbogen']);



  //  Route::get('/konto', '\App\Http\Controllers\PruefungsamtController@konto')->name('konto');
 //   Route::post('/konto/passwortAendern', '\App\Http\Controllers\PruefungsamtController@passwortAendern');
});


// professor routes
Route::middleware('ProfAuth')->prefix('Professor')->group(function() {
    Route::get('/dashboard', [ProfessorController::class, 'index'])->name('Professor');
    Route::get('/meine_kurse', [ProfessorController::class, 'meineKurse']);
    Route::post('/kurs', function () {return view('/Professor/kurs', ['title'=>'kurs']);});
    Route::any('/gruppe', [ProfessorController::class, 'gruppe'])->name('gruppe');
    Route::post('/gruppe/tutorloeschen', [ProfessorController::class, 'tutorLoeschen']);
    Route::post('/gruppe/studentloeschen', [ProfessorController::class, 'studentenAusGruppeLoeschen']);
    Route::post('/gruppe/studentVerschieben', [ProfessorController::class, 'studentVerschieben']);
    Route::post('/gruppe/studentHinzu', [ProfessorController::class, 'studentZuGruppe']);
    Route::post('/gruppe/betreuerHinzu', [ProfessorController::class, 'betreuerZuGruppe']);
    Route::post('/gruppe/Hauptbetreuer', [ProfessorController::class, 'ansprechperson']);
});

// student routes
Route::middleware('StudentAuth')->prefix('Student')->group(function() {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('Student/dashboard');
    Route::get('/testatbogen', [StudentController::class, 'show'])->name('Student/testatbogen');
    Route::post('/dashboard', [StudentController::class, 'index']);
    Route::post('/dashboard/{testat}', [StudentController::class, 'testat']);
    Route::post('/testatbogen', [StudentController::class, 'show']);
});

// Tutor routes
Route::middleware('TutorAuth')->prefix('Tutor')->group(function(){
    Route::get('/dashboard', [TutorController::class, 'index'])->name('Tutor/dashboard');
    Route::post('/dashboard/testatverwaltung', [TutorController::class, 'testatverwaltung']);
    Route::get('/dashboard/testatverwaltung', [TutorController::class, 'testatverwaltung'])->name('Tutor/testatverwaltung');
    Route::any('/dashboard/testatverwaltung/testat', [TutorController::class, 'testat'])->name('Tutor/testat');
});


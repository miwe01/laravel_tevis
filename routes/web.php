<?php
session_start();

use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruefungsamtController;
use App\Http\Controllers\AuthenticationController;
//$_SESSION['HiWi_UserId'] = 1;
//$_SESSION['WiMi_UserId'] = 1;
//$_SESSION['Student_UserId'] = 1;

// Wenn Sprach Get Parameter gesetzt wurde speichere in Session
// Middleware überprüft ob Session gesetzt wurde und wenn ja
// ändere sie in entsprechende Sprache
// Middleware: Auth.php
if (isset($_GET['language'])){
    // wenn ungültige Sprache default Sprache ist Deutsch
    if ($_GET['language'] != "en" && $_GET['language'] != "de")
        $_SESSION['language'] = 'de';
    else
        $_SESSION['language'] = $_GET['language'];
}

//login/logout route + authentication + konto
Route::view('/', 'Login.index', [])->name('login');
Route::post('/authentication', [AuthenticationController::class, 'authenticate']);
Route::post('/logout', [AuthenticationController::class, 'logout']);

Route::get('/konto', [AuthenticationController::class, 'konto'])->name('konto')->middleware('auth');
Route::post('/konto', [AuthenticationController::class, 'passwortAendern'])->middleware('auth');


//Pruefungsamt routes
Route::middleware('auth')->prefix('pruefungsamt')->group(function(){
    $PC = PruefungsamtController::class;

    Route::any('', [$PC, 'index'])->name('dashboard');

    Route::post('/addPerson', [$PC,  'benutzerAdd']);
    Route::post('/fileUpload', [$PC, 'fileUpload']);
    Route::post('/klausurZulassung', [$PC, 'klausurZulassung']);
    Route::any('/klausurZulassungen',[$PC, 'klausurZulassungen']);
    Route::post('/praktikumAnerkennen', [$PC, 'praktikumAnerkennen']);
    Route::any('/Testatbogen', [$PC, 'Testatbogen']);
});


// professor routes
Route::middleware('auth')->prefix('Professor')->group(function() {
    Route::get('/dashboard', [ProfessorController::class, 'index'])->name('Professor');
    Route::any('/meine_kurse', [ProfessorController::class, 'meineKurse'])->name('meineKurse');
    Route::post('/kurs', function () {return view('/Professor/kurs', ['title'=>'kurs']);});
    Route::any('/gruppe', [ProfessorController::class, 'gruppe'])->name('gruppe');
    Route::post('/gruppe/tutorloeschen', [ProfessorController::class, 'tutorLoeschen']);
    Route::post('/gruppe/studentloeschen', [ProfessorController::class, 'studentenAusGruppeLoeschen']);
    Route::post('/gruppe/studentVerschieben', [ProfessorController::class, 'studentVerschieben']);
    Route::post('/gruppe/studentHinzu', [ProfessorController::class, 'studentZuGruppe']);
    Route::post('/gruppe/betreuerHinzu', [ProfessorController::class, 'betreuerZuGruppe']);
    Route::post('/gruppe/Hauptbetreuer', [ProfessorController::class, 'ansprechperson']);
    Route::post('/meine_kurse/neuer_kurs', [ProfessorController::class, 'neuer_kurs']);
    Route::post('/gruppe/testat', [ProfessorController::class, 'testat']);
});

// HiWi routes
Route::middleware('auth')->prefix('HiWi')->group(function(){

    Route::get('/main_HiWi', function () {
        return view('/HiWi/main_HiWi', ['title'=>'HiWi']);
    })->name('HiWi');

    Route::get('/HiWi', function () {
        return view('/HiWi/HiWi', ['title'=>'HiWi']);
    });
    Route::get('/testSWE', function () {
        return view('/HiWi/testSWE_HiWi', ['title'=>'testSWE']);
    });
    Route::get('/test', function () {
        return view('/HiWi/HiWiTestGruppeA1', ['title'=>'TestGruppeA1']);
    });
    Route::get('/konto_HiWi', function () {
        return view('/HiWi/konto_HiWi', ['title'=>'Konto']);
    });
    Route::get('/testatbogen_HiWi', function () {
        return view('/HiWi/Testatbogen_HiWi', ['title'=>'Testatbogen']);
    });
});

// WiMi routes
Route::middleware('auth')->prefix('WiMi')->group(function(){
Route::get('/test', function () {
    return view('test', ['title'=>'Test']);
});
Route::get('/main_WiMi', function () {
    return view('/WiMi/main_WiMi', ['title'=>'WiMi']);
})->name('Wimi');
Route::get('/konto_WiMi', function () {
    return view('/WiMi/konto_WiMi', ['title'=>'Konto']);
});
Route::get('/test', function () {
    return view('/WiMi/TestGruppeA1', ['title'=>'TestGruppeA1']);
});
});

// student routes
Route::middleware('auth')->prefix('Student')->group(function() {

    Route::get('/dashboard', [StudentController::class, 'index'])->name('Student/dashboard');
    Route::post('/testatbogen', [StudentController::class, 'show']);
    Route::post('/dashboard', [StudentController::class, 'index']);
    Route::post('/dashboard/{testat}', [StudentController::class, 'testat']);

    });

// Tutor routes
Route::middleware('auth')->prefix('Tutor')->group(function(){

    Route::get('/dashboard', [TutorController::class, 'index'])->name('Tutor/dashboard');
    Route::post('/dashboard/{testatverwaltung}', [TutorController::class, 'testatverwaltung']);
    Route::get('/dashboard/{testatverwaltung}', [TutorController::class, 'testatverwaltung'])->name('Tutor/testatverwaltung');
    Route::post('/dashboard/{testatverwaltung}/{testat}', [TutorController::class, 'testat'])->name('Tutor/testat');

});


<?php
if(!isset($_SESSION)){
    session_start();
}
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

    Route::get('/konto', '\App\Http\Controllers\PruefungsamtController@konto')->name('konto');
    Route::post('/konto/passwortAendern', '\App\Http\Controllers\PruefungsamtController@passwortAendern');
});


// professor routes
Route::middleware('auth')->prefix('Professor')->group(function() {
    Route::get('/Professor', function () {
        return view('/Professor/dashboard', ['title'=>'Dashboard']);
    })->name('Professor');;
    Route::get('/meine_kurse', function () {
        return view('/Professor/meine_kurse', ['title'=>'meine_kurse']);
    });
    Route::get('/kurs', function () {
        return view('/Professor/kurs', ['title'=>'kurs']);
    });
    Route::get('/gruppe_bearbeiten', function () {
        return view('/Professor/gruppe_bearbeiten', ['title'=>'gruppe_bearbeiten']);
    });
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
    Route::get('/main_Student', function () {
        return view('/Student/main_Student', ['title'=>'main_Student']);
    })->name('Student');;
    Route::get('/main_WiMi', function () {
        return view('/Student/main_WiMi', ['title'=>'main_WiMi']);
    });
    Route::get('/konto_Student', function () {
        return view('/Student/konto_Student', ['title'=>'konto_Student']);
    });
    Route::get('/testatbogen_Student', function () {
        return view('/Student/Testatbogen_Student', ['title'=>'Testatbogen_Student']);
    });
    Route::get('/testSWE', function () {
        return view('/Student/testSWE_Student', ['title'=>'testSWE_Student']);
    });
});

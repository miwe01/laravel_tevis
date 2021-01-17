<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function logout(Request $request){
        session_destroy();
        return redirect()->route('login');
    }

    public function authenticate(Request $request){
        $kennung = $request->kennung;
        $passwort = $request->passwort;
        $sprache = $request->sprache;
        $_SESSION['kennung'] = $kennung;

        //Wenn Felder sind
        if ($kennung == NULL)
            $_SESSION['fehler'] = 'Keine Kennung eingegeben';
        if($passwort == NULL)
            $_SESSION['fehler'] = 'Keine Passwort eingegeben';
        if ($kennung == NULL || $passwort == NULL)
            return redirect()->route('login');

        // Authentifizierung
        // Checkt ob Benutzer existiert und gibt Passwort zurück
        $kennungCheck = DB::table('benutzer')
            ->where('Kennung', $kennung)
            ->value('Password');

//       $hash = Hash::make('test..123');
//       dd($hash);

        // Benutzer gibt es nicht

        if ($kennungCheck == NULL){
            $_SESSION['fehler'] = 'Kennung oder Passwort falsch';
            return redirect()->route('login');
        }


        if (isset($sprache)){
            $_SESSION["language"] = $sprache;

        }

        //Wenn Benutzer stimmt

        if (Hash::check($passwort, $kennungCheck)) {
            // löscht session variablen
            if (isset($_SESSION['kennung']))
                unset($_SESSION['kennung']);
            if (isset($_SESSION['fehler']))
                unset($_SESSION['fehler']);


            // Pruefungsamt
            $pruefungsamtCheck = DB::table('pruefungsamt')->where('Kennung', $kennung)->value('Kennung');
            if ($pruefungsamtCheck != NULL){
                $_SESSION['PA_UserId'] = $kennung;
                return redirect()->route('dashboard');
            }
            // Hiwi
            $HiwiCheck = DB::table('tutor')
                ->where('Kennung', $kennung)
                ->where('Rolle', 'HiWI')
                ->value('Kennung');
            if ($HiwiCheck != NULL){
                $_SESSION['HiWi_UserId'] = $kennung;
                $_SESSION['Student_UserId'] = $kennung;
                return redirect()->route('Student/dashboard');
            }
            // student
            $StudentCheck = DB::table('student')
                ->where('Kennung', $kennung)
                ->value('Kennung');
            if ($StudentCheck != NULL){
                $_SESSION['Student_UserId'] = $kennung;
                return redirect()->route('Student/dashboard');
            }

            // Wimi
            $WiMiCheck = DB::table('tutor')
                ->where('Kennung', $kennung)
                ->where('Rolle', 'WiMi')
                ->value('Kennung');
            if ($WiMiCheck != NULL){
                $_SESSION['WiMi_UserId'] = $kennung;
                return redirect()->route('Tutor/dashboard');
            }
            // professor
            $ProfessorCheck = DB::table('professor')
                ->where('Kennung', $kennung)
                ->value('Kennung');

            if ($ProfessorCheck != NULL){
                $_SESSION['Prof_UserId'] = $kennung;
                return redirect()->route('Professor');
            }
            // alle andere Rollen (Professor, Tutor, etc...)
            //else if()

        }
        // Passowort falsch
        else{
            $_SESSION['fehler'] = 'Kennung oder Passwort falsch';
            return redirect()->route('login');
        }

    }


    public function konto(Request $request){
        if ((isset($_SESSION['HiWi_UserId'])))
        {
            return view('Login.konto',
                ['info'=> $request->info,
                    'fehler_menu'=>$request->fehler_menu
                    ,'title'=>'Mein Konto']);
        }

        elseif((isset($_SESSION['Student_UserId'])))
        {
            return view('Login.konto',
                ['info'=> $request->info,
                    'fehler_menu'=>$request->fehler_menu
                    ,'title'=>'Mein Konto']);
        }

        elseif((isset($_SESSION['WiMi_UserId'])))
        {
            return view('Login.konto',
                ['info'=> $request->info,
                    'fehler_menu'=>$request->fehler_menu
                    ,'title'=>'Mein Konto']);
        }

        elseif((isset($_SESSION['Prof_UserId'])))
        {
            return view('Login.konto',
                ['info'=> $request->info,
                    'fehler_menu'=>$request->fehler_menu
                    ,'title'=>'Mein Konto']);
        }

        elseif((isset($_SESSION['PA_UserId'])))
        {
            return view('Login.konto',
                ['info'=> $request->info,
                    'fehler_menu'=>$request->fehler_menu
                    ,'title'=>'Mein Konto']);
        }
        return redirect()->route('login');
    }

    public function passwortAendern(Request $request){
        if($request->opassword == NULL || $request->npassword == NULL)
            return redirect()->route('konto', ['fehler_menu'=>'Passwort nicht gesetzt']);




        if (isset($_SESSION['PA_UserId']))
        {
            $KennungVonPassword = DB::table('benutzer')
                ->where('Kennung', $_SESSION['PA_UserId'])
                ->value('Password');
            $actualuser = $_SESSION['PA_UserId'];
        }
        elseif (isset($_SESSION['Student_UserId']))
        {
            $KennungVonPassword = DB::table('benutzer')
                ->where('Kennung', $_SESSION['Student_UserId'])
                ->value('Password');
            $actualuser = $_SESSION['Student_UserId'];
        }
        elseif (isset($_SESSION['HiWi_UserId']))
        {
            $KennungVonPassword = DB::table('benutzer')
                ->where('Kennung', $_SESSION['HiWi_UserId'])
                ->value('Password');
            $actualuser = $_SESSION['HiWi_UserId'];
        }

        elseif (isset($_SESSION['WiMi_UserId']))
        {
            $KennungVonPassword = DB::table('benutzer')
                ->where('Kennung', $_SESSION['WiMi_UserId'])
                ->value('Password');
            $actualuser = $_SESSION['WiMi_UserId'];
        }
        elseif (isset($_SESSION['Prof_UserId']))
        {
            $KennungVonPassword = DB::table('benutzer')
                ->where('Kennung', $_SESSION['Prof_UserId'])
                ->value('Password');

            $actualuser = $_SESSION['Prof_UserId'];
        }

        if (Hash::check($request->opassword, $KennungVonPassword)) {
            $newPassword = Hash::make($request->npassword);

            DB::table('benutzer')
                ->where('Kennung', $actualuser)
                ->update(['Password' => $newPassword]);
            return redirect()->route('konto', ['info'=>trans('Passwort wurde geändert')]);
        }

        return redirect()->route('konto', ['fehler_menu'=>trans('Fehler bei Passwort')]);

    }
}

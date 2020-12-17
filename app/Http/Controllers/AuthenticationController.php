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
                return redirect()->route('HiWi');
            }
            // Wimi
            $WiMiCheck = DB::table('tutor')
                ->where('Kennung', $kennung)
                ->where('Rolle', 'WiMi')
                ->value('Kennung');
            if ($WiMiCheck != NULL){
                $_SESSION['WiMi_UserId'] = $kennung;
                return redirect()->route('Wimi');
            }
            // student
            $StudentCheck = DB::table('student')
                ->where('Kennung', $kennung)
                ->value('Kennung');
            if ($StudentCheck != NULL){
                $_SESSION['Student_UserId'] = $kennung;
                return redirect()->route('Student');
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

}

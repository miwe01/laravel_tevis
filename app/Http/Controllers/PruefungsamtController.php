<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PruefungsamtController extends Controller
{
    public function index(Request $request){
        $kennung = DB::table('benutzer')->select('Nachname', 'Vorname')->orderBy('erfasst_am', 'desc')->take(5)->get();
        $wintermodule = DB::table('modul')->select('Modulnummer', 'Modulname', 'Semester', 'Jahr')->where('Semester', 'WiSe')->get();
        $sommermodule = DB::table('modul')->select('Modulnummer', 'Modulname', 'Semester', 'Jahr')->where('Semester', 'SoSe')->get();

        return view('Pruefungsamt.dashboard',['fehler'=>$request->fehler, 'lastAdded'=>$kennung, 'WinterModule'=>$wintermodule, 'SommerModule' =>
            $sommermodule, 'title'=>'Dashboard']);
    }

    public function benutzerAdd(Request $request){
        // print_r($request->all());
        if ($request->has('addPerson')){
           // dd($request->all());
            // validation
             //rules
            $rules = array(
                'nachname' => 'required',
                'vorname' => 'required',
                'email' => 'required',
                'kennung' => 'required',
                'rolle' => 'required',
                'matrikelnummer' =>'required_if:rolle,==,student'
            );
             // custom messages
            $messages = array(
                'required' => ':Attribute fehlt',
                'required_if'=>'Keine Matrikelnummer ausgewählt'
            );
            // validator
            $validator = Validator::make($request->all(), $rules, $messages);
            // if fails=>redirect zu Dashboard mit erstem Fehler
            if($validator->fails()){
                $firsterror = $validator->errors()->first();
                return redirect()->route('dashboard')->withErrors($firsterror);
            }
            // Daten sind korrekt jetzt wird überprüft ob es Benutzer schon gibt

            $kennung = DB::table('benutzer')->where('Kennung', $request->kennung)->first();
            $email = DB::table('benutzer')->where('Email', $request->email)->first();

            if ($kennung != NULL || $email != NULL){
               return redirect()->route('dashboard')->withErrors("User gibt es schon");
            }

            // Hashing im Moment ist Standard Passwort 123456
            $passwort = Hash::make('123456');

            /*check Hash (kommt ins login)
            if (Hash::check('123456', $matrikelnummer)) {
                dd("Passwort richtig");
            }*/

            // insert Benutzer
            DB::table('benutzer')->insert(
              ['Kennung'=>$request->kennung, 'Email'=>$request->email, 'Vorname'=>$request->vorname,
               'Nachname'=>$request->nachname, 'Password'=>$passwort
              ]
            );

            $rolle = $request->rolle;
            if ($rolle == "professor"){
                DB::table('professor')->insert(
                    ['Kennung'=>$request->kennung, 'Buero'=>'1', 'Telefon'=>'123']
                );
            }

            else if ($rolle == "student"){
                DB::table('student')->insert(
                    ['Kennung'=>$request->kennung, 'Studiengang'=>'INF', 'Matrikelnummer'=>$request->matrikelnummer]
                );
            }

            else if ($rolle == "wimi"){
                DB::table('tutor')->insert(
                    ['Kennung'=>$request->kennung, 'Rolle'=>'WiMi']
                );
            }

            else if ($rolle == "hiwi"){
                DB::table('tutor2')->insert(
                    ['Kennung'=>$request->kennung, 'Rolle'=>'HiWi']
                );
            }
            return redirect()->route('dashboard');

        }
    }

    public function fileUpload(Request $request)
    {
        $file = $request->file('file');
        if($file->getSize() == 0){
            return redirect()->route('dashboard', ['fehler'=>'Datei leer']);
        }
        if($file->getClientOriginalExtension() != "csv"){
            return redirect()->route('dashboard', ['fehler'=>'Keine CSV Datei']);
        }

        // $contents = file_get_contents($file->getRealPath());
        $fileArray = [];
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            while (!feof($handle)) {
                $line = fgets($handle);
                //dd($line);
                $str = explode(";", $line);
                if (count($str) != 7)
                    return redirect()->route('dashboard', ['fehler'=>'Format soll: Kennung;Email;Nachname;Vorname;Studiengang;Matrielnummer sein']);
                array_push($fileArray, $str);
            }

            for ($i=0;$i<count($fileArray);$i++){

                $kennung = $fileArray[$i][0];
                $email = $fileArray[$i][1];
                $passwort = $fileArray[$i][2];
                $nachname = $fileArray[$i][3];
                $vorname = $fileArray[$i][4];
                $studiengang = $fileArray[$i][5];
                $matrikelnummer = $fileArray[$i][6];

                //Hashing. Im Moment ist Standard Passwort 123456
                $passwort = Hash::make('123456');

                echo $matrikelnummer;
                // ignoriert Duplikate
                DB::table('benutzer')->insertOrIgnore(
                    ['Kennung'=>$kennung, 'Email'=>$email, 'Vorname'=>$vorname,
                        'Nachname'=>$nachname, 'Password'=>$passwort
                    ]
                );

                DB::table('student')->insertOrIgnore(
                    ['Kennung'=>$kennung, 'Studiengang'=>$studiengang, 'Matrikelnummer'=>$matrikelnummer]
                );

            }
            return redirect()->route('dashboard', ['fehler'=>'Datei wurde importiert']);
        }
        else
            return redirect()->route('dashboard', ['fehler'=>'Fehler beim Öffnen']);
    }

    public function klausurZulassung(Request $request){

        $testatid = DB::table('testat')->where('Modulnummer', $request->modul)->value("ID");
        //kein Testat von Modul => zugelassen
        if ($testatid == NULL){
            return redirect()->route('dashboard', ['fehler'=>'Modul nicht gefunden, automatische Klausurzulassung']);
        }
        else{
            $matrikelnummer = (int) $request->matrikelnummer;
            // get Id from testat
           //$testat = DB::table('testat')->select("ID")->where('Modulnummer', $request->modul)->first();

            //testatverwaltung
            /* $checktestat = DB::table('testatverwaltung')->where([
                ['TestatID', $testatid],
                ['Matrikelnummer', $matrikelnummer]
            ])->value("Testat"); */

            $checktestat = DB::table('testat')
                ->join('testatverwaltung', 'testat.ID', '=', 'testatverwaltung.ID')
                ->where([
                ['Modulnummer', $request->modul],
                ['Matrikelnummer', $matrikelnummer],
                ['Praktikumsname', "Endtestat"]
                 ])->value("Matrikelnummer");


            // SELECT testat.ID,Matrikelnummer FROM testatverwaltung,
            // testat WHERE testat.ID=TestatID AND Praktikumsname="Endtestat";

            if ($checktestat == $matrikelnummer){
                return redirect()->route('dashboard', ['fehler'=>'Student ist zugelassen']);
            }
            else{
                return redirect()->route('dashboard', ['fehler'=>'Student ist nicht zugelassen']);
            }
        }
        //$kennung = DB::table('benutzer')->where('Kennung', $request->kennung)->first();
    }
    public function klausurZulassungen(Request $request){
        // wenn kein Modul ausgewählt wurde
        if ($request->modul == NULL){
            return redirect()->route('dashboard', ['fehler'=>'Kein Modul ausgewählt']);
        }

        $file = $request->file('file');
        if($file->getSize() == 0){
            return redirect()->route('dashboard', ['fehler'=>'Datei leer']);
        }
        if($file->getClientOriginalExtension() != "csv"){
            return redirect()->route('dashboard', ['fehler'=>'Keine CSV Datei']);
        }

        $matrikelnummern = [];
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            while (!feof($handle)) {
                $line = fgets($handle);
                //dd($line);
                $str = explode(";", $line);
                array_push($matrikelnummern, $str);
            }
        }
        else
            return redirect()->route('dashboard', ['fehler'=>'Fehler beim Öffnen']);
        fclose($handle);

        $matrikelnummern = array_shift($matrikelnummern);
        $matrikelnummern = array_map('intval', $matrikelnummern);
        //print_r($matrikelnummern);
        //dd($matrikelnummern);

        // modullnummer und das testat
        $testatid = DB::table('testat')->where('Modulnummer', $request->modul)->value('ID');
        //dd($testatid);
        //kein Testat von Modul => zugelassen
        if ($testatid == NULL){
            return redirect()->route('dashboard', ['fehler'=>'Alle Studenten sind zugelassen, weil es kein Testat gibt']);
        }
            //$matrikelnummern=[3252173,125,54];
            //print_r($matrikelnummern);
            //dd($matrikelnummern);
            // noch nicht fertig, weil Problem mit Datenbank
            $trueTestat = DB::table('testat')
                ->join('modul', 'testat.Modulnummer', '=', 'modul.Modulnummer')
                ->join('testatverwaltung', 'testat.ID', '=', 'testatverwaltung.ID')
                ->whereIn(
                'Matrikelnummer', $matrikelnummern
                )
                ->where(
                    'Praktikumsname', 'Endtestat'
                )
                ->where(
                    'testat.Modulnummer', $request->modul
                )
                ->get();
        /*
        $falseTestat = DB::table('module')
            ->join('modul', 'testat.Modulnummer', '=', 'modul.Modulnummer')
            ->where(
                'Praktikumsname', 'Endtestat'
            )
        */
       /* if ($checktestat == NULL)
            return redirect()->route('dashboard', ['fehler'=>'Kein Student']);
       */
        return view('Pruefungsamt.klausurZulassungenListe', ['title'=> 'Testate', 'Testate' => $trueTestat]);
                dd($trueTestat);
        /* where in nimmt array
        //$myArray = explode(',', $array);
        $array = ["mw","pierre",3];
        $users = DB::table('benutzer')->select("*")
            ->whereIn('Kennung', $array)
            ->get();

        dd($users);*/
        }

    // noch nicht fertig
    public function praktikumAnerkennen(Request $request){
        if (!is_numeric($request->matrikelnummer))
            return redirect()->route('dashboard', ['fehler'=>'Keine Matrikelnummer']);
        if ($request->modul == "")
            return redirect()->route('dashboard', ['fehler'=>'Keine Modul ausgewählt']);

        // gibt modulnummer zurück
        $modulnummer = DB::table("Modul")->where("Modulname", $request->modul)->value("Modulnummer");
        $testatid = DB::table('testat')->where('Modulnummer', $modulnummer)->value("ID");
        //dd($testat);
        if($testatid == NULL)
            return redirect()->route('dashboard', ['fehler'=>'Modul hat kein Testat']);

        $testatid = DB::table('testatverwaltung')->where('ID', $testatid)->value("ID");

        if ($testatid == NULL)
            return redirect()->route('dashboard', ['fehler'=>'Fehler aufgetreten']);

        $testatbestanden = DB::table('testatverwaltung')
            ->where('ID', $testatid)
            ->update(['TestatID' => 1]);
        return redirect()->route('dashboard', ['fehler'=>'Testat bestanden']);
    }

    public function Testatbogen(Request $request){
        if (!is_numeric($request->matrikelnummer))
            return redirect()->route('dashboard', ['fehler'=>'Keine Matrikelnummer']);

        /* SELECT * FROM testatverwaltung, testat, modul WHERE Matrikelnummer=2359263 AND testat.ID = testatverwaltung.ID; */
        $testat = DB::table('testat')
            ->join('modul', 'testat.Modulnummer', '=', 'modul.Modulnummer')
            ->join('testatverwaltung', 'testat.ID', '=', 'testatverwaltung.ID')
            ->where('Matrikelnummer', $request->matrikelnummer)->get();
        dd($testat);
    }


    /* **************konto ***********************/
    public function konto(Request $request){
        return view('Pruefungsamt.konto',
            ['info'=> $request->info,
                'fehler_menu'=>$request->fehler_menu
            ,'title'=>'Mein Konto']);
    }

    public function passwortAendern(Request $request){
        if($request->opassword == NULL || $request->npassword == NULL)
            return redirect()->route('konto', ['fehler_menu'=>'Passwort nicht gesetzt']);

        // noch nicht ganz fertig
        // session user id muss noch in select
        // benutzt werden
        // dann wird nach session user id gesucht
        // bekommt passwort zurück passwort wird überprüft
        // Hashing im Moment ist Standard Passwort 123456
        //            $passwort = Hash::make('123456');
        //
        //            /*check Hash (kommt ins login)
        //            if (Hash::check('123456', $matrikelnummer)) {
        //                dd("Passwort richtig");
        //            }*/
        //
        // und dann kann er es ändern
        $KennungVonPassword = DB::table('benutzer')->where('Password', $request->opassword)->value('Kennung');
        if ($KennungVonPassword == NULL)
            return redirect()->route('konto', ['fehler_menu'=>'Falsches Passwort']);



        $newPassword = DB::table('benutzer')
            ->where('Kennung', $KennungVonPassword)
            ->update(['Password' => $request->npassword]);

        if($newPassword)
            return redirect()->route('konto', ['info'=>'Passwort wurde geändert']);
        else
            return redirect()->route('konto', ['fehler_menu'=>'Fehler bei Passwort']);

    }
}

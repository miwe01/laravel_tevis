<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\benutzer;
use App\Models\module;



class PruefungsamtController extends Controller
{
    // Dashboard Methode
    public function index(Request $request){

        // letzten 5 Benutzer
        $benutzer = new benutzer(); $kennung = $benutzer->last5Users();
//        $passwort = Hash::make('passwort');
//
//        echo $passwort;

        // Alle Module aus DB
        $wintermodule = new module(); $wintermodule = $wintermodule->getWintermodule();
        $sommermodule = new module(); $sommermodule = $sommermodule->getSommerModule();
        // Gibt Dashboard zurück mit allen Fehlern/Info, Module und letzten 5 Benutzer
        return view('Pruefungsamt.dashboard',['lastAdded'=>$kennung, 'WinterModule'=>$wintermodule, 'SommerModule' =>
            $sommermodule, 'title'=>'Dashboard', 'info'=>$request->info, 'fehler'=>$request->fehler]);
    }


    public function benutzerAdd(Request $request){
        if ($request->has('addPerson')){
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

            // Füge Person hinzu. Gibt Fehler zurück wenn es Benutzer schon gibt
            $uB = new benutzer(); $uniqueBenutzer = $uB->BenutzerAdd($request);

            // Benutzer gibt es schon
            if ($uniqueBenutzer == 1)
                return redirect()->route('dashboard', ['fehler'=>trans('Benutzer gibt es schon')]);
            if ($uniqueBenutzer == 2)
                return redirect()->route('dashboard', ['fehler'=>trans('Fehler aufgetreten')]);

            return redirect()->route('dashboard');
        }
    }

    public function fileUpload(Request $request){
        $file = $request->file('file');
        if($file->getSize() == 0){
            return redirect()->route('dashboard', ['fehler'=> trans('Datei leer')]);
        }
        if($file->getClientOriginalExtension() != "csv"){
            return redirect()->route('dashboard', ['fehler'=>trans('Keine CSV Datei')]);
        }

        $fileArray = [];
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            while (!feof($handle)) {
                $line = fgets($handle);
                //dd($line);
                $str = explode(";", $line);
                if (count($str) != 7)
                    return redirect()->route('dashboard', ['fehler'=>trans('Format soll: Kennung;Email;Nachname;Vorname;Studiengang;Matrielnummer sein')]);
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
            return redirect()->route('dashboard', ['info'=>trans('Datei wurde importiert')]);
        }
        else
            return redirect()->route('dashboard', ['fehler'=>trans('Fehler beim Öffnen')]);
    }

    public function klausurZulassung(Request $request){
        if ($request->modul == "")
            return redirect()->route('dashboard', ['fehler'=>trans('Kein Modul ausgewählt')]);

        // ist matrikelnummer überhaupt richtig
        $matrikelnummer = DB::table('student')->where('Matrikelnummer', $request->matrikelnummer)->value("Matrikelnummer");
        if($matrikelnummer == NULL)
            return redirect()->route('dashboard', ['fehler'=>trans('Matrikelnummer ist falsch')]);

        $testatid = DB::table('testat')->where('Modulnummer', $request->modul)->value("ID");
        //kein Testat von Modul => zugelassen
        if ($testatid == NULL){
            return redirect()->route('dashboard', ['info'=>trans('Modul hat kein Testat, automatische Klausurzulassung')]);
        }
        else{
            $matrikelnummer = (int) $request->matrikelnummer;

            // checkt ob User Endtestat hat
            $checktestat = DB::table('testat AS t')
                ->join('testatverwaltung AS tv', 't.ID', '=', 'tv.TestatID')
                ->where([
                ['Modulnummer', $request->modul],
                ['Matrikelnummer', $matrikelnummer],
                ['Praktikumsname', "Endtestat"],
                ['Testat', '1']
                ])->value("Matrikelnummer");

            if ($checktestat == $matrikelnummer){
                return redirect()->route('dashboard', ['info'=>trans('Student ist zugelassen')]);
            }
            else{
                return redirect()->route('dashboard', ['fehler'=>trans('Student ist nicht zugelassen')]);
            }
        }
    }
    public function klausurZulassungen(Request $request){
        // wenn kein Modul ausgewählt wurde

        if ($request->modul == NULL){
            return redirect()->route('dashboard', ['fehler'=>trans('Kein Modul ausgewählt')]);
        }

        $file = $request->file('file');
        if($file->getSize() == 0){
            return redirect()->route('dashboard', ['fehler'=>trans('Datei leer')]);
        }
        if($file->getClientOriginalExtension() != "csv"){
            return redirect()->route('dashboard', ['fehler'=>trans('Keine CSV Datei')]);
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
            return redirect()->route('dashboard', ['fehler'=>trans('Fehler beim Öffnen')]);
        fclose($handle);

        // alle Matrikelnummern
        $matrikelnummern = array_shift($matrikelnummern);
        $matrikelnummern = array_map('intval', $matrikelnummern);

        // modullnummer und das testat
        $testatid = DB::table('testat')->where('Modulnummer', $request->modul)->value('ID');
        //dd($testatid);
        //kein Testat von Modul => zugelassen
        if ($testatid == NULL){
            return redirect()->route('dashboard', ['info'=>trans('Alle Studenten sind zugelassen, weil es kein Testat gibt')]);
        }

        //dd($matrikelnummern);


        $geschafft = DB::table('testat AS t')
            ->leftJoin('modul as m', 't.Modulnummer', 'm.Modulnummer')
            ->whereColumn('t.Jahr', '=', 'm.Jahr')
            ->join('testatverwaltung AS tv', 't.ID', 'tv.TestatID')
            ->whereIn(
            'tv.Matrikelnummer', $matrikelnummern
            )
            ->where('Praktikumsname', 'Endtestat')
            ->where(
                't.Modulnummer', $request->modul
            )
            ->where('Testat', 1)
            ->pluck('Matrikelnummer');

        $geschafft = $geschafft->unique();
        //dd($geschafft);

        // diese Matrikelnummer werden herausgenommen später aus dem Array $matrikelnummers
        $nichtGeschafft = [];
        // nimmt Matrikel aus geschafft um später zu finden welche nicht geschafft sind
        foreach ($geschafft as $testat=>$value){
            $nichtGeschafft[] = $value;
        }
        // array => nur int werte
        $nichtGeschafft = array_map('intval', $nichtGeschafft);

        // löscht jetzt alles Matrikelnummer aus $matrikelnummer und dadurch weiss man welche man noch nicht geschafft hat
        $nichtGeschafft = array_diff($matrikelnummern, $nichtGeschafft);

        // Modulinformationen
        $modul = DB::table('modul')->select('Modulname')->where('Modulnummer', $request->modul)->first();

        return view('Pruefungsamt.klausurZulassungenListe', ['title'=> 'Testate', 'Modul'=> $modul->Modulname,'Geschafft' => $geschafft, 'NichtGeschafft'=> $nichtGeschafft]);

    }

    public function praktikumAnerkennen(Request $request){
        if (!is_numeric($request->matrikelnummer))
            return redirect()->route('dashboard', ['fehler'=>trans('Keine Matrikelnummer')]);
        if ($request->modul == "")
            return redirect()->route('dashboard', ['fehler'=>trans('Kein Modul ausgewählt')]);

        // gibt modulnummer zurück
        // $modulnummer = DB::table("Modul")->where("Modulname", $request->modul)->value("Modulnummer");
        // bekommt Id von Reihe mit "Endtestat" -> wenn fehler dann Modul hat kein Endtestat
        $endtestatid = DB::table('testat')
            ->where('Modulnummer', $request->modul)
            ->value("ID");

        if($endtestatid == NULL)
            return redirect()->route('dashboard', ['fehler'=>trans('Modul hat kein Testat')]);

        $endtestatid = DB::table('testat')
            ->where('Modulnummer', $request->modul)
            ->where('Praktikumsname', 'Endtestat')
            ->value("ID");

        if($endtestatid == NULL)
            return redirect()->route('dashboard', ['fehler'=>trans('Modul hat kein Endtestat')]);

        // ARBK = ID->5
        // DBWT2020 = ID->10
        // DBWT2019 = ID->15
        //dd($endtestatid);




        //dd($endtestatid);

        $check = DB::table('testatverwaltung')
            ->where('TestatID', $endtestatid)
            ->where('Matrikelnummer', $request->matrikelnummer)
            ->value('Matrikelnummer');
            if ($check == NULL)
                return redirect()->route('dashboard', ['fehler'=>trans('Benutzer hat kein Modul mit dem Testat')]);



        $check = DB::table('testatverwaltung')
            ->where('TestatID', $endtestatid)
            ->update(['Testat' => 1]);


        if ($check == 0)
            return redirect()->route('dashboard', ['info'=>trans('Testat ist schon bestanden')]);
        //dd($check);
        return redirect()->route('dashboard', ['info'=>trans('Testat bestanden')]);
    }

    public function Testatbogen(Request $request){
        // fehler sonst bei wechseln von Sprache
        // session erstellt
        if (isset($request->matrikelnummer)){
            $_SESSION["testatbogen"] = $request->matrikelnummer;
        }

        if (!isset($_SESSION["testatbogen"]))
            return redirect()->route('dashboard', ['fehler'=>trans('Keine Matrikelnummer')]);

        /* SELECT * FROM testatverwaltung, testat, modul WHERE Matrikelnummer=2359263 AND testat.ID = testatverwaltung.ID; */
        $testatbogen = DB::table('testat AS t')
            ->select('t.Modulnummer', 'Modulname', 'Semester', 'm.Jahr', 'Testat')
            ->leftJoin('modul as m', 't.Modulnummer', '=', 'm.Modulnummer')
            ->whereColumn('t.Jahr', '=', 'm.Jahr')
            ->join('testatverwaltung AS tv', 't.ID', 'tv.TestatID')
            ->where('tv.Matrikelnummer', $_SESSION["testatbogen"])
            ->where('Praktikumsname', 'Endtestat')
            ->orderBy('Modulname', 'asc')
            ->orderBy('m.Jahr', 'asc')
            //->groupBy("m.Modulnummer")
            ->get();



        if ($testatbogen->isEmpty())
            return redirect()->route('dashboard', ['info'=>trans('Benutzer hat keine Testate')]);
        //dd($testatbogen);

        //dd($testatbogen);
        return view('Pruefungsamt.testatbogen', ['title'=>'Testatbogen','Testatbogen'=>$testatbogen, 'Student'=>$_SESSION["testatbogen"]]);
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
            return redirect()->route('konto', ['fehler_menu'=>trans('Passwort ist nicht gesetzt')]);

        $KennungVonPassword = DB::table('benutzer')
            ->where('Kennung', $_SESSION['PA_UserId'])
            ->value('Password');

     //dd(Hash::make('test..123'));
//       dd($KennungVonPassword);
//      dd($request->opassword);
        if (Hash::check($request->opassword, $KennungVonPassword)) {
                $newPassword = Hash::make($request->npassword);

            DB::table('benutzer')
                ->where('Kennung', $_SESSION['PA_UserId'])
                ->update(['Password' => $newPassword]);
            return redirect()->route('konto', ['info'=>trans('Passwort wurde geändert')]);
        }

        return redirect()->route('konto', ['fehler_menu'=>trans('Fehler bei Passwort')]);

    }
}

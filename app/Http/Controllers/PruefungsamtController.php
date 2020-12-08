<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PruefungsamtController extends Controller
{
    public function index(Request $request){
        /*
        if($request->submit == "Check"){
            $this->check($request);
        }*/

        /*
        if (!empty($request->error)){
            phpAlert($request->error)->withErrors($request);
        }*/
        $kennung = DB::table('benutzer')->select('Nachname', 'Vorname')->orderBy('erfasst_am', 'desc')->take(5)->get();
        return view('Pruefungsamt.dashboard',['fehler'=>$request->fehler, 'lastAdded'=>$kennung, 'check'=>'hallo']);

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
            // insert Benutzer
            DB::table('benutzer')->insert(
              ['Kennung'=>$request->kennung, 'Email'=>$request->email, 'Vorname'=>$request->vorname,
               'Nachname'=>$request->nachname, 'Password'=>'123456'
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
                if (count($str) != 6)
                    return redirect()->route('dashboard', ['fehler'=>'Format soll: Kennung;Email;Nachname;Vorname;Studiengang;Matrielnummer sein']);
                array_push($fileArray, $str);
            }

            for ($i=0;$i<count($fileArray);$i++){

                $kennung = $fileArray[$i][0];
                $email = $fileArray[$i][1];
                $nachname = $fileArray[$i][2];
                $vorname = $fileArray[$i][3];
                $studiengang = $fileArray[$i][4];
                $matrikelnummer = $fileArray[$i][5];
                echo $matrikelnummer;
                // ignoriert Duplikate
                DB::table('benutzer')->insertOrIgnore(
                    ['Kennung'=>$kennung, 'Email'=>$email, 'Vorname'=>$vorname,
                        'Nachname'=>$nachname, 'Password'=>'123456'
                    ]
                );

                DB::table('student')->insertOrIgnore(
                    ['Kennung'=>$kennung, 'Studiengang'=>'INF', 'Matrikelnummer'=>$matrikelnummer]
                );

            }
            return redirect()->route('dashboard', ['fehler'=>'Datei wurde importiert']);
        }
        else
            return redirect()->route('dashboard', ['fehler'=>'Fehler beim Öffnen']);
    }

    public function klausurZulassung(Request $request){

        $modulnummer = DB::table("Modul")->where("Modulname", $request->modul)->value("Modulnummer");

        $testat = DB::table('testat')->where('Modulnummer', $modulnummer)->first();
        //kein Testat von Modul => zugelassen
        //dd($testat);
        if ($testat == NULL){
            return redirect()->route('dashboard', ['fehler'=>'Student ist zugelassen']);
        }
        else{
            $testatid = (int) $testat->ID;
            $matrikelnummer = (int) $request->matrikelnummer;
            //dd($testatid);
            //dd($request->matrikelnummer);
            //echo $testatid . " " . $matrikelnummer;
            // get Id from testat
           //$testat = DB::table('testat')->select("ID")->where('Modulnummer', $request->modul)->first();

            //testatverwaltung
            $checktestat = DB::table('testatverwaltung')->where([
                ['TestatID', $testatid],
                ['Matrikelnummer', $matrikelnummer]
            ])->value("Testat");
            //dd($checktestat);
            if ($checktestat == 1){
                return redirect()->route('dashboard', ['fehler'=>'Student ist zugelassen']);
            }
            else{
                return redirect()->route('dashboard', ['fehler'=>'Student ist nicht zugelassen']);
            }
        }
        //$kennung = DB::table('benutzer')->where('Kennung', $request->kennung)->first();
    }

}

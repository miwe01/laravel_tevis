<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ProfessorController extends Controller
{

    public function index(Request $request){
        $aktuellesJahr = date("Y");
        $kurse = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->where(function($q) use ($aktuellesJahr) {
                $q->where('modul.Jahr', '=', $aktuellesJahr-1)
                    ->orWhere('modul.Jahr', '=', $aktuellesJahr);
            })
            ->where('professor.kennung',$_SESSION['Prof_UserId'])
            ->orderBy('modul.Modulname')
            ->get();

        $gruppen = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('professorbetreutgruppen', 'professorbetreutgruppen.ProfessorID', '=', 'professor.Kennung')
            ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'professorbetreutgruppen.GruppenID')
            ->whereColumn('gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->where(function($q) use ($aktuellesJahr) {
                $q->where('modul.Jahr', '=', $aktuellesJahr-1)
                    ->orWhere('modul.Jahr', '=', $aktuellesJahr);
            })
            ->whereColumn('gruppe.Jahr', '=', 'modul.Jahr')
            ->where('professor.kennung',$_SESSION['Prof_UserId'])
            ->orderBy('gruppe.Gruppenummer')
            ->get();

        $haupt = DB::table('benutzer')
            ->select('Email', 'Vorname', 'Nachname', 'tutorbetreutgruppen.Hauptbetreuer', 'tutorbetreutgruppen.GruppenID', 'tutor.Webexraum')
            ->leftJoin('tutorbetreutgruppen','benutzer.Kennung','=','tutorbetreutgruppen.TutorID')
            ->leftJoin('tutor', 'tutor.Kennung', '=', 'benutzer.Kennung')
            ->where('tutorbetreutgruppen.Hauptbetreuer', '=', 1)
            ->get();


        return view('Professor.dashboard', ['kurse'=> $kurse, 'gruppen' => $gruppen , 'title' => 'Dashboard', 'haupt' => $haupt]);
    }

    public function meineKurse(Request $request){
        $aktuellesJahr = date("Y");
        if (isset($request->löschen))
        {
            DB::table('gruppe')
                ->where('Gruppenummer', $request->Gruppenummer)
                ->delete();
        }
        $kurse = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->where('professor.kennung',$_SESSION['Prof_UserId'])
            ->orderBy('modul.Modulname')
            ->get();

        $gruppen = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->RightJoin('gruppe', 'gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn('gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->whereColumn('gruppe.Jahr', '=', 'modul.Jahr')
            ->where('professor.kennung',$_SESSION['Prof_UserId'])
            ->orderBy('gruppe.Gruppenummer')
            ->get();



        return view('Professor.meine_kurse', ['kurse' => $kurse, 'gruppen' => $gruppen, 'title' => 'Meine Kurse']);
    }

    public function newCourse(Request $request)
    {
        $aktuellesJahr = date("Y");
        return view('Professor.new_course', ['aktuellesJahr'=> $aktuellesJahr,'title'=>'Neuen Kurs hinzufügen']);
    }

    public function createCourse(Request $request) {

        DB::beginTransaction();
        try {
            DB::table('modul')
                ->insert([
                    'Modulnummer' => $request->Modulnummer,
                    'Modulname' => $request->ModulName,
                    'Raum' => $request->Raum,
                    'Semester' => $request->Semester,
                    'Jahr' => $request->Jahr,
                ]);

            DB::table('benutzerhatmodul')
                ->insert([
                    'BenutzerID' => $_SESSION['Prof_UserId'],
                    'ModulID' => $request->Modulnummer,
                    'Jahr' => $request->Jahr,
                    'Rolle' => "Professor"
                ]);

            $msg = "Neuer Kurs wurde angelegt!";

        } catch (\Exception $e) {
            DB::rollback();
            $msg = "Fehler beim Anlegen des Kurses!";
        }
        DB::commit();


        $aktuellesJahr = date("Y");

        return view('Professor.new_course', ['aktuellesJahr'=> $aktuellesJahr, 'msg' => $msg,'title'=>'Neuen Kurs hinzufügen']);
    }

    public function kursverwaltung(Request $request){

        $msg=null;

        $vorhanden = DB::table('benutzerhatmodul')
            ->where('ModulID', $request->Modulnummer )
            ->where('BenutzerID', $request->BenutzerID)
            ->where('Jahr',$request->Jahr)
            ->where('Rolle','Beteiligter Professor')
            ->get();

        if (isset($request->Hinzufügen)) {

            DB::beginTransaction();
            try {
                if($vorhanden->isEmpty())
                {
                    DB::table('benutzerhatmodul')
                        ->insert(['ModulID' => $request->Modulnummer, 'Jahr' => $request->Jahr,
                            'BenutzerID' => $request->BenutzerID, 'Rolle' => 'Beteiligter Professor']);
                    $msg = "Professor wurde beigefügt!";
                }
                else {
                    DB::table('benutzerhatmodul')
                        ->where('ModulID', $request->Modulnummer)
                        ->where('Jahr', $request->Jahr)
                        ->where('Rolle' , 'Beteiligter Professor')
                        ->where('BenutzerID' , $request->BenutzerID)
                        ->delete();
                    $msg = "Professor wurde gelöscht!";
                }
            } catch (\Exception $e) {
                DB::rollback();
                $msg = "Fehler!";
            }
            DB::commit();
        }
        if(isset($request->student_hinzu)) {
            $ex = DB::table('student')
                ->select('Kennung')
                ->where('Matrikelnummer', '=', $request->Matrikel)
                ->value('Kennung');


            $vergleich = DB::table('benutzerhatmodul')
                ->where('BenutzerID', '=', $ex)
                ->where('ModulID', '=', $request->Modulnummer)
                ->where('Jahr', '=', $request->Jahr)
                ->get();



            if ($vergleich->isEmpty()) {
                DB::beginTransaction();
                try {
                    DB::table('benutzerhatmodul')
                        ->insert(['BenutzerID' => $ex, 'ModulID' => $request->Modulnummer, 'Jahr' => $request->Jahr, 'Rolle' => 'Student']);
                    $msg = "Student wurde hinzugefüg!";
                } catch (\Exception $e) {
                    DB::rollback();
                    $msg = "Fehler beim Student hinzufügen!";
                }
                DB::commit();

            } else {
                $msg = "Student schon vorhanden!";
            }
        }


        $leiter = DB::table('benutzerhatmodul')
            ->where('benutzerhatmodul.ModulID', '=',$request->Modulnummer)
            ->where('benutzerhatmodul.Jahr', '=',$request->Jahr)
            ->where('benutzerhatmodul.Rolle', '=','Professor')
            ->leftJoin('benutzer', 'benutzer.kennung','=', 'benutzerhatmodul.BenutzerID')
            ->get();

        $kursverwaltung = DB::table('benutzerhatmodul')
            ->where('benutzerhatmodul.ModulID', '=',$request->Modulnummer)
            ->where('benutzerhatmodul.Jahr', '=',$request->Jahr)
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->get();

        $professor = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung','=', 'professor.kennung')
            ->get();

        $beteiligt = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung','=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul','benutzerhatmodul.BenutzerID', '=','benutzer.kennung')
            ->get();

        if (isset($request->testat_anlegen)) {
            $abfrage = DB::table('testat')
                ->where(['Modulnummer' => $request->Modulnummer,
                    'Jahr' => $request->Jahr])
                ->get();


            if($abfrage->isEmpty())
            {
                DB::beginTransaction();
                try {
                    for ($i = 0; $i < $request->Testatanzahl; $i++) {
                        DB::table('testat')
                            ->insert(['Praktikumsnummer' => $i + 1, 'Modulnummer' => $request->Modulnummer,
                                'Jahr' => $request->Jahr, 'Praktikumsname' => 'Praktikum ' . ($i + 1)]);
                    }

                    DB::table('testat')
                        ->insert(['Praktikumsnummer' => $request->Testatanzahl +1, 'Modulnummer' => $request->Modulnummer, 'Jahr' => $request->Jahr, 'Praktikumsname' => 'Joker']);

                    DB::table('testat')
                        ->insert(['Praktikumsnummer' => $request->Testatanzahl + 2, 'Modulnummer' => $request->Modulnummer, 'Jahr' => $request->Jahr, 'Praktikumsname' => 'Endtestat']);
                    $msg = "Neues Testat wurde angelegt!";
                } catch (\Exception $e) {
                    DB::rollback();
                    $msg = "Fehler beim Anlegen des Testates!";
                }
                DB::commit();
            }
            else{$msg = "Fehler Testat schon vorhanden!";


            }
        }

        if (isset($request->kurs_delete)) {

            DB::table('modul')
                ->where('Modulnummer', $request->Modulnummer)
                ->where('Jahr', $request->Jahr)
                ->delete();
            $kurse = DB::table('professor')
                ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
                ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
                ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
                ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
                ->where('professor.kennung',$_SESSION['Prof_UserId'])
                ->orderBy('modul.Modulname')
                ->get();


            return view('Professor.meine_kurse', ['kurse' => $kurse, 'title' => 'Meine Kurse']);
        }

        return view('Professor.kursverwaltung',
            ['title' => 'Modul','kursverwaltung' => $kursverwaltung, 'leiter' => $leiter, 'beteiligt' =>$beteiligt, 'professor'=> $professor, 'msg' => $msg]);
    }

    public function Gruppe_erstellen(Request $request){
        $msg = null;
        if (isset($request->submit))
        {
            DB::beginTransaction();
            try {
                $createdGroupNumber = DB::table('gruppe')
                    ->insert([
                        'Gruppenname' => $request->Gruppenname,
                        'Modulnummer' => $request->Modulnummer,
                        'Jahr' => $request->Jahr,
                        'Webex' => $request->Webex,
                        'Tag'  => $request->Tag,
                        'Uhrzeit'  => $request->Uhrzeit,
                        'Intervall'  => $request->Intervall
                    ]);
                $msg = "Neue Gruppe wurde angelegt!";

            } catch (\Exception $e) {
                DB::rollback();
                $msg = "Fehler beim Anlegen des Gruppe!";
            }
            DB::commit();

        }

        return view('Professor.new_group',
            ['title'=>'Neue Gruppe hinzufügen', 'msg' => $msg, 'Modulnummer' => $request->Modulnummer, 'Jahr' => $request->Jahr]);
    }










    public function gruppenuebersicht(Request $request)
    {

        $studenten = DB::table('student')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer', '=', 'student.Matrikelnummer')
            ->join('gruppe', 'gruppe.gruppenummer', '=', 'studenteningruppen.GruppenID')
            ->where('gruppe.gruppenummer', $request->Gruppenummer)
            ->get();
        $abc = null;
        if(isset($request->search))
        {
            $studenten = DB::table('student')
                ->leftJoin('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
                ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer','=', 'student.Matrikelnummer')
                ->join('gruppe', 'gruppe.gruppenummer', '=','studenteningruppen.GruppenID' )
                ->where('gruppe.gruppenummer',$request->Gruppenummer)
                ->where(function($q) use ($request) {
                    $q->where("Vorname", "LIKE", "%{$request->term}%")
                        ->orWhere("Nachname", "LIKE", "%{$request->term}%");
                })
                ->get();
        }

        if ($studenten->isEmpty()) {
            $studenten = DB::table('student')
                ->leftJoin('benutzer', 'benutzer.kennung', '=', 'student.kennung')
                ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer', '=', 'student.Matrikelnummer')
                ->join('gruppe', 'gruppe.gruppenummer', '=', 'studenteningruppen.GruppenID')
                ->where('gruppe.gruppenummer', $request->Gruppenummer)
                ->get();
            if (isset($request->search)) {
                $abc = "Gesuchter Student ist nicht vorhanden";
            }
        }
        $testat = DB::table('testat')
            ->join('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
            ->join('modul', 'modul.Modulnummer', '=', 'testat.Modulnummer')
            ->join('student', 'student.Matrikelnummer', '=', 'testatverwaltung.Matrikelnummer')
            ->join('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
            ->whereColumn('testat.Jahr', '=', 'modul.Jahr')
            ->where('modul.Modulname',$request->Modulname)
            ->where('modul.Jahr',$request->Jahr)
            ->get();

        $betreuer = DB::table('tutor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'tutor.kennung')
            ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID', '=', 'tutor.kennung')
            ->join('gruppe', 'gruppe.gruppenummer', '=', 'tutorbetreutgruppen.GruppenID')
            ->where('gruppe.gruppenummer', $request->Gruppenummer)
            ->get();

        $betreuerp = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('professorbetreutgruppen', 'professorbetreutgruppen.professorID', '=', 'professor.kennung')
            ->join('gruppe', 'gruppe.gruppenummer', '=', 'professorbetreutgruppen.GruppenID')
            ->where('gruppe.gruppenummer', $request->Gruppenummer)
            ->get();


        return view('Professor.gruppenuebersicht',['testat'=>$testat,'studenten'=>$studenten,'gruppenname' => $request->Gruppenname,
            'modulname' => $request->Modulname, 'betreuer' => $betreuer, 'betreuerp' =>$betreuerp,'jahr' => $request->Jahr,'abc'=>$abc , 'title'=>'Gruppe']);
    }

























































    public function gruppe(Request $request)
    {
        $module = DB::table('modul')
            ->select('Modulnummer', 'Modulname', 'Jahr')
            ->where('modulnummer', '=', $request->Modulnummer)
            ->where('Jahr', $request->Jahr)
            ->get();


        $gruppeninfos = DB::table('gruppe')
            ->select('Gruppenummer', 'Gruppenname')
            ->where('Gruppenummer', $request->Gruppenummer)
            ->get();

        $gruppenNamen = DB::table('gruppe')
            ->select('Gruppenname')
            ->where('Modulnummer', $request->Modulnummer)
            ->where('Jahr', $request->Jahr)
            ->get();

        $gruppen = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('professorbetreutgruppen', 'professorbetreutgruppen.ProfessorID', '=', 'professor.Kennung')
            ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'professorbetreutgruppen.GruppenID')
            ->whereColumn('gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn('benutzerhatmodul.Jahr', '=', 'modul.Jahr')
            ->where('modul.Jahr', '=', 2020)
            ->whereColumn('gruppe.Jahr', '=', 'modul.Jahr')
            ->where('professor.kennung', $_SESSION['Prof_UserId'])
            ->orderBy('gruppe.Gruppenummer')
            ->get();

        $testat = DB::table('testat')
            ->where('Jahr', '=', 2020)
            ->where('Modulnummer', $request->Modulnummer)
            ->get();

        $studenten = DB::table('student')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer', '=', 'student.Matrikelnummer')
            ->join('gruppe', 'gruppe.gruppenummer', '=', 'studenteningruppen.GruppenID')
            ->where('gruppe.gruppenummer', $request->Gruppenummer)
            ->where('gruppe.Modulnummer', $request->Modulnummer)
            ->orderBy('student.Matrikelnummer')
            ->get();

        $gruppennummer = $request->Gruppenummer;
        $betreuer = DB::table('benutzer')
            ->select('tutorbetreutgruppen.Hauptbetreuer AS THaupt', 'professorbetreutgruppen.Hauptbetreuer AS PHaupt', 'benutzer.Kennung', 'benutzer.email',
                'benutzer.Vorname', 'benutzer.Nachname', 'gruppe.Gruppenummer', 'tutorbetreutgruppen.TutorID', 'professorbetreutgruppen.ProfessorID', 'tutor.Rolle',
                'tutor.Webexraum', 'gruppe.Gruppenname', 'gruppe.Modulnummer', 'gruppe.webex', 'gruppe.jahr', 'gruppe.tag', 'gruppe.uhrzeit', 'benutzer.Email')
            ->leftJoin("tutorbetreutgruppen", function ($join) use ($gruppennummer) {
                $join->on("tutorbetreutgruppen.TutorID", "=", "benutzer.kennung")
                    ->where('tutorbetreutgruppen.GruppenID', '=', $gruppennummer);
            })
            ->leftJoin('professorbetreutgruppen', 'professorbetreutgruppen.ProfessorID', '=', 'benutzer.kennung')
            ->leftJoin('tutor', 'Benutzer.Kennung', '=', 'tutor.Kennung')
            ->join("gruppe", function ($join) {
                $join->on("gruppe.gruppenummer", "=", "professorbetreutgruppen.GruppenID")
                    ->orOn('gruppe.gruppenummer', '=', "tutorbetreutgruppen.GruppenID");
            })
            ->where('gruppe.gruppenummer', $request->Gruppenummer)
            ->orderBy('Rolle', 'ASC')
            ->orderBy('professorbetreutgruppen.Hauptbetreuer', 'DESC')
            ->orderBy('tutorbetreutgruppen.Hauptbetreuer', 'DESC')
            ->get();


        foreach ($module as $mods) {
            $modul = $mods;
        }


        return view('Professor.gruppe', ['studenten' => $studenten, 'modul' => $modul, 'betreuer' => $betreuer,
            'modulnummer' => $request->Modulnummer, 'jahr' => $request->Jahr, 'Gruppenummer' => $request->Gruppenummer,
            'gruppeninfo' => $gruppeninfos, 'gruppen' => $gruppen, 'GruppenName' => $gruppenNamen, 'testat' => $testat, 'title' => 'Gruppe']);
    }




    public function tutorLoeschen(Request $request){
        //11111
        // checkt ob Professor oder Tutor ist
        $tablename = "";
        $id = "";
        if (isset($request->professor)){
            $tablename ="professorbetreutgruppen";
            $id = "ProfessorID";
        } else{
            $tablename ="tutorbetreutgruppen";
            $id = "TutorID";
        }

        //dd($request->Gruppennummer);
        //dd($tablename);
        // checkt ob Tutor/Professor gruppe betreut
        $betreut=DB::table($tablename)
            ->where($id, $request->Kennung)
            ->where('GruppenID', $request->Gruppennummer)
            ->get();

        if(!empty($betreut)) {
            DB::table($tablename)
                ->where($id, '=', $request->Kennung)
                ->where('GruppenID', '=', $request->Gruppennummer)
                ->delete();
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr, 'info'=>'Benutzer wurde gelöscht']);
        }else{
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr, 'Fehler aufgetreten']);
        }
    }


    public function studentenAusGruppeLoeschen(Request $request){
        DB::table('studenteningruppen')
            ->where('GruppenID', '=', $request->GruppenID)
            ->where('Matrikelnummer', '=', $request->Matrikelnummer)
            ->delete();

        return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr]);
    }


    public function studentZuGruppe(Request $request){

        $ex=db::table('student')
            ->select('Kennung')
            ->where('Matrikelnummer','=',$request->Matrikelnummer)
            ->value('Kennung');

        // checkt ob Student im Modul ist
        $benutzerinModul=db::table('benutzerhatmodul')
            ->select('BenutzerID')
            ->where('BenutzerID','=',$ex)
            ->where('ModulID', '=', $request->Modulnummer)
            ->where('Jahr', '=', $request->Jahr)
            ->get();

        //dump($ex);
        // Wenn Matrikelnummer in Datei existiert und Benutzer ist in Modul
        if($ex != NULL && sizeof($benutzerinModul)>0) {

            $ingruppe = db::table('studenteningruppen')
                ->where('GruppenID', '=', $request->GruppenID)
                ->where('Matrikelnummer', '=', $request->Matrikelnummer)
                ->get();

            if (sizeof($ingruppe)==0) {

                DB::table('studenteningruppen')
                    ->insert([
                        'GruppenID' => $request->GruppenID,
                        'Matrikelnummer' => $request->Matrikelnummer
                    ]);
                return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr,'info'=>'Student ist jetzt in Gruppe']);

            } else {
                return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr,  'info'=>'Student ist bereits in Gruppe']);
            }
        }else{

            return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr, 'fehler'=>'Kein gültige Matrikelnummer']);
        }
    }

    public function studentenZuGruppe(Request $request){
        $file = $request->file('studenten');

        // Wenn keine Datei oder keine CSV -> zurück auf gruppe view
        if($file->getSize() == 0){
            return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr, 'fehler'=>'Datei ist leer']);
        }
        if($file->getClientOriginalExtension() != "csv"){
            return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr, 'fehler'=>'Keine CSV Datei']);
        }

        // liest Matrikelnummern aus Datei aus
        $file = file_get_contents($file);
        // macht Matrikelnummer in einen Array
        $studentenarray = explode(";", $file);
        //dump($studentenarray);

        for($i=0;$i<count($studentenarray);$i++){
            // gibt Kennung von Student zurück
            $ex=db::table('student')
                ->select('Kennung')
                ->where('Matrikelnummer','=',$studentenarray[$i])
                ->value('Kennung');
            //dump($ex);

            // checkt ob Student im Modul ist
            $benutzerinModul=db::table('benutzerhatmodul')
                ->select('BenutzerID')
                ->where('BenutzerID','=',$ex)
                ->where('ModulID', '=', $request->Modulnummer)
                ->where('Jahr', '=', $request->Jahr)
                ->get();


            //dump($ex);
            // Wenn Matrikelnummer in Datei existiert und Benutzer ist in Modul
            if($ex != NULL && sizeof($benutzerinModul)>0) {
                $ingruppe = db::table('studenteningruppen')
                    ->where('GruppenID', '=', $request->GruppenID)
                    ->where('Matrikelnummer', '=', $studentenarray[$i])
                    ->get();

                //dump($ingruppe);

                if (sizeof($ingruppe)==0) {
                    DB::table('studenteningruppen')
                        ->insertOrIgnore([
                            'GruppenID' => $request->GruppenID,
                            'Matrikelnummer' => $studentenarray[$i]
                        ]);
                }


            }

        }
        // dd('check');
        return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr, 'info'=>'Datei wurde importiert']);
    }

    Public function studentVerschieben(Request $request){
        DB::table('studenteningruppen')
            ->where('GruppenID', '=', $request->altGruppenID)
            ->where('Matrikelnummer', '=', $request->Matrikelnummer)
            ->delete();
        $this->studentZuGruppe($request);
        return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr, 'info'=>'Student wurde verschoben']);
    }



    public function betreuerZuGruppe(Request $request){
        $ex=db::table('tutor')
            ->select('Kennung')
            ->where('Kennung','=',$request->TutorID)
            ->get();

        $prof=db::table('professor')
            ->select('Kennung')
            ->where('Kennung','=',$request->TutorID)
            ->get();

        if(sizeof($ex)>0 || sizeof($prof)>0) {
            $id = "";
            $tablename = "";
            // wenn tutor ist
            if (sizeof($ex)>0)
            {
                $id = "TutorID";
                $tablename = "tutorbetreutgruppen";
            }else{
                $id = "ProfessorID";
                $tablename = "professorbetreutgruppen";
            }



            $ingruppe = db::table($tablename)
                ->where('GruppenID', '=', $request->Gruppennummer)
                ->where($id, '=', $request->TutorID)
                ->get();

            if (sizeof($ingruppe)==0) {
                DB::table($tablename)
                    ->insert([
                        'GruppenID' => $request->Gruppennummer,
                        $id => $request->TutorID
                    ]);
                return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr, 'info'=>'Betreuer hinzugefügt']);
            } else {
                return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr, 'info'=>'Betreuer gibt es schon']);
            }
        }else{
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr, 'fehler'=> 'Keine gültige Kennung']);
        }
    }

    public function betreuerinGruppenHinzu(Request $request){
        // Kennung von Tutor
        $ex=db::table('tutor')
            ->select('Kennung')
            ->where('Kennung','=',$request->TutorID)
            ->get();

        $prof=db::table('professor')
            ->select('Kennung')
            ->where('Kennung','=',$request->TutorID)
            ->get();

        // Wenn Tutor/Professor existiert
        if(sizeof($ex)>0 || sizeof($prof)>0) {
            $id = "";
            $tablename = "";
            // Wenn Professor
            if (sizeof($prof)>0){
                $id = "ProfessorID";
                $tablename = "professorbetreutgruppen";
            }
            // Wenn Tutor
            else{
                $id = "TutorID";
                $tablename = "tutorbetreutgruppen";
            }

            // Kennung von Tutor/Professor
            //dump($request->gruppen);
            //dd($request->gruppen);

            $checkboxen = $request->gruppen;

            // Gruppen in der Tutor/Professor hinzugefügt werden kann
            $gruppenNamen =  DB::table('gruppe')
                ->select('Gruppenummer')
                ->where('Modulnummer',$request->Modulnummer)
                ->where('Jahr', $request->Jahr)
                ->get();
            //dd($gruppenNamen[1]->Gruppenummer);
            //dd($gruppenNamen);

            // keine Checkbox ausgewählt
            if ($checkboxen == NULL)
                return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer, 'Jahr' => $request-> Jahr, 'fehler'=>'Keine Checkbox ausgewählt']);


            for ($i=0;$i<count($checkboxen);$i++){
                // if Checkbox angeklickt
                if ($checkboxen[$i] == "on"){

                    // wenn tutor/professor schon gruppe betreut
                    $ingruppe = db::table($tablename)
                        ->where('GruppenID', '=', $gruppenNamen[$i]->Gruppenummer)
                        ->where($id, '=', $request->TutorID)
                        ->get();

                    //dd($ingruppe);

                    // wenn tutor noch nicht gruppe betreut
                    if (sizeof($ingruppe)==0) {

                        DB::table($tablename)
                            ->insert([
                                'GruppenID' => $gruppenNamen[$i]->Gruppenummer,
                                $id => $request->TutorID
                            ]);

                    }
                }
            }

            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer, 'Jahr' => $request-> Jahr, 'info'=>'Erfolgreich']);

        } else{
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer, 'Jahr' => $request-> Jahr, 'fehler'=>'Betreuer gibt es nicht']);
        }






        $ex=db::table('tutor')
            ->select('Kennung')
            ->where('Kennung','=',$request->TutorID)
            ->get();

        if(sizeof($ex)>0) {
            $ingruppe = db::table('tutorbetreutgruppen')
                ->where('GruppenID', '=', $request->Gruppennummer)
                ->where('TutorID', '=', $request->TutorID)
                ->get();

            if (sizeof($ingruppe)==0) {
                DB::table('tutorbetreutgruppen')
                    ->insert([
                        'GruppenID' => $request->Gruppennummer,
                        'TutorID' => $request->TutorID
                    ]);
                return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr]);
            } else {
                return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr]);
            }
        }else{
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr]);
        }



        return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr, 'info'=> 'Hauptbetreuer aktualisiert']);
    }


    public function ansprechperson(Request $request){
        DB::table("tutorbetreutgruppen")
            ->where('GruppenID', $request->Gruppennummer)
            ->update(['Hauptbetreuer' => 0]);
        DB::table("professorbetreutgruppen")
            ->where('GruppenID', $request->Gruppennummer)
            ->update(['Hauptbetreuer' => 0]);





        if (isset($request->PKennung))

        {
            DB::table('professorbetreutgruppen')
                ->where('GruppenID', $request->Gruppenummer)
                ->where('ProfessorID', $request->PKennung)
                ->update(['Hauptbetreuer' => 1]);

        }
        elseif(isset($request->TKennung))

        {

            DB::table('tutorbetreutgruppen')
                ->where('GruppenID', $request->Gruppenummer)
                ->where('TutorID', $request->TKennung)
                ->update(['Hauptbetreuer' => 1]);
        }

        return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppenummer, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr]);
    }

    public function testat(Request $request)
    {
        $testat = DB::table('testat')
            ->join('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
            ->join('modul', 'modul.Modulnummer', '=', 'testat.Modulnummer')
            ->join('student', 'student.Matrikelnummer', '=', 'testatverwaltung.Matrikelnummer')
            ->join('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
            ->where('student.Matrikelnummer', $request->Matrikelnummer)
            ->whereColumn('testat.Jahr', '=', 'modul.Jahr')
            ->where('modul.Modulname',$request->Modulname)
            ->where('modul.Jahr',$request->Jahr)
            ->get();

        if(isset($request->Testat))
        {
            $counter = 0;
            foreach ($request->Testatcomment as $try)
            {
                if((isset($request->Testat[$counter])) && ($request->Testat[$counter] == $try))
                {
                    DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID',$try)
                        ->update(['testatverwaltung.Testat' => 1]);
                    ++$counter;
                }
                else
                {
                    DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID', $try)
                        ->update(['testatverwaltung.Testat' => 0]);
                }
            }
        }

        $counter1 = 0;
        if(isset($request->Testatcomment))
        {
            foreach ($request->Testatcomment as $try)
            {

                DB::table('testatverwaltung')
                    ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                    ->where('testatverwaltung.TestatID', $try)
                    ->update(['testatverwaltung.Kommentar' => $request->comment[$counter1]]);

                $counter1++;
            }
        }

        DB::beginTransaction();
        try {
            $counter2 = 0;
            if(isset($request->Testatcomment))
            {
                foreach ($request->Testatcomment as $try)
                {
                    DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID', $try)
                        ->update(['testatverwaltung.Benotung' => $request->note[$counter2]]);
                    $counter2++;
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
        }
        DB::commit();


        $testat = DB::table('testat')
            ->join('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
            ->join('modul', 'modul.Modulnummer', '=', 'testat.Modulnummer')
            ->join('student', 'student.Matrikelnummer', '=', 'testatverwaltung.Matrikelnummer')
            ->join('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
            ->where('student.Matrikelnummer', $request->Matrikelnummer)
            ->whereColumn('testat.Jahr', '=', 'modul.Jahr')
            ->where('modul.Modulname',$request->Modulname)
            ->where('modul.Jahr',$request->Jahr)
            ->get();


        return view('Professor.testat',['testat'=>$testat, 'gruppenname' => $request->Gruppenname,   'modulname' => $request->Modulname,'title'=>'testat']);
    }


    public function betreuerHinzufu(Request $request){
        $ex=db::table('tutor')
            ->select('Kennung')
            ->where('Kennung','=',$request->TutorID)
            ->get();

        if(sizeof($ex)>0) {

            $ingruppe = db::table('tutorbetreutgruppen')
                ->where('GruppenID', '=', $request->GruppenID)
                ->where('TutorID', '=', $request->TutorID)
                ->get();

            if (sizeof($ingruppe)==0) {
                DB::table('tutorbetreutgruppen')
                    ->insert([
                        'GruppenID' => $request->GruppenID,
                        'TutorID' => $request->TutorID
                    ]);
                return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr]);
            } else {
                return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr]);
            }
        }else{
            return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr]);
        }
    }


}

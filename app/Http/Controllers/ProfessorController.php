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

        $kurse = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->where('modul.Jahr', '=', 2020)
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
            ->where('modul.Jahr', '=', 2020)
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
        $leiter = DB::table('benutzerhatmodul')
            ->where('benutzerhatmodul.ModulID', '=',$request->Modulnummer)
            ->where('benutzerhatmodul.Jahr', '=',$request->Jahr)
            ->where('benutzerhatmodul.BenutzerID', '=',$_SESSION['Prof_UserId'])
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
            DB::table('professorbetreutgruppen')
                ->insert([
                    'ProfessorID' => $_SESSION['Prof_UserId'],
                    'GruppenID' => $createdGroupNumber,
                ]);

        }

        return view('Professor.new_group',
            ['title'=>'Neue Gruppe hinzufügen', 'msg' => $msg, 'Modulnummer' => $request->Modulnummer, 'Jahr' => $request->Jahr]);
    }







    public function gruppe(Request $request){
        $module = DB::table('modul')
            ->select('Modulnummer', 'Modulname', 'Jahr')
            ->where('modulnummer', '=', $request->Modulnummer)
            ->where('Jahr', $request->Jahr)
            ->get();

        $gruppeninfos = DB::table('gruppe')
            ->select('Gruppenummer', 'Gruppenname')
            ->where('Gruppenummer',$request->Gruppenummer)
            ->get();

        $gruppen = DB::table('professor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('professorbetreutgruppen', 'professorbetreutgruppen.ProfessorID', '=', 'professor.Kennung')
            ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'professorbetreutgruppen.GruppenID')
            ->whereColumn('gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->where('modul.Jahr', '=', 2020)
            ->whereColumn('gruppe.Jahr', '=', 'modul.Jahr')
            ->where('professor.kennung',$_SESSION['Prof_UserId'])
            ->orderBy('gruppe.Gruppenummer')
            ->get();

        $testat = DB::table('testat')
            ->where('Jahr', '=', 2020)
            ->where('Modulnummer',$request->Modulnummer)
            ->get();

        $studenten = DB::table('student')
            ->leftJoin('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer','=', 'student.Matrikelnummer')
            ->join('gruppe', 'gruppe.gruppenummer', '=','studenteningruppen.GruppenID' )
            ->where('gruppe.gruppenummer',$request->Gruppenummer)
            ->where('gruppe.Modulnummer',$request->Modulnummer)
            ->orderBy('student.Matrikelnummer')
            ->get();

        $betreuer = DB::table('tutor')
            ->leftJoin('benutzer' ,'benutzer.kennung', '=', 'tutor.kennung')
            ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID','=', 'tutor.kennung')
            ->join('gruppe', 'gruppe.gruppenummer', '=','tutorbetreutgruppen.GruppenID' )
            ->where('gruppe.gruppenummer',$request->Gruppenummer)
            ->orderBy('tutor.Kennung')
            ->get();


        foreach($gruppeninfos as $ginfos){
            $gruppeninfo = $ginfos;
        }

        foreach($module as $mods){
            $modul = $mods;
        }


        return view('Professor.gruppe_bearbeiten',['studenten'=>$studenten, 'modul' =>$modul, 'betreuer' => $betreuer,
            'modulnummer' => $request->Modulnummer,'jahr' => $request->Jahr,'gruppennummer' => $request->Gruppenummer,
            'gruppeninfo' => $gruppeninfo, 'gruppen'=>$gruppen, 'testat' => $testat,'title'=>'Gruppe']);
    }







    public function tutorLoeschen(Request $request){
        $betreut=DB::table('tutorbetreutgruppen')
            ->where('TutorID', $request->Kennung)
            ->where('GruppenID', $request->Gruppennummer)
            ->get();

        if(!empty($betreut)) {
            DB::table('tutorbetreutgruppen')
                ->where('TutorID', '=', $request->Kennung)
                ->where('GruppenID', '=', $request->Gruppennummer)
                ->delete();
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr]);
        }else{
            return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr]);
        }
    }


    Public function studentenAusGruppeLoeschen(Request $request){
        DB::table('studenteningruppen')
            ->where('GruppenID', '=', $request->GruppenID)
            ->where('Matrikelnummer', '=', $request->Matrikelnummer)
            ->delete();

        return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr]);
    }


    public function studentZuGruppe(Request $request){

        $ex=db::table('student')
            ->select('Matrikelnummer')
            ->where('Matrikelnummer','=',$request->Matrikelnummer)
            ->get();



        if(sizeof($ex)>0) {

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


    Public function studentVerschieben(Request $request){
        DB::table('studenteningruppen')
            ->where('GruppenID', '=', $request->altGruppenID)
            ->where('Matrikelnummer', '=', $request->Matrikelnummer)
            ->delete();
        $this->studentZuGruppe($request);
    }


    public function betreuerZuGruppe(Request $request){
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
    }

    public function ansprechperson(Request $request){
        DB::table('tutorbetreutgruppen')
            ->where('GruppenID', $request->Gruppennummer)
            ->update(['Hauptbetreuer' => 0]);
        DB::table('tutorbetreutgruppen')
            ->where('GruppenID', $request->Gruppennummer)
            ->where('TutorID', $request->Kennung)
            ->update(['Hauptbetreuer' => 1]);
        return redirect()->route('gruppe',['Gruppenummer'=>$request->Gruppennummer, 'Modulnummer'=>$request->Modulnummer,
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
                return redirect()->route('kurs',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr]);
            } else {
                return redirect()->route('kurs',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                    'Jahr' => $request-> Jahr]);
            }
        }else{
            return redirect()->route('kurs',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
                'Jahr' => $request-> Jahr]);
        }
    }















    public function gruppeLoeschen(Request $request){
        //echo 'noooooom';
        echo $request->GruppenID;

        DB::table('gruppe')
            ->where('Gruppenummer', $request->GruppenID)
            ->delete();

        return redirect()->route('kurs');
    }

    public function KursLoeschen(Request $request){
        DB::table('modul')
            ->where('Modulnummer', $request->GruppenID)
            ->delete();

        return redirect()->route('Professor');
    }
}

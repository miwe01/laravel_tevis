<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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


        return view('Professor.dashboard', ['kurse'=>$kurse, 'gruppen' => $gruppen , 'title' => 'Dashboard']);
    }


    public function gruppe(Request $request){
        $modul = DB::table('modul')
            ->select('Modulnummer', 'Modulname')
            ->where('modulnummer', '=', $request->Modulnummer)
            ->get();

        $gruppeninfo = DB::table('gruppe')
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
            ->get();

        $betreuer = DB::table('tutor')
            ->leftJoin('benutzer' ,'benutzer.kennung', '=', 'tutor.kennung')
            ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID','=', 'tutor.kennung')
            ->join('gruppe', 'gruppe.gruppenummer', '=','tutorbetreutgruppen.GruppenID' )
            ->where('gruppe.gruppenummer',$request->Gruppenummer)
            ->get();

        return view('Professor.gruppe_bearbeiten',['studenten'=>$studenten, 'modul' =>$modul, 'betreuer' => $betreuer,
            'modulnummer' => $request->Modulnummer,'jahr' => $request->Jahr,'gruppennummer' => $request->Gruppenummer,
            'gruppeninfo' => $gruppeninfo, 'gruppen'=>$gruppen, 'testat' => $testat,'title'=>'Gruppe']);
    }


    public function kurs(Request $request){
        $gruppen = DB::table('gruppe')
            ->where('Modulnummer', '=', $request->Modulnummer)
            ->get();

        return view('Professor.kurs', ['titel' => 'Modul', 'gruppen' => $gruppen]);
    }


    public function meineKurse(Request $request){
        $kurse = DB::table('modul')
            ->join('benutzerhatmodul', 'BenutzerID', '=', 'ModulID')
            ->get();

        return view('Professor.meine_kurse', ['kurse' => $kurse, 'titel' => 'Meine Kurse']);
    }


    public function tutorLoeschen(Request $request){
        $betreut=DB::table('tutorbetreutgruppen')
            ->where('Kennung','=',$request->Kennung)
            ->where('GruppenID','=',$request->Gruppennummer)
            ->get();

        if(!empty($betreut)) {
            DB::table('tutorbetreutgruppen')
                ->where('Kennung', '=', $request->Kennung)
                ->where('GruppenID', '=', $request->Gruppennummer)
                ->delete();
            return redirect()->route('/Professor/gruppe', ['info'=>'Betreuer wurde aus dieser Gruppe gelöscht']);
        }else{
            return redirect()->route('/Professor/gruppe', ['warning'=>'Betreuer war nicht Teil dieser Gruppe']);
        }
    }


    Public function studentenAusGruppeLoeschen(Request $request){
        if(!empty($betreut)) {
            foreach ($request->studenten as $student) {
                DB::table('studenteningruppen')
                    ->where('GruppenID', '=', $student->GruppenID)
                    ->where('Matrikelnummer', '=', $student->Matrikelnummer)
                    ->delete();
            }
            return redirect()->route('/Professor/gruppe', ['info'=>'Studenten wurden aus der Gruppe entfernt']);
        }else{
            return redirect()->route('/Professor/gruppe', ['warning'=>'Kein Student in dieser Gruppe war ausgewählt']);
        }
    }


    public function testat(Request $request){

    }


    public function studentZuGruppe(Request $request){

        $ex=db::table('student')
            ->select('Matrikelnummer')
            ->where('Matrikelnummer','=',$request->Matrikelnummer)
            ->get();

        if(!empty($ex)) {

            $ingruppe = db::table('studenteningruppen')
                ->where('GruppenID', '=', $request->GruppenID)
                ->where('Matrikelnummer', '=', $request->Matrikelnummer)
                ->get();

            if (empty($ingruppe)) {
                DB::table('studenteningruppen')
                    ->insert([
                        'GruppenID' => $request->GruppenID,
                        'Matrikelnummer' => $request->Matrikelnummer
                    ]);
                return redirect()->route('/Professor/gruppe', ['info' => 'Studenten wurde hinzugefügt']);
            } else {
                return redirect()->route('/Professor/gruppe', ['warning' => 'Student schon in Gruppe enthalten']);
            }
        }else{
            return redirect()->route('/Professor/gruppe', ['warning' => 'Student existiert nicht']);
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
            ->where('Kennung','=',$request->Kennung)
            ->get();

        if(!empty($ex)) {

            $ingruppe = db::table('tutorbetreutgruppen')
                ->where('GruppenID', '=', $request->GruppenID)
                ->where('TutuorID', '=', $request->Kennung)
                ->get();

            if (empty($ingruppe)) {
                DB::table('tutorbetreutgruppen')
                    ->insert([
                        'GruppenID' => $request->GruppenID,
                        'TutorID' => $request->Kennung
                    ]);
                return redirect()->route('/Professor/gruppe', ['info' => 'Tutor wurde hinzugefügt']);
            } else {
                return redirect()->route('/Professor/gruppe', ['warning' => 'Tutor schon in Gruppe enthalten']);
            }
        }else{
            return redirect()->route('/Professor/gruppe', ['warning' => 'Tutor existiert nicht']);
        }
    }


}

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


        return view('Professor.dashboard', ['kurse'=> $kurse, 'gruppen' => $gruppen , 'title' => 'Dashboard']);
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

        //dd($request->Gruppenummer);

        foreach($gruppeninfos as $ginfos){
            $gruppeninfo = $ginfos;
        }

        foreach($module as $mods){
            $modul = $mods;
        }


        return view('Professor.gruppe_bearbeiten',['studenten'=>$studenten, 'modul' =>$module, 'betreuer' => $betreuer,
            'modulnummer' => $request->Modulnummer,'jahr' => $request->Jahr,'gruppennummer' => $request->Gruppenummer,
            'gruppeninfo' => $gruppeninfos, 'gruppen'=>$gruppen, 'testat' => $testat,'title'=>'Gruppe']);
    }


    public function kurs(Request $request){
        $module = DB::table('modul')
            ->select('Modulnummer','Modulname','Raum','Semester', 'Jahr')
            ->where('Modulnummer', '=', $request->Modulnummer)
            ->where('Jahr', $request->Jahr)
            ->get();
        $gruppen = DB::table('gruppe')
            ->where('Modulnummer', '=', $request->Modulnummer)
            ->get();

        $gruppe = DB::table('professor')
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

        $TNanzahl = DB::table('benutzerhatmodul')
            ->where('BenutzerID', '=', $_SESSION['Prof_UserId'])
            ->leftJoin('gruppe','gruppe.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('studenteningruppen','studenteningruppen.GruppenID', '=', 'gruppe.Gruppenummer')
            //->where('gruppe.Gruppenummer', '=', 'benutzerhatmodul.GruppenID')
            ->groupBy('gruppe.Jahr')
            ->get();
      //  echo $TNanzahl;
         echo $module;

        return view('Professor.kurs', ['titel' => 'Modul','Modulnummer' => $request->Modulnummer,'jahr' => $request->Jahr,'gruppennummer' => $request->Gruppenummer,'module'=>$module, 'gruppen' => $gruppen,'gruppe'=>$gruppe,'TNanzahl'=>$TNanzahl]);
    }



    public function meineKurse(Request $request){
//        $kurse = DB::table('professor')
//            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'professor.kennung')
//            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
//            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
//            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
//            ->where('professor.kennung',$_SESSION['Prof_UserId'])
//            ->orderBy('modul.Modulname')
//            ->groupBy('modul.Jahr')
//            ->get();
        $kurse = DB::table('benutzerhatmodul')
            ->where('BenutzerID', '=', $_SESSION['Prof_UserId'])
            ->leftJoin('modul','modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->groupBy(['modul.Jahr'])
            ->get();

        $TNanzahl = DB::table('benutzerhatmodul')
            ->where('BenutzerID', '=', $_SESSION['Prof_UserId'])
            ->leftJoin('gruppe','gruppe.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('studenteningruppen','studenteningruppen.GruppenID', '=', 'gruppe.Gruppenummer')
            ->select('studenteningruppen.Matrikelnummer')
            ->groupBy('gruppe.Gruppenname')
            ->distinct()
            ->get();

        echo $TNanzahl;

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

        for ($i = 0; $i < count($kurse); $i++) {
            $kursModuleNummer =  $kurse[$i]->Modulnummer;
            $kurse[$i]->mengeDerGruppen = 0;

            for ($x = 0; $x < count($gruppen); $x++) {
                $gruppenNummer = $gruppen[$x]->Modulnummer;

                if ($kursModuleNummer == $gruppenNummer) {
                    $kurse[$i]->mengeDerGruppen++;
                }
            }
        }




        return view('Professor.meine_kurse', ['kurse' => $kurse, 'title' => 'Meine Kurse', 'gruppen' => $gruppen,'TNanzahl'=>$TNanzahl]);
    }

    Public function studentenAusGruppeLoeschen(Request $request){
        DB::table('studenteningruppen')
            ->where('GruppenID', '=', $request->GruppenID)
            ->where('Matrikelnummer', '=', $request->Matrikelnummer)
            ->delete();

        return redirect()->route('gruppe',['Gruppenummer'=>$request->GruppenID, 'Modulnummer'=>$request->Modulnummer,
            'Jahr' => $request-> Jahr]);
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



    public function testat(Request $request){

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


    public function newGroup(Request $request){

        return view('Professor.new_group');
    }

    public function createGroup(Request $request) {
        $createdGroupNumber = DB::table('gruppe')
            ->insertGetId([
                'Gruppenname' => $request->groupName,
                'Modulnummer' => $request->moduleNumber,
                'Jahr' => $request->year,
                'Webex' => $request->webexLink,
            ]);

        DB::table('professorbetreutgruppen')
            ->insert([
                'ProfessorID' => $_SESSION['Prof_UserId'],
                'GruppenID' => $createdGroupNumber,
            ]);

        return redirect()->route('Professor');
    }


    public function KursLoeschen(Request $request){
        DB::table('modul')
            ->where('Modulnummer', $request->GruppenID)
            ->delete();

        return redirect()->route('Professor');
    }


    public function BeteiligProf(Request $request){

    }

}

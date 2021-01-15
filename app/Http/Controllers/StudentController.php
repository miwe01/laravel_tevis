<?php

namespace App\Http\Controllers;

use Redirect;
use PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    public function index(Request $Modulnummer)
    {


        $dash = DB::table('student')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer', '=', 'student.Matrikelnummer')
            ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'studenteningruppen.GruppenID')
            ->whereColumn('gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn('benutzerhatmodul.Jahr', '=', 'modul.Jahr')
            ->whereColumn('gruppe.Jahr', '=', 'modul.Jahr')
            ->where('student.Kennung', $_SESSION['Student_UserId'])
            ->orderBy('modul.Modulname')
            ->get();

        return view('Student.dashboard', ['student' => $dash, 'title' => 'main']);


    }


    public function show(Request $student)
    {
        $modul = DB::table('benutzerhatmodul')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->whereColumn('benutzerhatmodul.Jahr', '=', 'modul.Jahr')
            ->where('benutzerhatmodul.BenutzerID', $_SESSION['Student_UserId'])
            ->leftJoin('student', 'student.kennung', '=', 'benutzerhatmodul.BenutzerID')
            ->leftJoin('testat', 'testat.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn('testat.Jahr', '=', 'modul.Jahr')
            ->where('testat.Praktikumsname', '=', 'Endtestat')
            ->leftJoin('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
            ->whereColumn('testatverwaltung.Matrikelnummer', '=', 'student.Matrikelnummer')
            ->get();

        $aktuellesJahr = date("Y");

        return view('Student.testatbogen', ['modul' => $modul, 'aktJahr' => $aktuellesJahr,'title' => 'main']);
    }

    public function testat(Request $request)
    {

        if ($request->Gruppenname == "") return redirect()->route('Student/dashboard', ['fehler' => 'Kein Praktkum vorhanden']);
        else $gruppenname = $request->Gruppenname;


        $testat = DB::table('testat')
            ->join('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
            ->join('modul', 'modul.Modulnummer', '=', 'testat.Modulnummer')
            ->join('student', 'student.Matrikelnummer', '=', 'testatverwaltung.Matrikelnummer')
            ->join('benutzer', 'benutzer.kennung', '=', 'student.kennung')
            ->where('student.kennung', $_SESSION['Student_UserId'])
            ->whereColumn('testat.Jahr', '=', 'modul.Jahr')
            ->where('modul.Modulname', $request->Modulname)
            ->where('modul.Jahr', $request->Jahr)
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



        return view('Student.testat', ['testat' => $testat, 'gruppenname' => $gruppenname, 'betreuer' => $betreuer, 'betreuerp' =>$betreuerp,  'title' => 'testat']);
    }

}


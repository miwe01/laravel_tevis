<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function index()
    {

        $dash = DB::table('tutor')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'tutor.kennung')
            ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID', '=', 'benutzer.kennung')
            ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'tutorbetreutgruppen.GruppenID')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'gruppe.Modulnummer')
            ->whereColumn( 'modul.Jahr' , '=' ,'gruppe.Jahr')
            ->where('tutor.kennung',$_SESSION['WiMi_UserId'])
            ->orderBy('modul.Modulname')
        ->get();

        return view('Tutor.dashboard',['tutor'=>$dash, 'title'=>'main']);
    }

    public function testatverwaltung(Request $request)
    {

        $studenten = DB::table('student')
            ->leftJoin('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer','=', 'student.Matrikelnummer')
            ->join('gruppe', 'gruppe.gruppenummer', '=','studenteningruppen.GruppenID' )
            ->where('gruppe.gruppenummer',$request->Gruppenummer)
            ->get();

        return view('Tutor.testatverwaltung',['studenten'=>$studenten,'gruppenname' => $request->Gruppenname,
            'modulname' => $request->Modulname,'jahr' => $request->Jahr,'title'=>'Gruppe']);
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


        if ($request->submit == 'submit') {
            DB::table('testatverwaltung')
                ->where('testatverwaltung.TestatID', $request->TestatID)
                ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                ->update(['Testat' => $request->Testat, 'Kommentar' => $request->comment]);
        }

        if ($request->submit == 'submit') {
            DB::table('testatverwaltung')
                ->where('testatverwaltung.TestatID', $request->TestatID)
                ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                ->update(['Testat' => $request->check, 'Kommentar' => $request->comment]);
        }

        return view('Tutor.testat',['testat'=>$testat,'gruppenname' => $request->Gruppenname,   'modulname' => $request->Modulname,'title'=>'testat']);
    }
}


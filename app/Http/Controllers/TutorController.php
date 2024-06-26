<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Mockery\Matcher\Not;

class TutorController extends Controller
{
    public function index()
    {

        if (isset($_SESSION['WiMi_UserId']))
        {
            $dash = DB::table('tutor')
                ->leftJoin('benutzer', 'benutzer.kennung', '=', 'tutor.kennung')
                ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID', '=', 'benutzer.kennung')
                ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'tutorbetreutgruppen.GruppenID')
                ->leftJoin('modul', 'modul.Modulnummer', '=', 'gruppe.Modulnummer')
                ->whereColumn( 'modul.Jahr' , '=' ,'gruppe.Jahr')
                ->where('tutor.kennung',($_SESSION['WiMi_UserId']))
                ->orderBy('modul.Modulname')
                ->get();
        }
        else if (isset($_SESSION['HiWi_UserId']))
        {
            $dash = DB::table('tutor')
                ->leftJoin('benutzer', 'benutzer.kennung', '=', 'tutor.kennung')
                ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID', '=', 'benutzer.kennung')
                ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'tutorbetreutgruppen.GruppenID')
                ->leftJoin('modul', 'modul.Modulnummer', '=', 'gruppe.Modulnummer')
                ->whereColumn( 'modul.Jahr' , '=' ,'gruppe.Jahr')
                ->where('tutor.kennung',($_SESSION['HiWi_UserId']))
                ->orderBy('modul.Modulname')
                ->get();
        }
        return view('Tutor.dashboard',['tutor'=>$dash, 'title'=>'main']);
    }

    public function testatverwaltung(Request $request)
    {

        $studenten = DB::table('student')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer', '=', 'student.Matrikelnummer')
            ->join('gruppe', 'gruppe.gruppenummer', '=', 'studenteningruppen.GruppenID')
            ->where('gruppe.gruppenummer', $request->Gruppenummer)
            ->get();
        $msg = null;
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
                $msg = "Gesuchter Student ist nicht vorhanden";
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


        return view('Tutor.testatverwaltung',['testat'=>$testat,'studenten'=>$studenten,'gruppenname' => $request->Gruppenname,
            'modulname' => $request->Modulname,'jahr' => $request->Jahr,'msg'=>$msg , 'title'=>'Gruppe']);
    }


    public function testat(Request $request)
    {


        if(isset($request->Testatcomment)) {
            $counter = 0;
            foreach ($request->Testatcomment as $try) {
                if ((isset($request->Testat[$counter])) && ($request->Testat[$counter] == $try)) {
                    DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID', $try)
                        ->update(['testatverwaltung.Testat' => 1]);

                    $counter++;

                } else {

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



        return view('Tutor.testat',['testat'=>$testat, 'gruppenname' => $request->Gruppenname, 'Gruppenummer'=>$request->Gruppenummer,  'modulname' => $request->Modulname,'title'=>'testat']);


    }
}


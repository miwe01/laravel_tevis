<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
       
        /*
               if(isset($request->Testat))
               {
               foreach ($request->Testat as $try)
               {

                   if($request->Testat)
                   {
                   DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID',!$try)
                        ->update(['testatverwaltung.Testat' => 0]);
                     }
                   else
                   {
                       DB::table('testatverwaltung')
                           ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                           ->where('testatverwaltung.TestatID', $try)
                           ->update(['testatverwaltung.Testat' => 1]);

                   }

               }["11","12","13","14","15"] ["11"]
               }*/

        if(isset($request->Testat))
        {  $counter = 0;
            foreach ($request->Testatcomment as $try)
            {
                if(isset($request->Testat[$counter]) && $request->Testat[$counter] == $try)
                {
                    DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID',$try)
                        ->update(['testatverwaltung.Testat' => 1]);
                }
                else
                {
                    DB::table('testatverwaltung')
                        ->where('testatverwaltung.Matrikelnummer', $request->Matrikelnummer)
                        ->where('testatverwaltung.TestatID', $try)
                        ->update(['testatverwaltung.Testat' => 0]);


                }
                ++$counter;
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

        return view('Tutor.testat',['testat'=>$testat,'test'=> $request->Testatcomment,'test1'=> $request->Testat, 'gruppenname' => $request->Gruppenname,   'modulname' => $request->Modulname,'title'=>'testat']);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Student $Modulnummer)
    {

        $dash = DB::table('student')
            ->leftJoin('benutzer', 'benutzer.kennung', '=', 'student.kennung')
            ->leftJoin('benutzerhatmodul', 'benutzerhatmodul.BenutzerID', '=', 'benutzer.kennung')
            ->leftJoin('modul', 'modul.Modulnummer', '=', 'benutzerhatmodul.ModulID')
            ->leftJoin('studenteningruppen', 'studenteningruppen.Matrikelnummer', '=', 'student.Matrikelnummer')
            ->RightJoin('gruppe', 'gruppe.Gruppenummer', '=', 'studenteningruppen.GruppenID')
            ->whereColumn('gruppe.Modulnummer', '=', 'modul.Modulnummer')
            ->whereColumn( 'benutzerhatmodul.Jahr' , '=' ,'modul.Jahr')
            ->whereColumn('gruppe.Jahr', '=', 'modul.Jahr')
            ->where('student.kennung',$_SESSION['Student_UserId'])
            ->orderBy('modul.Modulname')
            ->get();


        return view('Student.dashboard',['student'=>$dash,  'title'=>'main']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return Application|Factory|View|Response
     */
    public function show(Student $student)
    {
       $testat = DB::table('testat')
            ->join('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
            ->where('testat.Modulnummer', $student->Modulnummer)
            ->where('testat.Jahr', $student->Jahr)
            ->where('testat.Praktikumsnummer', $student->Gruppennummer)
            ->where('testatverwaltung.Matrikelnummer', $student->Matrikelnummer)
            ->get();


        return view('Student.testatbogen',['testat'=>$testat,  'title'=>'main']);
    }

public function testat(Request $request)
{

 if ($request->Gruppenname == "")   return redirect()->route('Student/dashboard', ['fehler'=>'Kein Praktkum vorhanden']);
     else $gruppenname = $request->Gruppenname;


    $testat = DB::table('testat')
        ->join('testatverwaltung', 'testatverwaltung.testatID', '=', 'testat.id')
        ->join('modul', 'modul.Modulnummer', '=', 'testat.Modulnummer')
        ->join('student', 'student.Matrikelnummer', '=', 'testatverwaltung.Matrikelnummer')
        ->join('benutzer' ,'benutzer.kennung', '=', 'student.kennung')
        ->where('student.kennung',$_SESSION['Student_UserId'])
        ->whereColumn('testat.Jahr', '=', 'modul.Jahr')
         ->where('modul.Modulname',$request->Modulname)
        ->where('modul.Jahr',$request->Jahr)
        ->get();

 $betreuer = DB::table('tutor')
     ->leftJoin('benutzer' ,'benutzer.kennung', '=', 'tutor.kennung')
     ->leftJoin('tutorbetreutgruppen', 'tutorbetreutgruppen.TutorID','=', 'tutor.kennung')
     ->join('gruppe', 'gruppe.gruppenummer', '=','tutorbetreutgruppen.GruppenID' )
     ->where('gruppe.gruppenummer',$request->Gruppenummer)
     ->get();


    return view('Student.testat',['testat'=>$testat,'gruppenname' => $gruppenname , 'betreuer'=>$betreuer,'title'=>'testat']);
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return Response
     */
    public function destroy(Student $student)
    {
        //
    }
}

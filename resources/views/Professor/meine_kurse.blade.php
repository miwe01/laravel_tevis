@extends('Template.layout')
@extends('Template.links')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

<h1 class ="meinekurse">Meine Kurse</h1>
<button class="b2"> neuen kurse anlegen </button>

@foreach($kurse as $kurs)

    <div class="grid2">{{ $kurs->Semester }} {{ $kurs->Jahr }}</div>

    <div>
        <ul>
            <li class ="kurse"><a href="Kurs1.html">{{$kurs->Modulname}}</a> </li>
            <br>
            <li class="li1" >an der veranstaltung </li>
            <li>
                menge der gruppen : {{$kurs->mengeDerGruppen}} </li>
            <li> Anzahl der Teilnehmer : {{count($TNanzahl)}}</li>

        </ul>
    </div>
@endforeach
@endsection

@extends('Template.layout')
@extends('Template.links')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

<h1 class ="meinekurse">Meine Kurse</h1>
<button class="b2"> Neuen kurse anlegen </button>

@foreach($kurse as $kurs)

    <div class="grid2">{{ $kurs->Semester }} {{ $kurs->Jahr }}</div>

    <div class="table">
        <ul>
            <li class ="kurse"><a href="Kurs1.html">{{$kurs->Modulname}}</a> </li>
            <br>
            <li class="li1" >an der veranstaltung </li>
            <li>
                Anzahl der Gruppen: {{$kurs->mengeDerGruppen}}</li>
            <li>Anzahl der Teilnehmer: </li>

        </ul>
    </div>
@endforeach
@endsection

@extends('Template.layout')
@extends('Template.links')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

<h1 class ="meinekurse">{{__("Meine Kurse")}}</h1>
<button class="b2">{{__("Neuen Kurs anlegen")}}  </button>

@foreach($kurse as $kurs)

    <div class="grid2">{{ $kurs->Semester }} {{ $kurs->Jahr }}</div>

    <div class="table">
        <ul>
            <li class ="kurse"><a href="Kurs1.html">{{$kurs->Modulname}}</a> </li>
            <br>
            <li class="li1" >{{__("an der Veranstaltung")}}</li>
            <li>
                {{__("Anzahl der Gruppen")}}: {{$kurs->mengeDerGruppen}}}</li>
            <li>{{__("Anzahl der Teilnehmer")}}: </li>

        </ul>
    </div>
@endforeach
@endsection

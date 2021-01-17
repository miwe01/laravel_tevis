@extends('Template.layout')
@extends('Template.links')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

<h1 class ="meinekurse">Meine Kurse</h1>
<form  action="/Professor/kurs/new" method="get" >
    @csrf
    <input type="hidden" value="{{$gruppen[0]->Modulnummer}}" name="GruppenID" id="kursanlegen">
    <button class="b2" type="submit" id="kursanlegen"> neuen kurse anlegen </button>
</form>
@foreach($kurse as $kurs)

    <div class="grid2">{{ $kurs->Semester }} {{ $kurs->Jahr }}</div>

    <div>
        <ul style="text-align: center">
            <li style="margin-left: 10cm">{{$kurs->Modulname}}</li>
            <li>
                Anzahl der Gruppen : {{$kurs->mengeDerGruppen}}</li>
            <li>Anzahl der Teilnehmer : {{count($TNanzahl)}}</li>

        </ul>
    </div>
    <br>
    <br>
@endforeach

@endsection

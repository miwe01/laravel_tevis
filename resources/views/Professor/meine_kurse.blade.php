@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

    <h1 class ="meinekurse">{{__("Meine Kurse")}}Meine Kurse</h1>
    <form  action="/Professor/kurs/new" method="get" >
        @csrf
        <input type="hidden" value="{{$gruppen[0]->Modulnummer}}" name="GruppenID" id="kursanlegen">
        <button class="b2" type="submit" id="kursanlegen">{{__("Neuen Kurs anlegen")}}</button>
    </form>
    @foreach($kurse as $kurs)

        <div class="grid2">{{ $kurs->Semester }} {{ $kurs->Jahr }}</div>

        <div>
            <ul style="text-align: center">
                <li style="margin-left: 10cm">{{$kurs->Modulname}}</li>
                <li>
                    {{__("Anzahl der betreuten Gruppen")}}: {{$kurs->TNanzahl}}</li>
                <li>{{__("Anzahl der beutreuten Teilnehmer")}}: {{$kurs->mengeDerGruppen}}</li>

            </ul>
        </div>
        <br>
        <br>
    @endforeach

@endsection

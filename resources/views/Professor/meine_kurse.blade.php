@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">

    <h1 class ="meinekurse">Meine Kurse</h1>
    <form  action="/Professor/meine_kurse/new" method="post" >
        @csrf
        <input type="hidden" value="Modulnummer" name="Modulnummer" id="kursanlegen">
        <button class="b2" type="submit" id="kursanlegen"> neuen kurse anlegen </button>
    </form>
    <br>
    @forelse($kurse as $kurs)
        <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
            <div><h4 align="center">  {{$kurs->Modulnummer}}  {{$kurs->Modulname}}   {{$kurs->Semester}}  {{$kurs->Jahr}}</h4></div>
            <div>   <form action="/Professor/meine_kurse/kursverwaltung" method="post">
                    @csrf
                    <input type="hidden" value="{{$kurs->Modulnummer}}" name="Modulnummer" id="bearbeiten">
                    <input type="hidden" value="{{$kurs->Jahr}}" name="Jahr" id="bearbeiten">
                    <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("Kursverwaltung")}}">
                </form></div>

            @forelse($gruppen as $gruppe)

                @if ($gruppe->Modulnummer == $kurs->Modulnummer && $gruppe->Jahr == $kurs->Jahr)
                    <details>
                        <summary> {{$gruppe->Gruppenname}}</summary>
                        <ul>
                            <form action="/Professor/gruppe" method="post">
                                @csrf
                                <input type="hidden" value="{{$gruppe->Modulnummer}}" name="Modulnummer" id="bearbeiten">
                                <input type="hidden" value="{{$gruppe->Jahr}}" name="Jahr" id="bearbeiten">
                                <input type="hidden" value="{{$gruppe->Gruppenummer}}" name="Gruppenummer" id="bearbeiten">
                                <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("Gruppenübersicht")}}">
                            </form>
                            <form action="/Professor/meine_kurse" method="post">
                                @csrf
                                <input type="hidden"  value="{{$gruppe->Gruppenummer}} " name="Gruppenummer" id="Testat">
                                <button type="submit"   value="löschen"  name="löschen" id="Testat">{{__("Gruppe löschen")}}</button>
                            </form>
                        </ul>
                    </details>
                @endif
            @empty
                <li>{{__("Keine betreuten Gruppen in diesem Kurs")}}.</li>
            @endforelse

        </div>
        <br>
    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse
@endsection

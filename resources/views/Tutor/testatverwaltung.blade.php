@extends('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1 align="center">{{$modulname}}{{$jahr}}</h1>
    <h1 align="center">{{$gruppenname}}</h1>
    <br>
    <br>


    <form action="/Tutor/dashboard/{{$modulname}}_{{$gruppenname}}" method="post">
        @csrf
        <input type="text"  name="term" id="term">
        <input type="hidden"  value="{{$gruppenname}}" name="Gruppenname" id="search">
        <input type="hidden"  value="{{$studenten[0]->Gruppenummer}}" name="Gruppenummer" id="search">
        <input type="hidden"  value="{{$jahr}}" name="Jahr" id="search">
        <input type="hidden"  value="{{$modulname}}" name="Modulname" id="search">
        <button type="submit"  value="search" name="search" id="search">Suche</button>
    </form>
    <br>
    <table border="2">
        @foreach($studenten as $s)

            <tr>
                @if (isset($_SESSION['WiMi_UserId']))
                    <th style="background-color: #eaeaea">Matrikelnummer</th>
                @endif
                <th style="background-color: #eaeaea">{{__("Vorname")}}</th>
                <th style="background-color: #eaeaea">{{__("Nachname")}}</th>
                @forelse($testat as $t)
                    @if ($t->Matrikelnummer == $s->Matrikelnummer)
                        <th>{{$t->Praktikumsname}}</th>
                    @endif
                @empty
                    <th>Keine Daten vorhanden.</th>
                @endforelse

                <th style="background-color: #eaeaea">{{__("bearbeiten")}}</th>


            </tr>
            <tr>
                @if (isset($_SESSION['WiMi_UserId']))
                    <th>
                        {{$s->Matrikelnummer}}
                    </th>
                @endif
                <th>        {{$s->Vorname}}</th>
                <th>        {{$s->Nachname}}</th>

                @forelse($testat as $t)
                    @if ($t->Matrikelnummer == $s->Matrikelnummer)
                        @if ($t->Testat == 1)
                            <th>&#10004</th>
                        @else
                            <th></th>
                        @endif
                    @endif
                @empty
                    <th>Keine Daten vorhanden.</th>
                @endforelse

                <th><form action="/Tutor/dashboard/{{$modulname}}_{{$s->Gruppenname}}/testat" method="post">
                        @csrf
                        <input type="hidden"  value="{{$s->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
                        <input type="hidden"  value="{{$s->Gruppenname}} " name="Gruppenname" id="Testat">
                        <input type="hidden"  value="{{$s->Gruppenummer}} " name="Gruppennummer" id="Testat">
                        <input type="hidden"  value="{{$s->Jahr}} " name="Jahr" id="Testat">
                        <button type="submit"  value="{{$modulname}} " name="Modulname" id="Testat">{{__("Anzeigen")}}</button>
                    </form></th>
            </tr>
        @endforeach
    </table>
    <br>
    <a href="/Tutor/dashboard">{{__("Zurück zur Übersicht")}}</a>


@endsection

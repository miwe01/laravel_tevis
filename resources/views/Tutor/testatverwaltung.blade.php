@extends('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1 align="center">  {{$modulname}}{{$jahr}}</h1>
    <h1 align="center"> {{$gruppenname}}</h1>
    <br>
    <br>
    <table border="2">
        @foreach($studenten as $s)

            <tr>
                @if (isset($_SESSION['WiMi_UserId']))
                    <th style="background-color: #eaeaea">Matrikelnummer</th>
                @endif
                <th style="background-color: #eaeaea">{{__("Vorname")}}</th>
                <th style="background-color: #eaeaea">{{__("Nachname")}}</th>
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


                <th><form action="/Tutor/dashboard/{{$modulname}}_{{$s->Gruppenname}}/testat" method="post">
                        @csrf
                        <input type="hidden"  value="{{$s->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
                        <input type="hidden"  value="{{$s->Gruppenname}} " name="Gruppenname" id="Testat">
                        <input type="hidden"  value="{{$s->Gruppenummer}} " name="Gruppenummer" id="Testat">
                        <input type="hidden"  value="{{$s->Jahr}} " name="Jahr" id="Testat">
                        <button type="submit"  value="{{$modulname}} " name="Modulname" id="Testat">{{__("Anzeigen")}}</button>
                    </form></th>
            </tr>
        @endforeach
    </table>
    <br>
    <a href="/Tutor/dashboard">{{__("Zurück zur Übersicht")}}</a>


@endsection

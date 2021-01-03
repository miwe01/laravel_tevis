@extends('Template.layout')
@extends('Template.links_hiwi')

@section('main')


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
            <th style="background-color: #eaeaea">Vorname</th>
            <th style="background-color: #eaeaea">Nachname</th>
            <th style="background-color: #eaeaea">Bearbeiten</th>


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
                    <button type="submit"  value="{{$modulname}} " name="Modulname" id="Testat">Anzeigen</button>
                </form></th>



        </tr>
        @endforeach
    </table>
    <br>
    <a href="/Tutor/dashboard">Zurück zur Übersicht</a>


@endsection

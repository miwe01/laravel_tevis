@extends('Template.layout')
@extends('Template.links_professor')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

    <h1 class ="meinekurse">{{$modul[1]->Modulname}} {{$gruppeninfo[0]->Gruppenname}} </h1>


    <div class="grid-container">
        <table class="mitglieder">
            <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Matrikelnummer</th>
                <th>Vorname</th>
                <th>Nachname</th>
                @foreach($testat as $t)
                    <th>{{$t->Praktikumsname}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($studenten as $student)
                <tr>
                    <td><input type="checkbox"> </td>
                    <td>{{$student->Matrikelnummer}}</td>
                    <td>{{$student->Vorname}}</td>
                    <td>{{$student->Nachname}}</td>
                    @foreach($testat as $t)
                        <th><input type="checkbox"></th>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div><button type="button" class="mitte"> Studierenden hinzufügen</button> </div>


    <div class="grid-container">
        <table class="mitglieder">
            <thead>
            <tr>
                <th>Betreuername</th>
                <th>E-Mail Adresse</th>
                <th>Webex Raum</th>
                <th>Werkzeug</th>
            </tr>
            </thead>
            <tbody>
            @foreach($betreuer as $tutor)
                <tr>
                    <td>{{$tutor->Vorname}} {{$tutor->Nachname}}</td>
                    <td><a href="mailto:max.mustermann@alumni.fh-aachen.de">max.mustermann@alumni.fh-aachen.de</a></td>
                    <td><a href="max.mustermann.webex.com">max.mustermann.webex.com</a></td>
                    <td><a href="">Löschen</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div><button type="button" class="mitte"> Betreuer hinzufügen</button> </div>
    </div>
@endsection

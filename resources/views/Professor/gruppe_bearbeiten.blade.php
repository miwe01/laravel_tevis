@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

    <h1 class ="meinekurse">{{$modul[1]->Modulname}} {{$gruppeninfo[0]->Gruppenname}} </h1>


    <div class="grid-container">
        <table class="mitglieder">
            <thead>
            <tr>
                <th>Matrikelnummer</th>
                <th>Vorname</th>
                <th>Nachname</th>
                @foreach($testat as $t)
                    <th>{{$t->Praktikumsname}}</th>
                @endforeach
                <th>Werkzeuge</th>
            </tr>
            </thead>
            <tbody>
            @foreach($studenten as $student)
                <tr>
                    <td>{{$student->Matrikelnummer}}</td>
                    <td>{{$student->Vorname}}</td>
                    <td>{{$student->Nachname}}</td>
                    @foreach($testat as $t)
                        <th><input type="checkbox"></th>
                    @endforeach
                    <td>
                        <form action="/Professor/gruppe/studentloeschen" method="post">
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="GruppenID" id="sloeschen">
                            <input type="hidden" value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="sloeschen">
                            <input type="submit" value="Löschen" name="loeschen" id="sloeschen">
                        </form>
                        <form action="/Professor/gruppe/studentVerschieben" method="post">
                            <select name="gruppenauswahl" id="verschieben" name="GruppenID">
                            @foreach($gruppen as $gruppe)
                                <option value="{{$gruppe->Gruppenummer}}"> {{$gruppe->Gruppenummer}}</option>
                            @endforeach
                            </select>
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="altGruppenID" id="verschieben">
                            <input type="hidden" value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="verschieben">
                            <input type="submit" value="Verschieben" name="verschieben" id="verschieben">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div>
        <form class="mitte" action="/Professor/gruppe/studentHinzu" method="post">
            <input type="text" name="Matrikelnummer" id="hinzu">
            <input type="submit" value="Student hinzufügen" id="hinzu">
        </form>
    </div>


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
                    <td>
                        <form action="/Professor/gruppe/tutorloeschen" method="post">
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="Gruppennummer" id="loeschen">
                            <input type="hidden" value="{{$tutor->Kennung}}" name="Kennung" id="loeschen">
                            <input type="submit" name="loeschen" value="Löschen" id="loeschen">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form class="mitte" action="/Professor/gruppe/betreuerHinzu">
            <input type="text" placeholder="Kennung" name="Kennung" id="betHinzu">
            <input type="submit" name="betHinzu" id="betHinzu">
        </form>
    </div>
@endsection

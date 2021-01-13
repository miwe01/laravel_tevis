@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

    <h1 class ="meinekurse">{{$modul->Modulname}} {{$gruppeninfo->Gruppenname}} </h1>


    <div class="grid-container">
        <table class="mitglieder">
            <thead>
            <tr>
                <th>Matrikelnummer</th>
                <th>Vorname</th>
                <th>Nachname</th>

                <th>Werkzeuge</th>
            </tr>
            </thead>
            <tbody>
            @foreach($studenten as $student)
                <tr>
                    <td>{{$student->Matrikelnummer}}</td>
                    <td>{{$student->Vorname}}</td>
                    <td>{{$student->Nachname}}</td>

                    <td>
                        <form action="/Professor/gruppe/studentloeschen" method="post">
                            @csrf
                            <input type="hidden" value="{{$gruppeninfo->Gruppenummer}}" name="GruppenID" id="sloeschen">
                            <input type="hidden" value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="sloeschen">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="sloeschen">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="sloeschen">
                            <input type="submit" value="Löschen" name="loeschen" id="sloeschen">
                        </form>
                        <form action="/Professor/gruppe/studentVerschieben" method="post">
                            @csrf
                            <select id="verschieben" name="GruppenID">
                                @foreach($gruppen as $gruppe)
                                    <option value="{{$gruppe->Gruppenummer}}"> {{$gruppe->Gruppenummer}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{$gruppeninfo->Gruppenummer}}" name="altGruppenID" id="verschieben">
                            <input type="hidden" value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="verschieben">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="verschieben">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="verschieben">
                            <input type="submit" value="Verschieben" name="verschieben" id="verschieben">
                        </form>
                        <form action="/Professor/gruppe/testat" method="post">
                            @csrf
                            <input type="hidden"  value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
                            <input type="hidden"  value="{{$gruppeninfo->Gruppenname}} " name="Gruppenname" id="Testat">
                            <input type="hidden"  value="{{$gruppeninfo->Gruppenummer}} " name="Gruppenummer" id="Testat">
                            <input type="hidden"  value="{{$modul->Jahr}} " name="Jahr" id="Testat">
                            <button type="submit"  value="{{$modul->Modulname}} " name="Modulname" id="Testat">Testat</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div>
        <form class="mitte" action="/Professor/gruppe/studentHinzu" method="post">
            @csrf
            <input type="text" name="Matrikelnummer" placeholder="Matrikelnummer" id="hinzu">
            <input type="hidden" value="{{$gruppeninfo->Gruppenummer}}" name="GruppenID" id="hinzu">
            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="hinzu">
            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="hinzu">
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
                    <td><a href="mailto:{{$tutor->Email}}">{{$tutor->Email}}</a></td>
                    <td><a href="{{$tutor->Webexraum}}">{{$tutor->Webexraum}}</a></td>
                    <td>
                        <form action="/Professor/gruppe/tutorloeschen" method="post">
                            @csrf
                            <input type="hidden" value="{{$gruppeninfo->Gruppenummer}}" name="Gruppennummer" id="loeschen">
                            <input type="hidden" value="{{$tutor->Kennung}}" name="Kennung" id="loeschen">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="loeschen">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="loeschen">
                            <input type="submit" name="loeschen" value="Löschen" id="loeschen">
                        </form>

                        <form action="/Professor/gruppe/Hauptbetreuer" method="post">
                            @csrf
                            <input type="hidden" value="{{$gruppeninfo->Gruppenummer}}" name="Gruppennummer" id="haupt">
                            <input type="hidden" value="{{$tutor->Kennung}}" name="Kennung" id="haupt">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="haupt">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="haupt">
                            <input type="submit" value="Hauptbetreuer" name="Haupt" id="haupt">
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form class="mitte" action="/Professor/gruppe/betreuerHinzu" method="post">
            @csrf
            <input type="text" placeholder="Kennung" name="TutorID" id="betHinzu">
            <input type="hidden" value="{{$gruppeninfo->Gruppenummer}}" name="Gruppennummer" id="betHinzu">
            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="betHinzu">
            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="betHinzu">
            <input type="submit" value="Betreuer hinzufügen" name="betHinzu" id="betHinzu">
        </form>
    </div>
@endsection

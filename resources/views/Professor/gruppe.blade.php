@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">
    @if(isset($_GET['fehler']))
        <p class="error">{{$_GET['fehler']}}</p>
    @endif
    @if(isset($_GET['info']))
        <p class="info">{{$_GET['info']}}</p>
    @endif
    <h1 class ="meinekurse">{{$modul->Modulname}} {{$gruppeninfo[0]->Gruppenname}} </h1>


    <div class="grid-container">
        <h3>Studenten</h3>
        <table class="mitglieder">
            <thead>
            <tr>
                <th>Matrikelnummer</th>
                <th>{{__("Vorname")}}</th>
                <th>{{__("Nachname")}}</th>

                <th>{{__("Werkzeuge")}}</th>
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
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="GruppenID" id="sloeschen">
                            <input type="hidden" value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="sloeschen">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="sloeschen">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="sloeschen">
                            <input type="submit" value="{{__("Löschen")}}" name="loeschen" id="sloeschen">
                        </form>
                        <form action="/Professor/gruppe/studentVerschieben" method="post">
                            @csrf
                            <select id="verschieben" name="GruppenID">
                                @foreach($gruppen as $gruppe)
                                    <option value="{{$gruppe->Gruppenummer}}"> {{$gruppe->Gruppenname}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="altGruppenID" id="verschieben">
                            <input type="hidden" value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="verschieben">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="verschieben">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="verschieben">
                            <input type="submit" value="{{__("Verschieben")}}" name="verschieben" id="verschieben">
                        </form>
                        <form action="/Professor/gruppe/testat" method="post">
                            @csrf
                            <input type="hidden"  value="{{$student->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
                            <input type="hidden"  value="{{$gruppeninfo[0]->Gruppenname}} " name="Gruppenname" id="Testat">
                            <input type="hidden"  value="{{$gruppeninfo[0]->Gruppenummer}} " name="Gruppenummer" id="Testat">
                            <input type="hidden"  value="{{$modul->Jahr}} " name="Jahr" id="Testat">
                            <button type="submit"  value="{{$modul->Modulname}} " name="Modulname" id="Testat">{{__("Testat")}}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="center">
        <form class="mitte" action="/Professor/gruppe/studentHinzu" method="post">
            @csrf
            <input type="text" name="Matrikelnummer" placeholder="Matrikelnummer" id="hinzu">
            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="GruppenID" id="hinzu">
            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="hinzu">
            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="hinzu">
            <input type="submit" value="{{__("Student hinzufügen")}}" id="hinzu">
        </form>
    </div>

    <div class="center frame">
        <p>Studenten über Datei hinzufügen</p>
        <form class="mitte" action="/Professor/gruppe/studentenHinzu" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="studenten">
            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="GruppenID" id="hinzu">
            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="hinzu">
            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="hinzu">
            <input type="submit" value="Einfügen" id="hinzu">
        </form>
    </div>



    <div class="grid-container">
        <h3>Professor/Betreuer</h3>
        <table class="mitglieder">
            <thead>
            <tr>
                <th>{{__("Betreuername")}}</th>
                <th>{{__("E-Mail Adresse")}}</th>
                <th>{{__("Webex Raum")}}</th>
                <th>{{__("Werkzeug")}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($betreuer as $tutor)

                <tr>
                    <td>
                        @if($tutor->PHaupt == 1||$tutor->THaupt)
                            <b>
                                @endif
                                {{--Professor--}}
                                @if($tutor->Rolle == NULL)
                                    {{"Prof."}}
                                @endif
                                {{$tutor->Vorname}} {{$tutor->Nachname}}
                                @if($tutor->PHaupt == 1||$tutor->THaupt)
                            </b>
                        @endif
                    </td>
                    <td>
                        @if($tutor->PHaupt == 1||$tutor->THaupt)
                            <b>
                                @endif
                                <a href="mailto:{{$tutor->Email}}">{{$tutor->Email}}</a>
                                @if($tutor->PHaupt == 1||$tutor->THaupt)
                            </b>
                        @endif</td>
                    <td>
                        @if($tutor->PHaupt == 1||$tutor->THaupt)
                            <b>
                                @endif
                                <a href="{{$tutor->Webexraum}}">{{$tutor->Webexraum}}</a>
                                @if($tutor->PHaupt == 1||$tutor->THaupt)
                            </b>
                        @endif
                    </td>
                    <td>
                        <form action="/Professor/gruppe/tutorloeschen" method="post">
                            @csrf
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="Gruppennummer" id="loeschen">
                            {{-- Wenn Professor --}}

                            <input type="hidden" value="{{$tutor->ProfessorID}}" name="Kennung" id="loeschen">
                            <input type="hidden" value="{{$tutor->Kennung}}" name="Kennung" id="loeschen">
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="loeschen">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="loeschen">
                            <input type="submit" name="loeschen" value="{{__("Löschen")}}" id="loeschen">
                        </form>
                        <form action="/Professor/gruppe/hauptbetreuer" method="post">
                            @csrf
                            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="Gruppenummer" id="haupt">

                            @if (!empty($tutor->ProfessorID))
                                <input type="hidden" value="{{$tutor->ProfessorID}}" name="PKennung" id="loeschen">
                            @else
                                <input type="hidden" value="{{$tutor->Kennung}}" name="TKennung" id="loeschen">
                            @endif
                            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="haupt">
                            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="haupt">
                            @if($tutor->PHaupt == 1||$tutor->THaupt)
                                <input type="submit" value="{{__("Hauptbetreuer")}}" name="Haupt" id="haupt" disabled>
                            @else
                                <input type="submit" value="{{__("Hauptbetreuer")}}" name="Haupt" id="haupt">
                            @endif

                        </form>

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
    <form class="center" action="/Professor/gruppe/betreuerHinzu" method="post">
        @csrf
        <input type="text" placeholder="Kennung" name="TutorID" id="betHinzu">
        <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="Gruppennummer" id="betHinzu">
        <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="betHinzu">
        <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="betHinzu">
        <input type="submit" value="{{__("Betreuer hinzufügen")}}" name="betHinzu" id="betHinzu">
    </form>
    <div class="center">
        <h3>Betreuer in mehrere Gruppen hinzufügen</h3>
        <form class="mitte" action="/Professor/gruppe/betreuerinGruppenHinzu" method="post">
            @csrf

            @foreach($GruppenName as $gruppe)
                <label><input type="checkbox" name="gruppen[]" id="gruppen">
                    {{$gruppe->Gruppenname}}</label><br>
            @endforeach
            <br><br>
            <input type="text" placeholder="Kennung" name="TutorID" id="betHinzu" value="sp3643s">
            <input type="hidden" value="{{$gruppeninfo[0]->Gruppenummer}}" name="Gruppennummer" id="betHinzu">
            <input type="hidden" value="{{$modul->Modulnummer}}" name="Modulnummer" id="betHinzu">
            <input type="hidden" value="{{$modul->Jahr}}" name="Jahr" id="betHinzu">
            <button name="gruppe">Gruppen hinzufügen</button>
        </form>

    </div>
    <div>
        <form action="/Professor/meine_kurse" method="post">
            @csrf
            <button type="submit">{{__("Zurück zur Kursübersicht")}}</button>
        </form>
    </div>
@endsection

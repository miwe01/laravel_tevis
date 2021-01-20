@extends('Template.layout')
@extends('Template.links')

@section('main')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">
    <h1> Leitender Professor:</h1>
    <h4> {{$leiter[0]->Vorname}} {{$leiter[0]->Nachname}}</h4>
    <h1> Betreuender Professor:</h1>


    <!-- <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_kurs.css")}}"> -->
    @forelse ($beteiligt as $b)
        @if ($b->Rolle == 'Beteiligter Professor' && $b->Jahr == $kursverwaltung[0]->Jahr && $b->ModulID == $kursverwaltung[0]->Modulnummer)
            <h4>{{$b->Vorname}} {{$b->Nachname}}</h4>
        @endif
    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse
    <table>
        <tr>
            <th>Modulnummer</th>
            <th>Erstelldatum</th>
        </tr>
        <tr>
            <th>{{$kursverwaltung[0]->Modulnummer}}</th>
            <th>{{$kursverwaltung[0]->erstellt_am}}</th>
        </tr>


    </table>
    @if (isset($msg))
        <h4>{{$msg}}</h4>
    @endif
    <div style="text-align: center">
        <form action="/Professor/meine_kurse/kursverwaltung" method="post">
            @csrf
            <input type="hidden" value="{{$kursverwaltung[0]->Modulnummer}}" name="Modulnummer" id="bearbeiten">
            <input type="hidden" value="{{$kursverwaltung[0]->Jahr}}" name="Jahr" id="bearbeiten">
            <select name="BenutzerID" id="BenutzerID" required>
                @forelse($professor as $p)
                    @if ($p->Kennung != $leiter[0]->Kennung)
                        <option value="{{$p->Kennung}}">{{$p->Vorname}} {{$p->Nachname}}</option>
                    @endif
                @empty
                    <li>{{__("Keine Daten vorhanden")}}.</li>
                @endforelse
            </select>
            <input type="submit" name="Hinzufügen" id="Hinzufügen" value="{{__("Beteiligten Professor hinzufügen/löschen")}}">
        </form>
        <br>
        <form action="/Professor/meine_kurse/kursverwaltung/gruppe_erstellen" method="post">
            @csrf
            <input type="hidden" value="{{$kursverwaltung[0]->Modulnummer}}" name="Modulnummer" id="bearbeiten">
            <input type="hidden" value="{{$kursverwaltung[0]->Jahr}}" name="Jahr" id="bearbeiten">
            <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("neue Gruppe hinzufügen")}}">
        </form>
        <br>
        <form action="/Professor/meine_kurse/kursverwaltung" method="post">
            @csrf
            <input type="number" name="Testatanzahl" min="1" id="Testatanzahl">
            <input type="hidden" value="{{$kursverwaltung[0]->Modulnummer}}" name="Modulnummer" id="bearbeiten">
            <input type="hidden" value="{{$kursverwaltung[0]->Jahr}}" name="Jahr" id="bearbeiten">
            <input type="submit" name="testat_anlegen" id="testat_anlegen" value="{{__("Testat hinzufügen")}}">
        </form>
        <br>
        <form action="/Professor/meine_kurse/kursverwaltung" method="post">
            @csrf
            <input type="text" name="Matrikel" id="Matrikel">
            <input type="hidden" value="{{$kursverwaltung[0]->Modulnummer}}" name="Modulnummer" id="bearbeiten">
            <input type="hidden" value="{{$kursverwaltung[0]->Jahr}}" name="Jahr" id="bearbeiten">
            <input type="submit" name="student_hinzu" id="student_hinzu" value="{{__("Student hinzufügen")}}">
        </form>

        @if ($leiter[0]->Kennung == $_SESSION['Prof_UserId'])
            <br>
            <form action="/Professor/meine_kurse/kursverwaltung" method="post">
                @csrf
                <input type="hidden" value="{{$kursverwaltung[0]->Modulnummer}}" name="Modulnummer" id="bearbeiten">
                <input type="hidden" value="{{$kursverwaltung[0]->Jahr}}" name="Jahr" id="bearbeiten">
                <input type="submit" name="kurs_delete" id="kurs_delete" value="{{__("Diesen Kurs löschen")}}">
            </form>
        @endif
    </div>
    <br>
    <div>
        <form action="/Professor/meine_kurse" method="post">
            @csrf
            <button type="submit">{{__("Zurück zur Kursübersicht")}}</button>
        </form>
    </div>
@endsection

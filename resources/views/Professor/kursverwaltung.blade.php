@extends('Template.layout')
@extends('Template.links')

@section('main')
    <h1 class ="meinekurse">Leitender Professor: {{$leiter[0]->Vorname}} {{$leiter[0]->Nachname}}</h1>
    @if ($leiter[0]->Rolle == 'Professor')
        <!-- <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_kurs.css")}}"> -->
        @forelse ($beteiligt as $b)
            @if ($b->Rolle == 'Beteiligter Professor')
                {{$b->Vorname}} {{$b->Nachname}}
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
            {{$msg}}
        @endif
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
            <input type="submit" name="Hinzufügen" id="Hinzufügen" value="{{__("Beteiligten Professor hinzufügen")}}">
        </form>

        <form action="/Professor/meine_kurse/kursverwaltung/gruppe_erstellen" method="post">
            @csrf
            <input type="hidden" value="{{$kursverwaltung[0]->Modulnummer}}" name="Modulnummer" id="bearbeiten">
            <input type="hidden" value="{{$kursverwaltung[0]->Jahr}}" name="Jahr" id="bearbeiten">
            <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("bearbeiten")}}">
        </form>
    @else
        Fehlende Berechtigung für diesen Kurs!
    @endif
@endsection

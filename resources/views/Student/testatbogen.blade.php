@extends ('Template.layout')
@section('main')
    @extends('Template.links')

    <h1 align="center">Testatbogen</h1>
    <br>
    <br>
    <br>
    <table border="2">
        <tr>
            <th>{{__("FachNr.")}}</th>
            <th>{{__("Bezeichnung")}}</th>
            <th>{{__("Testat erhalten")}}</th>
            <th>Semester</th>
        </tr>
        @forelse($modul as $m)
            <tr>
                @if ($m->Testat == 1)
                    <th>{{$m->Modulnummer}}</th>
                    <th>{{$m->Modulname}}</th>
                    <th>&#10004</th>
                    <th>{{$m->Jahr}}</th>
                @elseif($m->Testat == 0 && $m->Jahr == 2020)
                    <th>{{$m->Modulnummer}}</th>
                    <th>{{$m->Modulname}}</th>
                    <th></th>
                    <th>{{$m->Jahr}}</th>
                @elseif($m->Testat == 0 && $m->Jahr == $aktJahr)
                    <th>{{$m->Modulnummer}}</th>
                    <th>{{$m->Modulname}}</th>
                    <th></th>
                    <th>{{$m->Jahr}}</th>
                @endif
            </tr>
        @empty
            <li>{{__("Keine Daten vorhanden")}}.</li>
        @endforelse
    </table>
    <br>
    <form action="/Student/testatbogen" method="post">
        @csrf
        <button type="submit" name="pdf_submit" value="pdf_submit">{{__("als pdf speichern")}} </button>
    </form>
    <br>
    <a href="/Student/dashboard">{{__("Zurück zur Übersicht")}}</a>
@endsection

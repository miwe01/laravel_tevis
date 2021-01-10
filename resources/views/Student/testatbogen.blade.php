@extends ('Template.layout')
@section('main')
    @extends('Template.links')

    <h1 align="center">Testatbogen</h1>
    <br>
    <button type="button" align="center">als pdf speichern</button>
    <br>
    <br>
    <br>
    @json($modul)
    <table border="2">
        <tr>
            <th>FachNr.</th>
            <th>Bezeichnung</th>
            <th>Testat erhalten</th>
            <th>Semester</th>
        </tr>

        @foreach($modul as $m)
            <tr>
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                @if ($m->Testat == 1)
                    <th>&#10004</th>
                @else
                    <th></th>
                @endif
                <th>{{$m->Jahr}}</th>
            </tr>
        @endforeach
    </table>
    <br>
    <br>
    <a href="/Student/dashboard">Zurück zur Übersicht</a>




@endsection

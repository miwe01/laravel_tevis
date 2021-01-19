@extends('Template.layout')
@extends('Template.links')

@section('main')
    <h1 class ="meinekurse">Leitender Professor: {{$leiter[0]->Vorname}} {{$leiter[0]->Nachname}}</h1>
@if ($leiter[0]->Rolle == 'Professor')
   <!-- <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_kurs.css")}}"> -->
   @if ($leiter[0]->Rolle == 'begleitenderProfessor')
       {{$leiter[0]->Vorname}} {{$leiter[0]->Nachname}}
   @endif
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

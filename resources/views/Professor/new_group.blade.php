@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">
    <br>
    <h1>{{__("Gruppe hinzufügen")}}</h1>
    <br>

    <form action="/Professor/meine_kurse/kursverwaltung/gruppe_erstellen" method="post">
        @csrf
        <input type="hidden" value="{{$Modulnummer}}" name="Modulnummer" id="bearbeiten">
        <input type="hidden" value="{{$Jahr}}" name="Jahr" id="bearbeiten">

        <label for=Gruppenname>Gruppenname: </label>
        <input type="text" id="Gruppenname" name="Gruppenname" >
        <br><br>
        <label for=Raum>Raum: </label>
        <input type="text" id="Raum" name="Raum" >
        <br><br>
        <label for=Webex>{{__("Webex Link")}}:</label>
        <input type="text" id="Webex" name="Webex">
        <br><br>
        <label for=Start>Starttermin: </label>
        <input type="text" id="Tag" name="Tag">
        <br><br>
        <label for="Uhrzeit">Uhrzeit: </label>
        <input type="time" id="Uhrzeit" name="Uhrzeit">
        <br><br>
        <label for=Intervall>Intervall: </label>
        <select id="Intervall" name="Intervall">
            <option value="täglich">täglich</option>
            <option value="wöchentlich" selected>wöchentlich</option>
            <option value="monatlich">monatlich</option>
        </select>
        <br><br><br>
        <button name="submit" value="1" type="submit">Gruppe hinzufügen </button>
    </form>
    <br>

    @if (isset($msg))
        {{$msg}}
    @endif

@endsection

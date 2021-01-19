@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">

    <h1 style="font-family: 'Arial Black';color: #0c5460;text-align: center">Gruppe Hinzufügen </h1>
    @if (isset($msg))
        {{$msg}}
    @endif
    <form action="/Professor/meine_kurse/kursverwaltung/gruppe_erstellen" method="post">
        @csrf
        <input type="hidden" value="{{$Modulnummer}}" name="Modulnummer" id="bearbeiten">
        <input type="hidden" value="{{$Jahr}}" name="Jahr" id="bearbeiten">

        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Gruppenname">Gruppenname:</label>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" class ="style1 " type="text" id="Gruppenname" name="Gruppenname" >
        <br><br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Raum">Raum</label>
        <input class ="style1 " name="Raum" id="Raum" type="text">
        <br><br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Webex">{{__("Webex Link")}}</label>
        <input  style="background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;"  type="text" id="Webex" name="Webex">
        <br>
        <br>
        <label style="margin-left: 0;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Start"> Start Termin am </label>
        <input style="margin-right: 1cm; background-color: aliceblue; border-color: #0f6674;width: 5cm" id="Tag" name="Tag" type="text">
        <br><br>
        <label style="margin-left: 0;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Uhrzeit"> Uhrzeit </label>
        <input style=" background-color: aliceblue; border-color: #0f6674;width: 3cm; text-align: center;" id="Uhrzeit" name="Uhrzeit" type="time">
        <br><br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Interval">Intervall </label><br>
        <select style=" margin-bottom:0.5cm;background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;"  id="Intervall" name="Intervall">
            <option value="täglich">täglich</option>
            <option value="wöchentlich" selected>wöchentlich</option>
            <option value="monatlich">monatlich</option>
        </select>
        <br>
        <br>
        <button  style="width: 7cm;height: 1cm;background-color: #00b5ad;border-color: #0f6674;font-weight: 30;" name="submit" value="1" type="submit">Gruppe Hinzufügen </button>
    </form>
@endsection

@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

    <h1>Kurs Anlegen</h1>

    @if (isset($msg))
        {{$msg}}
    @endif
    <form action="/Professor/meine_kurse/createCourse" method="post">
        @csrf

        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="ModulName">Module Name:</label>
        <input  class ="style1" type="text" id="ModulName" name="ModulName" >
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Raum">Raum</label>
        <input class ="style1 " name="Raum" id="Raum" type="text">
        <br>
        <label style="font-weight: bolder" for="Modulnummer">Modulnummer </label>
        <input type="number" id="Modulnummer" name="Modulnummer" min="10000" max="99999">
        <br>
        <label style="font-weight: bolder" for="Jahr">Jahr</label>
        <input type="number" id="Jahr" min="{{$aktuellesJahr - 1}}" max="{{$aktuellesJahr + 1}}" name="Jahr">
        <br>
        <label style="font-weight: bolder" for="Semester">Semester</label>
        <input type="text" id="Semester" name="Semester">
        <br>
        <button style="font-weight: bolder ;background-color: cadetblue" type="submit">Kurs Hinzufügen </button>
    </form>
@endsection

@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">
    <br>
    <h1 align="center">{{__("Kurs Anlegen")}}</h1>
    <br>

    @if (isset($msg))
        {{$msg}}
    @endif
    <form action="/Professor/meine_kurse/createCourse" method="post">
        @csrf
        
        <label for=ModulName>Name: </label>
        <input type="text" id="ModulName" name="ModulName" />
        <br>
        <br>
        <label for="Raum">Raum: </label>
        <input type="text" id="Raum" name="Raum" />
        <br>
        <br>
        <label for="Modulnummer">Modulnummer: </label>
        <input type="number" id="Modulnummer" name="Modulnummer" min="10000" max="99999" />
        <br>
        <br>
        <label for="Jahr">Jahr: </label>
        <input type="number" id="Jahr" min="{{$aktuellesJahr - 1}}" max="{{$aktuellesJahr + 1}}" name="Jahr" />
        <br>
        <br>
        <div><label for="Semester">Semester: </label>
        <input type="text" id="Semester" name="Semester" />
        <br>
        <br>
        <button style="font-weight: bolder ;background-color: cadetblue" type="submit">Kurs Hinzufügen </button>

@endsection

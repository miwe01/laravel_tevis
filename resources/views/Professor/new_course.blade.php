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

        <div align="center "class="area">
            <p>{{__("Name")}}: <input  class ="style1" type="text" id="ModulName" name="ModulName" ></p>
            <p>{{__("Raum")}}: <input class ="style1 " name="Raum" id="Raum" type="text"></p>
            <p>{{__("Modulnummer")}}: <input type="number" id="Modulnummer" name="Modulnummer" min="10000" max="99999"></p>
            <p>{{__("Jahr")}}: <input type="number" id="Jahr" min="{{$aktuellesJahr - 1}}" max="{{$aktuellesJahr + 1}}" name="Jahr"></p>
            <p>{{__("Semester")}}: <input type="text" id="Semester" name="Semester"></p>
            <div/>
            <br>
            <button style="font-weight: bolder ;background-color: cadetblue" type="submit">Kurs Hinzufügen </button>
@endsection

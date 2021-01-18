@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

  <h1>{{__("Neuen Kurs anlegen")}}</h1>

    <form action="/Professor/kurs/new" method="post">
        @csrf


        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="coursName">Module Name:</label>
        <input  class ="style1 " n type="text" id="coursName" name="coursName" >
        <br>
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Raum">{{__("Raum")}}</label> <br>
        <input class ="style1 " name="Raum" id="Raum" type="number" value=""><br>
        <br>
        <br>

        <label style="font-weight: bolder" for="moduleNumber">{{__("Modulnummer")}}</label>
        <input type="number" id="moduleNumber" name="moduleNumber">
        <br>
        <br>
        <label style="font-weight: bolder" for="year">{{__("Jahr")}}</label>
        <input type="number" id="year" name="year">
        <br>
        <br>
        <label style="font-weight: bolder" for="semester">Semester</label>
        <input type="text" id="semester" name="semester">
        <br>
        <br>
        <button style="font-weight: bolder ;background-color: cadetblue" type="submit">{{__("Kurs hinzufügen")}}</button>

    </form>
@endsection

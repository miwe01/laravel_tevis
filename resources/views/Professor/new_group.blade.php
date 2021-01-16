@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

  <h1>Create a new group</h1>

    <form action="/Professor/kurs/new/group" method="post">
        @csrf


        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="groupName">Gruppe Name:</label>
        <label style="margin-left: 3cm ;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Raum">Raum</label> <br>
        <input  class ="style1 " n type="text" id="groupName" name="groupName" >
        <input class ="style1 " name="Raum" id="Raum" type="number" value=""><br>
        <br>

        <label for="moduleNumber">Module number</label>
        <input type="number" id="moduleNumber" name="moduleNumber">
        <br>
        <label for="webexLink">Webex Link</label>
        <input type="text" id="webexLink" name="webexLink">
<br>
        <label for="year">Year</label>
        <input type="number" id="year" name="year">
        <br>

        <label style="margin-left: 0;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Start"> Start Termin am </label>
        <label style="margin-left: 3cm;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Uhrzeit"> Uhrzeit </label><br>
        <input style="margin-right: 1cm; background-color: aliceblue; border-color: #0f6674;width: 5cm" id="Start" name="Start" type="date">
        <input   style=" background-color: aliceblue; border-color: #0f6674;width: 3cm; text-align: center;" id="Uhrzeit" name="Uhrzeit" type="time"><br>
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Interval">Intervall </label><br>
        <select style=" margin-bottom:0.5cm;background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;"  id="Interval" name="Interval">
            <option value="tag">Tag</option>
            <option value="woche" selected>Woche</option>
            <option value="monat">Monat</option>
        </select>
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Termin_Anzahl ">Termin Anzahl</label><br>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" id="Termin_Anzahl " name="Termin_Anzahl" type="number"><br>
        <br>
        <button type="submit">Gruppe Hinzufügen </button>

    </form>
@endsection

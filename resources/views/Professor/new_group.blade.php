@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

  <h1 style="font-family: 'Arial Black';color: #0c5460;text-align: center">{{__("Gruppe hinzufügen")}} </h1>

    <form action="/Professor/kurs/new/group" method="post">
        @csrf


        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="groupName">{{__("Gruppename")}}:</label>
        <label style="margin-left: 3cm ;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Raum">{{__("Raum")}}</label> <br>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" class ="style1 " n type="text" id="groupName" name="groupName" >
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" class ="style1 " name="Raum" id="Raum" type="number" value=""><br>
        <br>

        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="moduleNumber">{{__("Modulnummer")}}</label>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" type="number" id="moduleNumber" name="moduleNumber">
        <br>
        <br>

        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="webexLink">{{__("Webex Link")}}</label>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;"  type="text" id="webexLink" name="webexLink">
        <br>
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="year">{{__("Jahr")}}</label>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" type="number" id="year" name="year">
        <br>
        <br>

        <label style="margin-left: 0;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Start">{{__("Start Termin am")}}</label>
        <label style="margin-left: 3cm;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Uhrzeit">{{__("Uhrzeit")}} </label><br>
        <input style="margin-right: 1cm; background-color: aliceblue; border-color: #0f6674;width: 5cm" id="Start" name="Start" type="date">
        <input   style=" background-color: aliceblue; border-color: #0f6674;width: 3cm; text-align: center;" id="Uhrzeit" name="Uhrzeit" type="time"><br>
        <br>
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Interval">{{__("Intervall")}}</label><br>
        <select style=" margin-bottom:0.5cm;background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;"  id="Interval" name="Interval">
            <option value="tag">{{__("Tag")}}</option>
            <option value="woche" selected>{{__("Woche")}}</option>
            <option value="monat">{{__("Monat")}}</option>
        </select>
        <br>
        <br>
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Termin_Anzahl ">{{__("Termin Anzahl")}}</label><br>
        <input  style=" background-color: aliceblue; border-color: #0f6674;width: 5cm; text-align: center;" id="Termin_Anzahl " name="Termin_Anzahl" type="number"><br>
        <br>
        <br>
        <button  style="width: 7cm;height: 1cm;background-color: #00b5ad;border-color: #0f6674;font-weight: 30;" type="submit">{{__("Gruppe hinzufügen")}}</button>

    </form>
@endsection

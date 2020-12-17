@extends('Template.layout')
@extends('Template.links_professor')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_kurs.css")}}">

<h1 class ="meinekurse">Grundlagen der Programmierung</h1>

<button class="b2"> neuen kurse anlegen </button>
<div class="grid-container">
    <div class="grid-item1"></div>
    <div class="grid-itemtitel">Gruppe</div>
    <div class="grid-itemtitel">Online Meeting über </div>

    <div class="grid-item1"><a href="#d"><button class="button"><span>+</span></button></a></div>
    <div class="grid-item"><a href="gruppebearbeiten.php">Gruppe1</a>-Tag XX.YY-Raum-Anzahl der Teilnehmer</div>
    <div class="grid-item1"> <a href="link">Webx.com</a> </div>

    <div class="grid-item1"><a href="#d"><button class="button"><span>+</span></button></a></div>
    <div class="grid-item"><a href="gruppebearbeiten.php">Gruppe2</a>-Tag XX.YY-Raum-Anzahl der Teilnehmer</div>
    <div class="grid-item1"> <a href="link">Webx.com </a></div>

    <div class="grid-item1"><a href="#d"><button class="button"><span>+</span></button></a></div>
    <div class="grid-item"><a href="gruppebearbeiten.php">Gruppe3</a>-Tag XX.YY-Raum-Anzahl der Teilnehmer</div>
    <div class="grid-item1"> <a href="link">Webx.com</a></div>

    <div class="grid-item1"><a href="#d"><button class="button"><span>+</span></button></a></div>
    <div class="grid-item"><a href="gruppebearbeiten.php">Gruppe4</a>-Tag XX.YY-Raum-Anzahl der Teilnehmer</div>
    <div class="grid-item1"> <a href="link">Webx.com</a> </div>

</div>
<a href="#d0"><button class="button3" type="submit" value="Gruppe hinzufügen"> Gruppe Hinzufügen</button></a> <br>
<button class="button2" type="submit" value="Beteiligten Prof">Beteiligten Prof</button><br>
<button class="button1" type="submit" value="Kurs löschen">Kurs löschen</button><br>

<div id="d0" class="style_gruppe_hinzufügen">
    <form method="post">
        <label style="font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="name">Ihr Name:</label>
        <label style="margin-left: 5cm ;font-weight: bolder; font-family: Verdana,serif;color: darkslategrey;" for="Raum">Raum</label> <br>
        <input  class ="style1 " name="name" id="name" value="" >
        <input class ="style1 " name="Raum" id="Raum" type="number" value=""><br>
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
        <button style="margin-left:-26cm; margin-top:2cm; width: 7cm;height: 1cm;background-color: #00b5ad;border-color: #0f6674;font-weight: 30;" type="submit"> Gruppe Hinzufügen </button>
    </form>
    <a class="close" id="a1" href="Kurs1.html" title="schließen">schließen</a>

</div>
<div id="d" class="detaild">
    <label>
        <select size="3" name="top5" class="selec">
            <option value="Neue/n Betreuer/in Hinzufügen" selected>Gruppe Hinzufügen</option>
            <option value="Gruppe Löschen"> Gruppe Löschen</option>
            <option value="Teilnehmer der Gruppe anschauen">Teilnehmer der Gruppe anschauen</option>
        </select>
    </label>
    <a class="close" id="b1" href="Kurs1.html" title="schließen">schließen</a>
</div>

<div class="btn-group" >
    <a href="#d1"><button class="infos">Infos</button></a><br>
    <a href="https://mail.fh-aachen.de" target="_blank"> <button class="infos"> Outlook</button></a><br>
</div>
<div id ="d1" class="details">
    <div class="info1">Informationen</div>
    <div class="info" >
        Angelegt am XX:YY<br>
        Besitzer Prof: Dr XX<br>
        Beteiligter Prof :YY<br>
        Modulnummer:XXXX<br>
        <a class="close" id="c1" href="Kurs1.html" title="schließen">schließen</a> </div>
</div>

@endsection

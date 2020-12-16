@extends('Professor/layoutProfessor')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_dashboard.css")}}">

<h1> TeVis</h1>
<hr>
<button value="submit" class="headbutton"> Dashboard </button>
<button value="submit" class="headbutton">Mein Konto </button>
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/FHAachen-logo2010.svg/1200px-FHAachen-logo2010.svg.png" alt="fh aachen logo" >
@endsection
@section('main')
<h1 class ="dashboard">Dashboard</h1>

<div class="grid1">Kurse: WiSe20/21</div>

<div>
    <ul>
        <li class ="kurse"><a href="Kurs1.html">Kurse1</a> </li>
        <br>
        <li class="li1" >Raum </li>
        <li>Zeitpunkt</li>
        <li>Gruppenanzahl</li>
        <li>Teilnehmerzahl</li>
    </ul>
    <br>
    <ul>
        <li class ="kurse"><a href="Kurse2.html">Kurse2</a> </li>
        <br>
        <li class ="li1">Raum</li>
        <li>Zeitpunkt</li>
        <li>Gruppenanzahl</li>
        <li>Teilnehmerzahl</li>
    </ul>
</div>

<div class="grid2">Gruppen</div>

<div>
    <ul>
        <li class ="kurse"> <a href="GruppeBearbeiten.html"> Gruppe 1 </a></li>
        <br>
        <li class="li1" >Raum </li>
        <li> Zeitpunkt  </li>
        <li>Teilnehmer</li>
        <li><a href="mailto:betreuer1@alumni.fh-aachen.de">Betreuername</a></li>
        <li>Meetingraum</li>
    </ul>
    <br>
    <ul>
        <li class ="kurse"> <a href="GruppeBearbeiten.html"> Gruppe 2  </a> </li>
        <br>
        <li class="li1" >Raum </li>
        <li> Zeitpunkt  </li>
        <li>Teilnehmer</li>
        <li><a href="mailto:betreuer2@alumni.fh-aachen.de">Betreuername</a></li>
        <li>Meetingraum</li>
    </ul>
</div>
@endsection

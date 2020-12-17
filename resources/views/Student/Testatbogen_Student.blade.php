@extends('Template.layout')
@extends('Template.links_student')

@section('main')


    <link rel="stylesheet" href="{{URL::asset("CSS/styleStudent.css")}}">




    <br>
<h1 align="center">Testatbogen</h1>
<br>
<button type="button" align="center">als pdf speichern</button>
<br>
<br>
<br>

<table border="2">
    <tr>
        <th colspan="4" align="left" style="background-color: #d6d6d6">Kernstudium</th>
    </tr>
    <tr>
        <th>FachNr.</th>
        <th>Bezeichnung</th>
        <th>Testat erhalten</th>
        <th>Semester</th>
    </tr>
    <tr>
        <th>51104</th>
        <th>Grundlagen der Informatik und höhere Programmiersprache für Informatik</th>
        <th>&#10004;</th>
        <th>WiSe19/20</th>
    </tr>
    <tr>
        <th>52105</th>
        <th>Technische Informatik</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>52108</th>
        <th>Höhere Mathematik 2 für Informatik</th>
        <th>&#10004;</th>
        <th>SoSe20</th>
    </tr>
    <tr>
        <th>52110</th>
        <th>Datennetze und IT-Sicherheit</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>52106</th>
        <th>Algorithmen und Datenstrukturen</th>
        <th>&#10004;</th>
        <th>SoSe20</th>
    </tr>
    <tr>
        <th>53105</th>
        <th>Theoretische Informatik & Logik</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>53106</th>
        <th>Datenbanken & Webtechnologien</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>53107</th>
        <th>Architektur von Rechnersystemen und Betriebssystemkonzepte und verteilte Systeme</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>55107</th>
        <th>Software Engineering</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>53111</th>
        <th>Objektorintierte Softwareentwicklung</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th>55301</th>
        <th>BWL für Ingenieure</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th colspan="4" align="left" style="background-color: #d6d6d6">Wahlpflichtmodule 1-9</th>
    </tr>
    <tr>
        <th>FachNr.</th>
        <th>Bezeichnung</th>
        <th>Testat erhalten</th>
        <th>Semester</th>
    </tr>
    <th colspan="4" align="left" style="background-color: #d6d6d6">Softskillwahlmodul 1 und 2</th>
    </tr>
    <tr>
        <th>FachNr.</th>
        <th>Bezeichnung</th>
        <th>Testat erhalten</th>
        <th>Semester</th>
    </tr>
    <th colspan="4" align="left" style="background-color: #d6d6d6">Zusatzfächer</th>
    </tr>
    <tr>
        <th>FachNr.</th>
        <th>Bezeichnung</th>
        <th>Testat erhalten</th>
        <th>Semester</th>
    </tr>
</table>

@endsection

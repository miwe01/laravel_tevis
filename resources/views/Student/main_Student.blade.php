@extends('Template.layout')
@extends('Template.links_student')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleStudent.css")}}">

<br>
<h1 align="center">Meine Kurse</h1>
<br>
<br>
<div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
    <div><h4 align="center">WiSe20/21</h4></div>
    <div class="abstand">
        <p>
            <a href= "/Student/testSWE">Software Engineering</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <p>
            Prof. Siepmann</p>
        <p>
            Status: 3 von 9 Praktikas abgeschlossen. Endtestat noch nicht erhalten.
        </p>
        <p>
            Bemerkung: Muss Vortrag Seite 3 nochmal nachzeigen
        </p>
        <p>
            Gruppe E4
        </p>
        <p>
            Donnerstag 11:00 Uhr - 11:45 Uhr
        </p>
        <p>
            Raum E112
        </p>
        <p>
            webex: https://fh-aachen.webex.com/fh-aachen/j.php?MTID=m91d16dc03851d7e8f04e0f75ca8f579c
        </p>
    </div>

</div>

<div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
    <div><h4 align="center">SoSe20</h4></div>
    <div class="abstand">
        <p>
            <a href= >Höhere Mathematik 2 für Informatik</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <p>
            Prof. Hoever
        </p>
        <p>
            Status: 5 von 5 Praktikas abgeschlossen. Endtestat erhalten.
        </p>
        <p>
            Bemerkung:
        </p>
        <p>
            Gruppe A1
        </p>
        <p>
            Montag 10:00 Uhr - 11:45 Uhr
        </p>
        <p>
            Raum E113
        </p>
        <p>
            webex: https://fh-aachen.webex.com/fh-aachen/j.php?MTID=m51d7e8f04e0f75ca8f579c
        </p>
    </div>

    <div class="abstand">

        <p>
            <a href= >Algorithmen und Datenstrukturen</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <p>
            Prof. Scholl
        </p>
        <p>
            Status: 9 von 9 Praktikas abgeschlossen. Endtestat erhalten.
        </p>
        <p>
            Bemerkung:
        </p>
        <p>
            Gruppe C2
        </p>
        <p>
            Dienstag 11:00 Uhr - 11:45 Uhr
        </p>
        <p>
            Raum E112
        </p>
        <p>
            webex: https://fh-aachen.webex.com/fh-aachen/j.php?MTID=m91d16dc03851d7e8f04e0fhhhh75ca8f579c
        </p>
    </div>
</div>
<div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
    <div><h4 align="center">WiSe19/20</h4></div>
    <div class="abstand">
        <p>
            <a href= >Grundlagen der Informatik und höhere Programmiersprache für Informatik</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
        <p>
            Prof. Claßen
        </p>
        <p>
            Status: 8 von 8 Praktikas abgeschlossen. Endtestat erhalten.
        </p>
        <p>
            Bemerkung:
        </p>
        <p>
            Gruppe D2
        </p>
        <p>
            Freitag 09:00 Uhr - 10:45 Uhr
        </p>
        <p>
            Raum E112
        </p>

    </div>

</div>
@endsection

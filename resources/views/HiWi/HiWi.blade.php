

@extends('HiWi/layoutHiWi')

@section('main')


    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">


    <br>
    <h1 align="center">Meine Kurse</h1>
    <h1 align="center">HiWi</h1>
    <br>
    <br>
    <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
        <div><h4 align="center">WiSe20/21</h4></div>
        <div class="abstand clearfix">

            <h2>Software Engineering</h2>

            <p>
                webex: https://fh-aachen.webex.com/fh-aachen/j.php?MTID=m91d16dc03851d7e8f04e0fhhhh75ca8f579c
            </p>


            <div>
                <table border="2" style="float:left" class="abstandtabelle">
                    <tr>
                        <th colspan="2">Termin</th>

                        <th>Gruppe</th>
                        <th>Raum</th>
                    </tr>
                    <tr>
                        <th>Mittwoch</th>
                        <th>13:00 Uhr - 13:45 Uhr</th>
                        <th><a href="/HiWi/test">A1</a></th>
                        <th>E112</th>
                    </tr>
                    <tr>
                        <th>Mittwoch</th>
                        <th>14:00 Uhr - 14:45 Uhr</th>
                        <th><a href=>B3</a></th>
                        <th>E112</th>

                    </tr>
                    <tr>
                        <th>Donnerstag</th>
                        <th>13:00 Uhr - 13:45 Uhr</th>
                        <th><a href=>C1</a></th>
                        <th>E112</th>
                    </tr>
                    <tr>
                        <th>Donnerstag</th>
                        <th>14:00 Uhr - 14:45 Uhr</th>
                        <th><a href=>D4</a></th>
                        <th>E112</th>
                    </tr>
                </table>
            </div>
            <table border="2" >
                <tr>
                    <th style="background-color: #eaeaea">Betreuer</th>
                    <th style="background-color: #eaeaea">email</th>
                </tr>
                <tr>
                    <th>Prof. Siepmann</th>
                    <th>siepmann@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>WiMi1</th>
                    <th>wimi1@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>WiMi2</th>
                    <th>wimi2@fh-aachen.de</th>
                </tr>

            </table>
        </div>

    </div>

    <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
        <div><h4 align="center">SoSe20</h4></div>
        <div class="abstand clearfix">

            <h2>Höhere Mathematik 2 für Informatik</h2>
            <p>
                webex: https://fh-aachen.webex.com/fh-aachen/j.php?MTID=m51d7e8f04e0f75ca8f579c
            </p>

            <table border="2" style="float:left" class="abstandtabelle">
                <tr>
                    <th colspan="2">Termin</th>

                    <th>Gruppe</th>
                    <th>Raum</th>
                </tr>
                <tr>
                    <th>Mittwoch</th>
                    <th>13:00 Uhr - 13:45 Uhr</th>
                    <th>A1</th>
                    <th>E112</th>
                </tr>
                <tr>
                    <th>Mittwoch</th>
                    <th>14:00 Uhr - 14:45 Uhr</th>
                    <th>B3</th>
                    <th>E112</th>

                </tr>

            </table>

            <table border="2" style="margin-bottom: 10px;">
                <tr>
                    <th style="background-color: #eaeaea">Betreuer</th>
                    <th style="background-color: #eaeaea">email</th>
                </tr>
                <tr>
                    <th>Prof. Hoever</th>
                    <th>siepmann@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>wimi1</th>
                    <th>wimi1@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>wimi2</th>
                    <th>wimi2@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>wimi3</th>
                    <th>wimi3@fh-aachen.de</th>
                </tr>

            </table>

        </div>

        <div class="abstand clearfix">

            <h2>Algorithmen und Datenstrukturen</h2>

            <p>
                webex: https://fh-aachen.webex.com/fh-aachen/j.php?MTID=m91d16dc03851d7e8f04e0fhhhh75ca8f579c
            </p>

            <table border="2" style="float:left" class="abstandtabelle">
                <tr>
                    <th colspan="2">Termin</th>

                    <th>Gruppe</th>
                    <th>Raum</th>
                </tr>
                <tr>
                    <th>Mittwoch</th>
                    <th>13:00 Uhr - 13:45 Uhr</th>
                    <th>A1</th>
                    <th>E112</th>
                </tr>
                <tr>
                    <th>Mittwoch</th>
                    <th>14:00 Uhr - 14:45 Uhr</th>
                    <th>B3</th>
                    <th>E112</th>

                </tr>
                <tr>
                    <th>Donnerstag</th>
                    <th>13:00 Uhr - 13:45 Uhr</th>
                    <th>C4</th>
                    <th>E112</th>
                </tr>
                <tr>
                    <th>Donnerstag</th>
                    <th>14:00 Uhr - 14:45 Uhr</th>
                    <th>D1</th>
                    <th>E112</th>
                </tr>
                <tr>
                    <th>Freitag</th>
                    <th>09:00 Uhr - 10:45 Uhr</th>
                    <th>D2</th>
                    <th>E112</th>
                </tr>
            </table>
            <table border="2">
                <tr>
                    <th style="background-color: #eaeaea">Betreuer</th>
                    <th style="background-color: #eaeaea">email</th>
                </tr>
                <tr>
                    <th>Prof. Scholl</th>
                    <th>siepmann@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>wimi1</th>
                    <th>wimi1@fh-aachen.de</th>
                </tr>
                <tr>
                    <th>wimi2</th>
                    <th>wimi2@fh-aachen.de</th>
                </tr>

            </table>

        </div>
    </div>

@endsection

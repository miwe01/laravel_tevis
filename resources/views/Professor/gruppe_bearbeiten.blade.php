@extends('Template.layout')
@extends('Template.links_professor')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

<h1 class ="meinekurse">Gruppenname</h1>

<div class="grid-container">
    <table class="mitglieder">
        <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>Matrikelnummer</th>
            <th>Termin 1</th>
            <th>Termin 2</th>
            <th>Kommentar</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="checkbox"> </td>
            <td>1111111</td>
            <td><input type="checkbox"> </td>
            <td><input type="checkbox"> </td>
            <td><input type="text" placeholder="Hier Kommentar einfügen"> </td>
        </tr>
        <tr>
            <td><input type="checkbox"> </td>
            <td>1111112</td>
            <td><input type="checkbox"> </td>
            <td><input type="checkbox"> </td>
            <td><input type="text" placeholder="Hier Kommentar einfügen"> </td>
        </tr>
        <tr>
            <td><input type="checkbox"> </td>
            <td>1111113</td>
            <td><input type="checkbox"> </td>
            <td><input type="checkbox"> </td>
            <td><input type="text" placeholder="Hier Kommentar einfügen"> </td>
        </tr>
        <tr>
            <td><input type="checkbox"> </td>
            <td>1111114</td>
            <td><input type="checkbox"> </td>
            <td><input type="checkbox"> </td>
            <td><input type="text" placeholder="Hier Kommentar einfügen"> </td>
        </tr>
        </tbody>
    </table>
</div>

<div><button type="button" class="mitte"> Studierenden hinzufügen</button> </div>
<div><button type="button" class="mitte"> Betreuer hinzufügen</button> </div>

<div class="grid-container">
    <table class="mitglieder">
        <thead>
        <tr>
            <th>Betreuername</th>
            <th>E-Mail Adresse</th>
            <th>Webex Raum</th>
            <th>Werkzeug</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Max Mustermann</td>
            <td><a href="mailto:max.mustermann@alumni.fh-aachen.de">max.mustermann@alumni.fh-aachen.de</a></td>
            <td><a href="max.mustermann.webex.com">max.mustermann.webex.com</a></td>
            <td><a href="">Löschen</a></td>
        </tr>
        </tbody>
    </table>
</div>
@endsection

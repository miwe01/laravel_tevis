
@extends('Student/layoutStudent')

@section('main')


    <link rel="stylesheet" href="{{URL::asset("CSS/styleStudent.css")}}">



    <br>
<h1 align="center">Software Engineering</h1>
<h1 align="center">Gruppe E4</h1>
<br>
<table border="2">
    <tr>
        <th style="background-color: #eaeaea">Matrikelnummer</th>
        <th style="background-color: #eaeaea">Vorname</th>
        <th style="background-color: #eaeaea">Nachname</th>
        <th style="background-color: #eaeaea">Bemerkung</th>
        <th style="background-color: #eaeaea">Praktikum 1</th>
        <th style="background-color: #eaeaea">Praktikum 2</th>
        <th style="background-color: #eaeaea">Praktikum 3</th>
        <th style="background-color: #eaeaea">Praktikum 4</th>
        <th style="background-color: #eaeaea">Praktikum 5</th>
        <th style="background-color: #eaeaea">Praktikum 6</th>
        <th style="background-color: #eaeaea">Praktikum 7</th>
        <th style="background-color: #eaeaea">Praktikum 8</th>
        <th style="background-color: #eaeaea">Praktikum 9</th>
        <th style="background-color: #eaeaea">Endtestat</th>
    </tr>
    <tr>
        <th>3333333</th>
        <th>Max</th>
        <th>Mustermann</th>
        <th>Muss Vortrag Seite 3 nochmal nachzeigen</th>
        <th>&#10004;</th>
        <th>&#10004;</th>
        <th>&#10004;</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</table>
<br>
<br>
<table border="2">
    <tr>
        <th style="background-color: #eaeaea">Betreuer</th>
        <th style="background-color: #eaeaea">email</th>
    </tr>
    <tr>
        <th>Prof. Siepmann</th>
        <th>siepmann@fh-aachen.de</th>
    </tr>
    <tr>
        <th>wimi1</th>
        <th>wimi1@fh-aachen.de</th>
    </tr>
    <tr>
        <th>hiwi1</th>
        <th>hiwi@fh-aachen.de</th>
    </tr>

</table>
@endsection

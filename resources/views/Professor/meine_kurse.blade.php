@extends('Template.layout')
@extends('Template.links')

@section('main')

<link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

<h1 class ="meinekurse">Meine Kurse</h1>
<button class="b2"> neuen kurse anlegen </button>

        <div class="grid1">WiSe19/20</div>

        <div>
        <ul>
            <li class ="kurse"><a href="Kurs1.html">Kurse1</a> </li>
            <br>
            <li class="li1" >an der veranstaltung </li>
            <li>menge der gruppen</li>
            <li>anzahl der tn</li>
        </ul>
            <br>
<ul>
    <li class ="kurse"><a href="Kurs1.html">Kurse2</a> </li>
    <br>
    <li class ="li1">an der Veranstaltung</li>
    <li>Menge der  gruppen</li>
    <li>anzahl der tn</li>
</ul>
        </div>

<div class="grid2">SoSe20/21</div>

<div>
    <ul>
        <li class ="kurse"><a href="Kurs1.html">Kurse1</a> </li>
        <br>
        <li class="li1" >an der veranstaltung </li>
        <li> menge der gruppen</li>
        <li>anzahl der tn</li>
    </ul>
    <br>
    <ul>
        <li class ="kurse"><a href="Kurs2.html">Kurse2</a> </li>        <br>
        <li class ="li1">an der Verantaltung</li>
        <li>Menge der  gruppen</li>
        <li>anzahl der tn</li>
    </ul>
</div>


@endsection

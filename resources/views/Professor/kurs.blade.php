@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_kurs.css")}}">

    <h1 class ="meinekurse">{{$gruppe[0]->Modulname}}</h1>
    <h4 style="font-family: Verdana">Beteiligter Professor :
        @foreach($haupt as $prof)
            <ul style="font-family: Verdana">Herr {{$prof->Vorname}}</ul>
        @endforeach
    </h4>
    <form  action="/Professor/kurs/new" method="get" >
        @csrf
        <input type="hidden" value="{{$gruppe[0]->Modulnummer}}" name="GruppenID" id="kursanlegen">
        <button class="b2" type="submit" id="kursanlegen"> neuen kurse anlegen </button>
    </form>




    <div class="grid-container">
        <div class="grid-item1"></div>
        <div class="grid-itemtitel">{{$gruppe[0]->Modulname}}</div>
        <div class="grid-itemtitel">Online Meeting über </div>
        @foreach($gruppe as $gr)
            <div class="grid-item1"><a href="#d">
                    <input type="hidden" value="{{$gr->GruppenID}}" id="GruppenID" name="GruppenID">
                    <input type="hidden" value="{{$gr->Modulnummer}}" id="GruppenID" name="Modulnummer">
                    <input type="hidden" value="{{$gr->Jahr}}" id="GruppenID" name="Jahr">
                    <button class="button" type="submit" name="GruppenID" id="GruppenID"><span>+</span></button></a></div>

            <div class="grid-item">
                <a href="gruppebearbeiten.php">{{$gr->Gruppenname}}</a> - Raum: {{$gr->Raum}} -  Anzahl der Teilnehmer : {{$gr->mengeDerGruppen}}
            </div>
            <div class="grid-item1">
                <a href="link">{{$gr->Webex}}</a>
            </div>
        @endforeach

    </div>
    <div id="d" class="detailg">
        <br>
        <br>

        <form  action="/Professor/kurs/betreuerHinzufu" method="post" >
            @csrf
            <input type="text" placeholder="Kennung" name="TutorID" id="betHinzu">
            <input type="hidden" name="GruppenID" id="betHinzu">
            <input type="hidden" name="Modulnummer" id="betHinzu">
            <input type="hidden" name="Jahr" id="betHinzu">
            <button  style="transform: translate(-0.5cm,0mm)" id="betHinzu" type="submit">Neuer Betreuer hinzufügen</button>
        </form>
        <br>
        <br>
        <form  action="/Professor/kurs/GruppeLoeschen" method="post" >
            @csrf
            <input type="hidden" value="{{$gr->GruppenID}}" name="GruppenID" >
            <button style="transform: translate(-0.5cm,0.5cm)"   type="submit">Gruppe Loeschen</button>
        </form>
        <br>
        <br>
        <a class="close" id="b1" href="/Professor/kurs" title="schließen">schließen</a>
    </div>

    <form  action="/Professor/kurs/new/group" method="get" >
        @csrf
        <input type="hidden" value="{{$gruppe[0]->Modulnummer}}" name="GruppenID" >
        <button  class="button3" type="submit" >Gruppe hinzufügen</button>
    </form>
    <br>
    <form  action="/Professor/kurs/KursLoeschen" method="post" >
        @csrf
        <input type="hidden" value="{{$gruppe[0]->Modulnummer}}" name="GruppenID" >
        <button class="button1"  type="submit">Kurs Loeschen</button>
    </form>



    <div class="btn-group" >
        <a href="#d1"><button class="infos">Infos</button></a><br>
        <a href="https://mail.fh-aachen.de" target="_blank"> <button class="infos"> Outlook</button></a><br>
    </div>
    <div id ="d1" class="details">
        <div class="info1">Informationen</div>
        <div class="info" >
            Angelegt :{{$gruppe[0]->Semester}}-{{$gruppe[0]->Jahr}}<br>
            Besitzer Prof:Herr  {{$haupt[0]->Nachname}}<br>
            Beteiligter Prof :Herr {{$haupt[0]->Nachname}}<br>
            Modulnummer:{{$gruppe[0]->Modulnummer}}<br>
            <a class="close" id="c1" href="/Professor/kurs" title="schließen">schließen</a>
        </div>
    </div>

    <br>



@endsection

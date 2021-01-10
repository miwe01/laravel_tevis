@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_dashboard.css")}}">



    <h1 class ="dashboard">Dashboard</h1>

    <div class="grid1">Kurse: WiSe20/21</div>

    <div>

        @foreach($kurse as $kurs)
            <ul>
                <li class ="kurse">{{$kurs->Modulnummer}} {{$kurs->Modulname}} </li>
                <br>
                <li class="li1" >{{$kurs->Raum}} </li>
                <li>Gruppenanzahl</li>
                <li>Teilnehmerzahl</li>
            </ul>
            <form action="/Professor/kurs" method="post">
                @csrf
                <input type="hidden" value="{{$kurs->Modulnummer}}" name="Modulname" id="bearbeiten">
                <input type="hidden" value="{{$kurs->Jahr}}" name="Modulname" id="bearbeiten">
                <input type="submit" name="bearbeiten" id="bearbeiten" value="bearbeiten">
            </form>
        @endforeach


    </div>

    <div class="grid2">Gruppen</div>

    <div>
        @foreach($gruppen as $gruppe)
            <ul>
                <li class ="kurse"> {{$gruppe->Modulname}} {{$gruppe->Gruppenname}} </li>
                <br>
                <li class="li1" >Raum </li>
                <li>Teilnehmer</li>
                <li><a href="mailto:betreuer1@alumni.fh-aachen.de">Betreuername</a></li>
                <li>{{$gruppe->Webex}}</li>
            </ul>
            <form action="/Professor/gruppe" method="post">
                @csrf
                <input type="hidden" value="{{$gruppe->Modulnummer}}" name="Modulnummer" id="bearbeiten">
                <input type="hidden" value="{{$gruppe->Jahr}}" name="Jahr" id="bearbeiten">
                <input type="hidden" value="{{$gruppe->Gruppenummer}}" name="Gruppenummer" id="bearbeiten">
                <input type="submit" name="bearbeiten" id="bearbeiten" value="bearbeiten">
            </form>
        @endforeach

    </div>
@endsection

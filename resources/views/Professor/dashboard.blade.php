@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_dashboard.css")}}">



    <h1 class ="dashboard">Dashboard</h1>

    <div class="grid1">Kurse: WiSe20/21</div>

    <div class="table">

        @foreach($kurse as $kurs)
            <ul>
                <li class ="kurse">{{$kurs->Modulnummer}} {{$kurs->Modulname}} </li>
                <br>
                <li class="li1" >{{$kurs->Raum}} </li>
            </ul>
            <form action="/Professor/kurs" method="post">
                @csrf
                <input type="hidden" value="{{$kurs->Modulnummer}}" name="Modulname" id="bearbeiten">
                <input type="hidden" value="{{$kurs->Jahr}}" name="Jahr" id="bearbeiten">
                <input type="submit" name="bearbeiten" id="bearbeiten" value="bearbeiten">
            </form>
        @endforeach


        <form action="/Professor/meine_kurse" method="post">
            @csrf
            <input type="submit" value="Meine Kurse" id="meinekurse" name="meinekurse">
        </form>
    </div>

    <div class="grid2">Gruppen</div>

    <div class="table">
        @foreach($gruppen as $gruppe)
            <ul>
                <li class ="kurse"> {{$gruppe->Modulname}} {{$gruppe->Gruppenname}} </li>
                <br>
                <li class="li1" >{{$gruppe->Jahr}} </li>
                @foreach($haupt as $bet)
                    @if($bet->GruppenID == $gruppe->Gruppenummer)
                        <li class="unten"><a href="mailto:{{$bet->Email}}">{{$bet->Vorname}} {{$bet->Nachname}}</a></li>
                        <li class="unten"><a href="{{$bet->Webexraum}}">Webex</a></li>
                    @endif
                @endforeach
                <li>{{$gruppe->Webex}}</li>

                <form action="/Professor/gruppe" method="post">
                    @csrf
                    <input type="hidden" value="{{$gruppe->Modulnummer}}" name="Modulnummer" id="bearbeiten">
                    <input type="hidden" value="{{$gruppe->Jahr}}" name="Jahr" id="bearbeiten">
                    <input type="hidden" value="{{$gruppe->Gruppenummer}}" name="Gruppenummer" id="bearbeiten">
                    <input type="submit" name="bearbeiten" id="bearbeiten" value="bearbeiten">
                </form>

            </ul>
        @endforeach

    </div>
@endsection

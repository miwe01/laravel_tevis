@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_dashboard.css")}}">



    <h1 class ="dashboard">Dashboard</h1>

    <div class="grid1">{{__("Kurse")}}: WiSe20/21</div>

    <div class="table">
        @forelse($kurse as $kurs)

            <div><h4 align="center">  {{$kurs->Modulnummer}}  {{$kurs->Modulname}}   {{$kurs->Semester}}  {{$kurs->Jahr}}</h4></div>
            <div class="abstand clearfix">
                <p>{{__("Rolle")}}: {{$kurs->Rolle}}</p>
                <p>{{__("Raum")}}: {{$kurs->Raum}}</p>


                <form action="/Professor/kurs" method="get">
                    @csrf
                    <input type="hidden" value="{{$kurs->Modulnummer}}" name="Modulname" id="bearbeiten">
                    <input type="hidden" value="{{$kurs->Jahr}}" name="Jahr" id="bearbeiten">
                    <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("bearbeiten")}}">
                </form>
                <br>
                <details>
                    <summary>{{__("Gruppen")}}</summary>
                    <div class="table">
                        @foreach($gruppen as $gruppe)
                            @if ($gruppe->Modulnummer == $kurs->Modulnummer && $gruppe->Jahr == $kurs->Jahr)
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
                                        <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("bearbeiten")}}">
                                    </form>
                                </ul>
                            @endif
                        @endforeach

                    </div> </details>
            </div>

        @empty
            <li>{{__("Keine Daten vorhanden")}}.</li>
        @endforelse


    </div>


    <form action="/Professor/meine_kurse" method="post">
        @csrf
        <input type="submit" value="{{__("Meine Kurse")}}" id="meinekurse" name="meinekurse">
    </form>

@endsection

@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1 align="center">{{__("Meine Kurse")}}</h1>
    <br>

    <form action="/Professor/meine_kurse" method="post">
        @csrf
        <input type="submit" value="{{__("Meine Kurse")}}" id="meinekurse" name="meinekurse">
    </form>

        @forelse($kurse as $kurs)
            <br>
            <br>

            <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
            <div><h4 align="center">  {{$kurs->Modulnummer}}  {{$kurs->Modulname}}   {{$kurs->Semester}}  {{$kurs->Jahr}}</h4></div>
            <div class="abstand clearfix">
                <p>{{__("Rolle")}}: {{$kurs->Rolle}}</p>
                <p>{{__("Raum")}}: {{$kurs->Raum}}</p>                  
            
                <br>
                <details>
                    <summary>{{__("Gruppen")}}</summary>
                        @foreach($gruppen as $gruppe)
                            @if ($gruppe->Modulnummer == $kurs->Modulnummer && $gruppe->Jahr == $kurs->Jahr)
                                <ul>
                                    <li class ="kurse"> {{$gruppe->Modulname}} {{$gruppe->Gruppenname}} </li>
                                    <br>
                                    <li class="li1"> {{$gruppe->Jahr}} </li>
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

                   </details>
                </div>
            </div>

        @empty
            <li>{{__("Keine Daten vorhanden")}}.</li>
        @endforelse




@endsection

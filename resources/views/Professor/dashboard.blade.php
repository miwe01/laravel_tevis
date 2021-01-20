@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">
    <br>
    <h1 align="center">{{__("Betreute Kurse")}}</h1>
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


                @forelse($gruppen as $gruppe)

                    @if ($gruppe->Modulnummer == $kurs->Modulnummer && $gruppe->Jahr == $kurs->Jahr)
                        <details>
                            <summary> {{$gruppe->Gruppenname}}</summary>
                            <ul>

                                @forelse($haupt as $bet)
                                    @if($bet->GruppenID == $gruppe->Gruppenummer)
                                        <li class="unten"><a href="mailto:{{$bet->Email}}">{{$bet->Vorname}} {{$bet->Nachname}}</a></li>
                                        <li class="unten"><a href="{{$bet->Webexraum}}">Webex</a></li>
                                    @endif
                                @empty
                                    <li>{{__("Kein Hauptbetreuer vorhanden")}}.</li>
                                @endforelse
                                <li>{{$gruppe->Webex}}</li>
                                <form action="/Professor/gruppe" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$gruppe->Modulnummer}}" name="Modulnummer" id="bearbeiten">
                                    <input type="hidden" value="{{$gruppe->Jahr}}" name="Jahr" id="bearbeiten">
                                    <input type="hidden" value="{{$gruppe->Gruppenummer}}" name="Gruppenummer" id="bearbeiten">
                                    <input type="submit" name="bearbeiten" id="bearbeiten" value="{{__("bearbeiten")}}">
                                </form>
                                <form action="/Professor/gruppenübersicht" method="post">
                                    @csrf
                                    <input type="hidden"  value="{{$gruppe->Gruppenname}} " name="Gruppenname" id="Testat">
                                    <input type="hidden"  value="{{$gruppe->Gruppenummer}} " name="Gruppenummer" id="Testat">
                                    <input type="hidden"  value="{{$gruppe->Jahr}} " name="Jahr" id="Testat">
                                    <button type="submit"  value="{{$gruppe->Modulname}} " name="Modulname" id="Testat">{{__("Testverwaltung2")}}</button>
                                </form>
                            </ul>
                        </details>
                    @endif
                @empty
                    <li>{{__("Keine betreuten Gruppen in diesem Kurs")}}.</li>
                @endforelse


            </div>
        </div>

    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse




@endsection

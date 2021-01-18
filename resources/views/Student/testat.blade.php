@extends ('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1>  {{$testat[0]->Modulname}} {{$testat[0]->Jahr}}</h1>
    <h1> {{$gruppenname}}</h1>
    <br>
    <div style="overflow-x:auto;">
        <table border="2">
            <tr style="background-color: #eaeaea">
                <th>Matrikelnummer</th>
                <th>{{__("Vorname")}}</th>
                <th>{{__("Nachname")}}</th>
                @forelse($testat as $t)
                    <th>{{$t->Praktikumsname}}</th>
                @empty
                    <th>{{__("Keine Daten vorhanden")}}.</th>
                @endforelse
            </tr>
            <tr>
                <th>{{$testat[0]->Matrikelnummer}}</th>
                <th>{{$testat[0]->Vorname}}</th>
                <th>{{$testat[0]->Nachname}}</th>
                @forelse($testat as $t)
                    @if ($t->Testat == 1)
                        <th>&#10004</th>
                    @else
                        <th>&#10006</th>
                    @endif
                @empty
                    <th>{{__("Keine Daten vorhanden")}}.</th>
                @endforelse
            </tr>
        </table>
    </div>
    <br>
    <br>
    <table border="2">
        <tr>
            <th style="background-color: #eaeaea">{{__("Rolle")}}</th>
            <th style="background-color: #eaeaea">{{__("Betreuer")}}</th>
            <th style="background-color: #eaeaea">{{__("Email-Adresse")}}</th>
        </tr>
        @foreach($betreuerp as $b)
            <tr>
                <th>Professor</th>
                <th>{{$b->Titel}} {{$b->Vorname}}{{$b->Nachname}}</th>
                <th>{{$b->Email}}</th>
            </tr>
        @endforeach
        @foreach($betreuer as $b)
            <tr>
                <th>{{$b->Rolle}}</th>
                <th>{{$b->Vorname}}{{$b->Nachname}}</th>
                <th>{{$b->Email}}</th>
            </tr>
        @endforeach
    </table>

@endsection

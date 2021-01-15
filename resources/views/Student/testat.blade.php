@extends ('Template.layout')
@section('main')
    @extends('Template.links')
    <br>
    <h1 align="center">  {{$testat[0]->Modulname}} {{$testat[0]->Jahr}}</h1>
    <h1 align="center"> {{$gruppenname}}</h1>
    <br>
    <table border="2">
        <tr style="background-color: #eaeaea">
            <th>Matrikelnummer</th>
            <th>{{__("Vorname")}}</th>
            <th>{{__("Nachname")}}</th>
            @foreach($testat as $t)
                <th>{{$t->Praktikumsname}}</th>
            @endforeach
        </tr>
        <tr>
            <th>
                {{$testat[0]->Matrikelnummer}}
            </th>
            <th>        {{$testat[0]->Vorname}}</th>
            <th>        {{$testat[0]->Nachname}}</th>
            @foreach($testat as $t)
                @if ($t->Testat == 1)
                    <th>&#10004</th>
                @else
                    <th></th>
                @endif
            @endforeach
        </tr>
    </table>
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
    <br>
    <a href="/Student/dashboard">{{__("Zurück zur Übersicht")}}</a>
@endsection

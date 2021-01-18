@extends('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1 align="center">{{__("Betreute Kurse")}}</h1>
    <br>
    <br>
    @forelse($tutor as $t)
        <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
            <div><h4 align="center">  {{$t->Modulnummer}}  {{$t->Modulname}}   {{$t->Semester}}  {{$t->Jahr}}</h4></div>
            <div class="abstand clearfix">
                <p>{{$t->Gruppenname}}</p>
                <p>{{__("Raum")}}: {{$t->Raum}}</p>
                <p>Webexlink: {{$t->Webex}}</p>

                <form action="/Tutor/dashboard/testatverwaltung" method="post">
                    @csrf
                    <input type="hidden"  value="{{$t->Gruppenname}} " name="Gruppenname" id="Testat">
                    <input type="hidden"  value="{{$t->Gruppenummer}} " name="Gruppenummer" id="Testat">
                    <input type="hidden"  value="{{$t->Jahr}} " name="Jahr" id="Testat">
                    <button type="submit"  value="{{$t->Modulname}} " name="Modulname" id="Testat">{{__("Testverwaltung")}}</button>
                </form>

            </div>
        </div>
    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse


@endsection

@extends ('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1>{{__("Meine Kurse")}}</h1>
    <br>
    <br>

    @forelse($student as $s)
        <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
            <div><h4>{{$s->Modulnummer}} {{$s->Modulname}}  {{$s->Semester}}{{$s->Jahr}}</h4></div>
            <div class="abstand clearfix">

                <p>{{$s->Gruppenname}}</p>
                <p>{{__("Raum")}}: {{$s->Raum}}</p>
                <p>{{__("Webexlink")}}: <a target="_blank" {{__("Webex")}}: href="{{$s->Webex}}">{{$s->Webex}}</a></p>
                
                <form action="/Student/dashboard/{{$s->Modulname}}_{{$s->Jahr}}" method="post">
                    @csrf
                    <input type="hidden"  value="{{$s->Gruppenname}} " name="Gruppenname" id="Testat">
                    <input type="hidden"  value="{{$s->Gruppenummer}} " name="Gruppenummer" id="Testat">
                    <input type="hidden"  value="{{$s->Jahr}} " name="Jahr" id="Testat">
                    <button type="submit"  value="{{$s->Modulname}} " name="Modulname" id="Testat">{{__("Testat")}}</button>
                </form>

            </div>
        </div>
    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse
@endsection


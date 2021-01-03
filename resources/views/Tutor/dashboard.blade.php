@extends('Template.layout')
@extends('Template.links_hiwi')

@section('main')


    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">


    <br>
    <h1 align="center">Betreute Kurse</h1>
    <br>
    <br>
    @foreach($tutor as $t)
        <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
            <div><h4 align="center">  {{$t->Modulnummer}}  {{$t->Modulname}}   {{$t->Semester}}  {{$t->Jahr}}</h4></div>
            <div class="abstand clearfix">
                <p>
                    {{$t->Gruppenname}}
                </p>
                <p>
                    Webexlink: {{$t->Webex}}

                </p>

                <p>
                    Raum: {{$t->Raum}}
                </p>


                <form action="/Tutor/dashboard/{{$t->Modulname}}_{{$t->Gruppenname}}" method="post">
                    @csrf
                    <input type="hidden"  value="{{$t->Gruppenname}} " name="Gruppenname" id="Testat">
                    <input type="hidden"  value="{{$t->Gruppenummer}} " name="Gruppenummer" id="Testat">
                    <input type="hidden"  value="{{$t->Jahr}} " name="Jahr" id="Testat">
                    <button type="submit"  value="{{$t->Modulname}} " name="Modulname" id="Testat">Testatverwaltung</button>
                </form>

            </div>
        </div>
    @endforeach


@endsection

@extends ('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <br>
    <h1 align="center">Meine Kurse</h1>
    <br>
    <br>
    @foreach($student as $s)
        <div style= "margin-bottom:20px;border:2px solid black;background-color: #d6d6d6;">
            <div><h4 align="center">  {{$s->Semester}}{{$s->Jahr}}</h4></div>
            <div class="abstand clearfix">
                <p>
                    {{$s->Modulnummer}}  {{$s->Modulname}}
                </p>
                <p>
                    {{$s->Gruppenname}}
                </p>
                <p>
                    Raum: {{$s->Raum}}
                </p>
                <p>
                    Webexlink: {{$s->Webex}}

                </p>

                <form action="/Student/dashboard/{{$s->Modulname}}_{{$s->Jahr}}" method="post">
                    @csrf
                    <input type="hidden"  value="{{$s->Gruppenname}} " name="Gruppenname" id="Testat">
                    <input type="hidden"  value="{{$s->Gruppenummer}} " name="Gruppenummer" id="Testat">
                    <input type="hidden"  value="{{$s->Jahr}} " name="Jahr" id="Testat">
                    <button type="submit"  value="{{$s->Modulname}} " name="Modulname" id="Testat">Testat</button>
                </form>

            </div>
        </div>
    @endforeach



    <form action="/Student/testatbogen" method="post">
        @csrf<button type="submit"  value={{$s->Modulnummer}} name="Testatbogen" id="Testatbogen">Testatbogen</button>


    </form>

@endsection


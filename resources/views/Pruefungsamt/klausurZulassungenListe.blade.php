@extends('Template.layout')
@extends('Template.links')

@section('main')
    <link rel="stylesheet" href="{{URL::asset("CSS/dashboard.css")}}">

    <style>
        h1{
            text-align: center;
        }
        table{
            margin: 45px auto;
        }
        table,td,th{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

    <h1>{{__("Testate von Stundenten aus der Liste")}}</h1>
        <table><tr><th>{{__("Matrikelnummer")}}</th><th>{{__("Modulname")}}</th><th>{{__("Jahr")}}</th><th>Semester</th><th>Status</th></tr>
    @foreach($Geschafft as $t)
                <tr><td>{{$t}}</td><td>{{$Modul->Modulname}}</td><td>{{$Modul->Jahr}}</td><td>{{$Modul->Semester}}</td><td>
                    {{__("Ja")}}</td></tr>
    @endforeach

   @foreach($NichtGeschafft as $t)
    <tr><td>{{$t}}</td><td>{{$Modul->Modulname}}</td><td>{{$Modul->Jahr}}</td><td>{{$Modul->Semester}}</td><td>{{__("Nein")}}</td></tr>
                {{--                <tr><td>{{$t->Matrikelnummer}}</td><td>{{$t->Modulname}}</td><td>{{$t->Jahr}}</td><td>{{$t->Semester}}</td><td>Bestanden</td></tr>--}}
    @endforeach
    </table>

@endsection

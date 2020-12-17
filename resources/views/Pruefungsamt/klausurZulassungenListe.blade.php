@extends('Template.layout')
@extends('Template.links_pruefungsamt')

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

    <h1>Testate von Stundenten aus der Liste</h1>
        <table><tr><th>Matrikelnummer</th><th>Modulname</th><th>Jahr</th><th>Semester</th><th>Status</th></tr>
    @foreach($Testate as $t)
                <tr><td>{{$t->Matrikelnummer}}</td><td>{{$t->Modulname}}</td><td>{{$t->Jahr}}</td><td>{{$t->Semester}}</td><td>Bestanden</td></tr>
    @endforeach
    </table>

@endsection

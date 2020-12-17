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

    <h1>Testate vom Stundent {{$Student}}</h1>
    <table><tr><th>Modulnummer</th><th>Modulname</th><th>Semester</th><th>Jahr</th><th>Status</th></tr>
        @foreach($Testatbogen as $t)
            <tr><td>{{$t->Modulnummer}}</td><td>{{$t->Modulname}}</td><td>{{$t->Semester}}</td><td>{{$t->Jahr}}</td><td>
                    @if($t->Testat)
                        Ja
                    @else
                        Nein
                </td></tr>
            @endif
        @endforeach
    </table>

@endsection

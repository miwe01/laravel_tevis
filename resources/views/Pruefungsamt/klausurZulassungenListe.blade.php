@extends('Template.layout')
@extends('Template.links')

@section('main')


    <style>
        @media (max-width: 610px){
            h1{
                font-size: 25px;
            }
        }
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

    <h1>{{$Modul}} {{__("Klausurzulassungen")}} </h1>
        <table><tr><th>{{__("Matrikelnummer")}}</th><th>{{__("Modulname")}}</th><th>Status</th></tr>
    @foreach($Geschafft as $t)
     <tr><td>{{$t}}</td><td>{{$Modul}}</td><td>{{__("Ja")}}</td></tr>
    @endforeach

   @foreach($NichtGeschafft as $t)
     <tr><td>{{$t}}</td><td>{{$Modul}}</td><td>{{__("Nein")}}</td></tr>
    @endforeach
    </table>

@endsection

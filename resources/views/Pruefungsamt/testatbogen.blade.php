@extends('Template.layout')
@extends('Template.links')

@section('main')
    {{-- Paar basic Styles von Dashboard Css --}}
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

    <h1>{{__("Testat(e) vom Stundent")}} {{$Student}}</h1>
    <table><tr><th>{{__("Modulnummer")}}</th><th>{{__("Modulname")}}</th><th>Semester</th><th>{{__("Jahr")}}</th><th>Endtestat</th></tr>
        @foreach($Testatbogen as $t)
            <tr><td>{{$t->Modulnummer}}</td><td>{{$t->Modulname}}</td><td>{{$t->Semester}}</td><td>{{$t->Jahr}}</td>
                <td>
                    @if($t->Testat)
                        {{__("Ja")}}
                    @else
                        {{__("Nein")}}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

@endsection

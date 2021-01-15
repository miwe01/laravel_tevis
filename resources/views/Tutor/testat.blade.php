@extends('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">

    <br>
    <h1 align="center">  {{$testat[0]->Modulname}}{{$testat[0]->Jahr}}</h1>
    <h1 align="center"> {{$gruppenname}}</h1>
    <br>
    <form action="/Tutor/dashboard/{{$testat[0]->Modulname}}_{{$gruppenname}}/testat" method="post">
        @csrf
        <table border="2">
            <tr style="background-color: #eaeaea">
                @if (isset($_SESSION['WiMi_UserId']))
                    <th >Matrikelnumer</th>
                @endif
                <th>{{__("Vorname")}}</th>
                <th>{{__("Nachname")}}</th>
                @foreach($testat as $t)
                    <th>{{$t->Praktikumsname}}</th>
                @endforeach
            </tr>
            <tr>
                @if (isset($_SESSION['WiMi_UserId']))
                    <th  rowspan="3">        {{$testat[0]->Matrikelnummer}}</th>
                @endif
                <th  rowspan="3">        {{$testat[0]->Vorname}}</th>
                <th  rowspan="3">        {{$testat[0]->Nachname}}</th>
                @foreach($testat as $t)
                    <th>
                        <input type="checkbox" id="scales" value="{{$t->TestatID}}" name="Testat[]" {{$t->Testat==1 ? 'checked':''}}>
                    </th>
                @endforeach
            </tr>
            <tr>
                @forelse($testat as $t)
                    <th>
                        <textarea name="comment[]">{{$t->Kommentar}}</textarea>
                        <input type="hidden" value="{{$t->TestatID}}" name="Testatcomment[]">
                    </th>
                @empty
                    <li>Keine Daten vorhanden.</li>
                @endforelse
            </tr>
            <tr>
                @forelse($testat as $t)
                    <th>
                        <input type="number"   value={{$t->Benotung}} step="any" name="note[]">
                    </th>
                @empty
                    <li>Keine Daten vorhanden.</li>
                @endforelse
            </tr>
        </table>
        <input type="hidden"  value="{{$testat[0]->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
        <input type="hidden"  value="{{$gruppenname}} " name="Gruppenname" id="Testat">
        <input type="hidden"  value="{{$testat[0]->Jahr}} " name="Jahr" id="Testat">
        <input type="hidden"  value="{{$modulname}} " name="Modulname" id="Testat">
        <button type="submit"  value="submit" name="submit" id="Testat">Submit</button>
    </form>
    <br>
@endsection

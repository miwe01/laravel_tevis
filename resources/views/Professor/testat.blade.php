@extends('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">

    <br>
    <h1 align="center">  {{$testat[0]->Modulname}}{{$testat[0]->Jahr}}</h1>
    <h1 align="center"> {{$gruppenname}}</h1>
    <br>
    <form action="/Professor/gruppe/testat" method="post">
        @csrf
        <table border="2">
            <tr style="background-color: #eaeaea">
                <th >Matrikelnumer</th>
                <th>{{__("Vorname")}}</th>
                <th>{{__("Nachname")}}</th>
                @forelse($testat as $t)
                    <th>{{$t->Praktikumsname}}</th>
                @empty
                    <th>{{__("Keine Daten vorhanden")}}.</th>
                @endforelse
            </tr>
            <tr>
                <th  rowspan="3">        {{$testat[0]->Matrikelnummer}}</th>
                <th  rowspan="3">        {{$testat[0]->Vorname}}</th>
                <th  rowspan="3">        {{$testat[0]->Nachname}}</th>
                @forelse($testat as $t)
                    <th>
                        <input type="checkbox" id="scales" value="{{$t->TestatID}}" name="Testat[]" {{$t->Testat==1 ? 'checked':''}}>
                    </th>
                @empty
                    <th>{{__("Keine Daten vorhanden")}}.</th>
                @endforelse
            </tr>
            <tr>
                @forelse($testat as $t)
                    <th>
                        <textarea name="comment[]" placeholder="Kommentar" >{{$t->Kommentar}}</textarea>
                        <input type="hidden" value="{{$t->TestatID}}" name="Testatcomment[]">
                    </th>
                @empty
                    <th>{{__("Keine Daten vorhanden")}}.</th>
                @endforelse
            </tr>
            <tr>
                @forelse($testat as $t)
                    <th>
                        <input type="number"  min="1" max="5" step="0.1" value="{{$t->Benotung}}" name="note[]">
                    </th>
                @empty
                    <th>{{__("Keine Daten vorhanden")}}n.</th>
                @endforelse
            </tr>
        </table>
        <input type="hidden"  value="{{$testat[0]->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
        <input type="hidden"  value="{{$gruppenname}} " name="Gruppenname" id="Testat">

        <input type="hidden"  value="{{$testat[0]->Jahr}} " name="Jahr" id="Testat">
        <input type="hidden"  value="{{$modulname}} " name="Modulname" id="Testat">
        <br>
        <button type="submit"  value="submit" name="submittestat" id="Testat">Submit</button>
    </form>
    <br>    <br>    <br>
    <br>
@endsection

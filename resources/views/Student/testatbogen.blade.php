@extends ('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">
    <h1>Testatbogen</h1>
    <br>
    <br>
    <br>
    <div style="overflow-x:auto;">
        <table border="2">
            <tr>
                <th>{{__("FachNr.")}}</th>
                <th>{{__("Bezeichnung")}}</th>
                <th>{{__("Testat erhalten")}}</th>
                <th>Semester</th>
            </tr>
            @forelse($modul as $m)
                <tr>
                    @if ($m->Testat == 1)
                        <th>{{$m->Modulnummer}}</th>
                        <th>{{$m->Modulname}}</th>
                        <th>&#10004</th>
                        <th>{{$m->Semester}}{{$m->Jahr}}</th>
                    @elseif($m->Testat == 0 && $m->Jahr == 2020)
                        <th>{{$m->Modulnummer}}</th>
                        <th>{{$m->Modulname}}</th>
                        <th>&#10006</th>
                        <th>{{$m->Semester}}{{$m->Jahr}}</th>
                    @elseif($m->Testat == 0 && $m->Jahr == $aktJahr)
                        <th>{{$m->Modulnummer}}</th>
                        <th>{{$m->Modulname}}</th>
                        <th>&#10006</th>
                        <th>{{$m->Semester}}{{$m->Jahr}}</th>
                    @endif
                </tr>
            @empty
                <li>{{__("Keine Daten vorhanden")}}.</li>
            @endforelse
        </table>
    </div>
    <br>
    <div class="link">
        <form action="/Student/testatbogen" method="post">
            @csrf
            <button type="submit" name="pdf_submit" value="pdf_submit">{{__("als pdf speichern")}} </button>
        </form>
        <br>
    </div>
@endsection

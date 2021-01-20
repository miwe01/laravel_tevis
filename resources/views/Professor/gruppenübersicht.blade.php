@extends('Template.layout')
@section('main')
    @extends('Template.links')
    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor.css")}}">
    <br>
    <h1 align="center">{{$modulname}}{{$jahr}}</h1>
    <h1 align="center">{{$gruppenname}}</h1>
    <br>
    <br>
    <div class="link">
        <form action="/Professor/testatverwaltung" method="post">
            @csrf
            <input type="text"  name="term" id="term">
            <input type="hidden"  value="{{$gruppenname}}" name="Gruppenname" id="search">
            <input type="hidden"  value="{{$studenten[0]->Gruppenummer}}" name="Gruppenummer" id="search">
            <input type="hidden"  value="{{$jahr}}" name="Jahr" id="search">
            <input type="hidden"  value="{{$modulname}}" name="Modulname" id="search">
            <button type="submit"  value="search" name="search" id="search">Suche</button>
        </form>
        @if(isset($abc))
            <h6>{{$abc}}</h6>
        @endif
    </div>
    <br>
    <div style="overflow-x:auto;">
        <table border="2">
            @forelse($studenten as $s)

                <tr>
                    <th style="background-color: #eaeaea">Matrikelnummer</th>
                    <th style="background-color: #eaeaea">{{__("Vorname")}}</th>
                    <th style="background-color: #eaeaea">{{__("Nachname")}}</th>
                    @forelse($testat as $t)
                        @if ($t->Matrikelnummer == $s->Matrikelnummer)
                            <th>{{$t->Praktikumsname}}</th>
                        @endif
                    @empty
                        <th>{{__("Keine Daten vorhanden")}}.</th>
                    @endforelse

                    <th style="background-color: #eaeaea">{{__("Testat")}}</th>
                    <th style="background-color: #eaeaea">{{__("Verschieben")}}</th>
                    <th style="background-color: #eaeaea">{{__("Löschen")}}</th>
                </tr>
                <tr>
                    <th>{{$s->Matrikelnummer}}</th>
                    <th>{{$s->Vorname}}</th>
                    <th>{{$s->Nachname}}</th>
                    @forelse($testat as $t)
                        @if ($t->Matrikelnummer == $s->Matrikelnummer)
                            @if ($t->Testat == 1)
                                <th>&#10004</th>
                            @else
                                <th>&#10006</th>
                            @endif
                        @endif
                    @empty
                        <th>{{__("Keine Daten vorhanden")}}.</th>
                    @endforelse

                    <th><form action="/Professor/gruppe/testat" method="post">
                            @csrf
                            <input type="hidden"  value="{{$s->Matrikelnummer}}" name="Matrikelnummer" id="Testat">
                            <input type="hidden"  value="{{$s->Gruppenname}} " name="Gruppenname" id="Testat">
                            <input type="hidden"  value="{{$s->Gruppenummer}} " name="Gruppenummer" id="Testat">
                            <input type="hidden"  value="{{$s->Jahr}} " name="Jahr" id="Testat">
                            <button type="submit"  value="{{$modulname}} " name="Modulname" id="Testat">{{__("Testat")}}</button>
                        </form></th>
                </tr>
            @empty
                <th>{{__("Keine Daten vorhanden")}}.</th>
            @endforelse
        </table>
        <br><br>
        <table border="2">
            <tr>
                <th style="background-color: #eaeaea">{{__("Betreuer")}}</th>
                <th style="background-color: #eaeaea">{{__("Email-Adresse")}}</th>
                <th style="background-color: #eaeaea">{{__("Webex Raum")}}</th>
                <th style="background-color: #eaeaea">{{__("Bearbeiten")}}</th>
            </tr>
            @foreach($betreuer as $b)
                <tr>
                    <th>{{$b->Vorname}}{{$b->Nachname}}</th>
                    <th>{{$b->Email}}</th>
                    <th>{{$b->Webex}}</th>
                    <th>


                    </th>
                </tr>
            @endforeach
        </table>
    </div>

@endsection

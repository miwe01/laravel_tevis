<body>
<h1 align="center">{{__("Testatbogen")}}</h1>
<br>
<br>
<br>
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
                <th>{{__("Bestanden")}}</th>
                <th>{{$m->Jahr}}</th>
            @elseif($m->Testat == 0 && $m->Jahr == 2020)
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                <th></th>
                <th>{{$m->Jahr}}</th>
            @elseif($m->Testat == 0 && $m->Jahr == $aktJahr)
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                <th></th>
                <th>{{$m->Jahr}}</th>
            @endif
        </tr>
    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse
</table>
</body>

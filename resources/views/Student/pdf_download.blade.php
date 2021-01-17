<body>
<h1 align="center">{{__("Testatbogen")}}</h1>
<br>
<br>
<br>
<table align="center" border="2" width="500px">
    <tr>
        <th>{{__("FachNr.")}}</th>
        <th>{{__("Bezeichnung")}}</th>
        <th>{{__("Testat erhalten")}}</th>a
        <th>Semester</th>
    </tr>
    @forelse($modul as $m)
        @if ($m->Testat == 1)
            <tr>
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                <th>{{__("Bestanden")}}</th>
                <th>{{$m->Semester}}{{$m->Jahr}}</th>
            </tr>
        @elseif($m->Testat == 0 && $m->Jahr == 2020)
            <tr>
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                <th></th>
                <th>{{$m->Semester}}{{$m->Jahr}}</th>
            </tr>
        @elseif($m->Testat == 0 && $m->Jahr == $aktJahr)
            <tr>
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                <th></th>
                <th>{{$m->Semester}}{{$m->Jahr}}</th>
            </tr>
        @endif

    @empty
        <li>{{__("Keine Daten vorhanden")}}.</li>
    @endforelse
</table>
</body>

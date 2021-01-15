<body>
<h1 align="center">Testatbogen</h1>
<br>
<br>
<br>
<table border="2">
    <tr>
        <th>FachNr.</th>
        <th>Bezeichnung</th>
        <th>Testat erhalten</th>
        <th>Semester</th>
    </tr>
    @forelse($modul as $m)
        <tr>
            @if ($m->Testat == 1)
                <th>{{$m->Modulnummer}}</th>
                <th>{{$m->Modulname}}</th>
                <th>Bestanden</th>
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
        <li>Keine Daten vorhanden.</li>
    @endforelse
</table>
</body>

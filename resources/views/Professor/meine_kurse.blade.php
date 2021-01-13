@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_mKurse.css")}}">

    <h1 class ="meinekurse">Meine Kurse</h1>
    <form class="kform" action="/Professor/meine_kurse/neuer_kurs" method="post">
        @csrf
        <input type="submit" class="b2" value="Neuen Kurs anlegen" id="neu">
        <input type="text" placeholder="Modulname" name="Modulname" id="neu">
        <input type="number" placeholder="Modulnummer" name="Modulnummer" id="neu">
        <input type="hidden" name="Jahr" value="2021" id="neu">
        <input type="hidden" name="Semester" value="WiSe" id="neu">
        <br>
    </form>


    @foreach($semester as $sem)
        <div class="table">
            <div class="grid1">{{$sem->Semester}} {{$sem->Jahr}}</div>

            <div class="grid2">
                @foreach($kurse as $kurs)
                    @if($kurs->Jahr==$sem->Jahr && $kurs->Semester==$sem->Semester)
                        <ul>
                            <li class ="kurse">{{$kurs->Modulname}}</li>
                            <br>
                            <form action="/Professor/kurs_bearbeiten" method="post">
                                @csrf
                                <input type="submit" name="bearbeiten" value="bearbeiten" id="bearbeiten">
                                <input type="hidden" name="Modulnummer" value="{{$kurs->Modulnummer}}" id="bearbeiten">
                                <input type="hidden" name="Semester" value="{{$kurs->Semester}}" id="bearbeiten">
                                <input type="hidden" name="Modulnummer" value="{{$kurs->Modulnummer}}" id="bearbeiten">
                            </form>
                        </ul>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach

@endsection

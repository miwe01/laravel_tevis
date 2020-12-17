@if(isset($fehler))
    {{phpAlert($fehler)}}
@endif

{{--{{$_SESSION['PA_UserId']}}--}}

@if(isset($info))
    {{phpAlert($info)}}
@endif



@extends('Template.layout')
@extends('Template.links_pruefungsamt')



    @section('main')
        <!-- Css für Dashboard -->
        <link rel="stylesheet" href="{{URL::asset("CSS/dashboard.css")}}">
    <!--dashboard -->
        <div id="wrapper">
            <div id="p1" class="loading">
                <div class="close" onclick="myFunction(p1, 'p1')">X</div>
                <h1>Student hinzufügen</h1>
                    <form action="/pruefungsamt/addPerson" method="post">
                        @csrf
                    <input type="text" name="titel" placeholder="Titel(optional)">
                    <input type="text" name="nachname" placeholder="Nachname" value='<?php echo isset($_POST['nachname']) ? $_POST['nachname'] : ''; ?>' required>
                    <input type="text" name="vorname" placeholder="Vorname" value="xyz" required>
                    <input type="text" name="email" placeholder="Email-Adresse" value="e" required>
                    <input type="text" placeholder="Kennung" name="kennung" value="mw" required>
                    <select name="rolle" id="rollen" onchange="showMatrikel()">
                        <option value="">Rolle auswählen</option>
                        <option value="student">Student</option>
                        <option value="professor">Professor</option>
                        <option value="wimi">WiMi</option>
                        <option value="hiwi">HiWi</option>
                    </select>
                    <input type="number" id="matrikelnummer" placeholder="Matrikelnummer" name="matrikelnummer">
                    <button type="submit" class="big-buttons" value=addPerson" name="addPerson" id="addPerson">Submit</button>
                </form>
            </div>

            @if($errors->first('rolle'))
                {{phpAlert("Keine Rolle ausgewählt")}}
                <script> myFunction(p1, 'p1'); </script>
            @endif
        {{-- dd(get_defined_vars()) --}}
       @if($errors->any())
            {{phpAlert($errors->first())}}
            <script> myFunction(p1, 'p1'); </script>
       @endif

        <!-- col1 start -->
        <div id="col-1">

            <div id="col-1-buttons">
                <button class="big-buttons" onclick="myFunction(p1, 'p1')">Neue Person erstellen</button>
            </div>

            <div id="col-1-fileUpload">
                <h3>Studierende Liste</h3>
                <form action="/pruefungsamt/fileUpload" method="post" enctype="multipart/form-data">
                @csrf
                    <input type="file" id="file" name="file" onchange="checkType('file')" required>
                    <button type="submit" name="fileUpload" value="fileUpload">Schicken</button>
                </form>
            </div>

            <div id="col-1-last-added">
                <h3>Zuletzt hinzugefügt</h3>
                <ul>
                    @foreach($lastAdded as $elm)
                        <li>{{$elm->Nachname}} {{$elm->Vorname}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- col1 end -->

        <!-- col2 start -->
        <div id="col-2">
            <div id="klausurzulassung">
                <h3>Klausurzulassung prüfen</h3>
                <form action="/pruefungsamt/klausurZulassung" method="post">
                    @csrf
                <div>
                <label for="matrikelnummer1">Matrikelnummer</label>
                <input type="number" id="matrikelnummer1" name="matrikelnummer" placeholder="XXXXXXX" min="1111111" max="9999999" value="3566465" required>
                    <select name="modul">
                        <option value="">Modul auswählen</option>
                        <optgroup label="WiSe">

                    @foreach($WinterModule as $m)
                            <option value={{$m->Modulnummer}}>{{$m->Modulname}} ({{$m->Jahr}})</option>
                    @endforeach

                    </optgroup>
                    <optgroup label="SoSe">
                        @foreach($SommerModule as $m)
                            <option value={{$m->Modulnummer}}>{{$m->Modulname}} ({{$m->Jahr}})</option>
                        @endforeach
                    </optgroup>
                    </select>
                <button type="submit" class="form-button">Senden</button>
                    </div>
                </form>
            </div>

            <div id="klausurzulassungen">
                <h3>Klausurzulassungen prüfen</h3>
                <form action="/pruefungsamt/klausurZulassungen" target="_blank"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                <input type="file" id="file2" name="file" onchange="checkType('file2')" required>
                        <select name="modul">
                            <option>Modul auswählen</option>
                            <optgroup label="WiSe">

                                @foreach($WinterModule as $m)
                                    <option value={{$m->Modulnummer}}>{{$m->Modulname}} ({{$m->Jahr}})</option>
                                @endforeach

                            </optgroup>
                            <optgroup label="SoSe">
                                @foreach($SommerModule as $m)
                                    <option value={{$m->Modulnummer}}>{{$m->Modulname}} ({{$m->Jahr}})</option>
                                @endforeach
                            </optgroup>
                        </select>
                <button type="submit" class="form-button">Senden</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- col 2 end -->
        <!-- col3 start -->
        <div id="col-3">
            <div id="praktikum">
                <h3>Praktikum anerkennen</h3>
                <form action="/pruefungsamt/praktikumAnerkennen" method="post">
                    @csrf
                    <div>
                <label for="matrikelnummer2">Matrikelnummer</label>
                <input type="number" id="matrikelnummer2" name="matrikelnummer" placeholder="XXXXXX" min="1111111" max="9999999">
                        <select name="modul">
                            <option value="">Modul auswählen</option>
                            <optgroup label="WiSe">

                                @foreach($WinterModule as $m)
                                    <option value={{$m->Modulnummer}}>{{$m->Modulname}} ({{$m->Jahr}})</option>
                                @endforeach

                            </optgroup>
                            <optgroup label="SoSe">
                                @foreach($SommerModule as $m)
                                    <option value={{$m->Modulnummer}}>{{$m->Modulname}} ({{$m->Jahr}})</option>
                                @endforeach
                            </optgroup>
                        </select>
                    <div>
                <button type="submit" class="form-button">Senden</button>
                    </div>
                    </div>
                </form>
            </div>
                <div id="testatbogen">
                    <form action="/pruefungsamt/Testatbogen" method="post" target="_blank">
                        @csrf
                    <h3>Testatbogen anzeigen</h3>
                        <div>
                    <label for="matrikelnummer3">Matrikelnummer</label>
                    <input type="number" id="matrikelnummer3" name="matrikelnummer" placeholder="XXXXXXX" min="1111111" max="9999999">
                    <button type="submit" class="form-button" name="matrikel-anzeigen">Anzeigen</button>
                        </div>
                    </form>
                </div>
        </div>
        <!-- col3 end -->
    </div>
@endsection

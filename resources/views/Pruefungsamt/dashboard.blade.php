

{{--{{$_SESSION['PA_UserId']}}--}}

{{-- Inkludiert Layout(HTML Struktur + Header)--}}
@extends('Template.layout')
{{-- Sind die jeweiligen Links(Pfade) um auf "Dashboard" und "MeinKonto" zu navigieren--}}
@extends('Template.links')



@section('main')
    <!-- Css für Dashboard -->
    <link rel="stylesheet" href="{{URL::asset("CSS/dashboard.css")}}">
    <!--dashboard -->

    {{-- Wenn Fehler/Informationen an dashboard.blade.php geschickt werden kommt eine JS Alert Box  --}}

    @if(isset($info))
        <div id="message-div" class="info" onclick="document.getElementById('message-div').style.display = 'none';">
            {{$info}}
        </div>
    @endif

    @if(isset($fehler))
        <div id="message-div" class="error" onclick="document.getElementById('message-div').style.display = 'none';">
            {{$fehler}}
        </div>
    @endif


    <div id="wrapper">
        {{--
            Loading Div wenn Knopf "Benutzer hinzufügen" gedrückt wurde
        --}}
        <div id="p1" class="loading">
            <div class="close" onclick="myFunction(p1, 'p1')">X</div>
            <h1>{{__("Student hinzufügen")}}</h1>
            <form action="/pruefungsamt/addPerson" method="post">
                @csrf
                <table id="person-table">
                    <tr>
                        <td class="bottom-td">
                            <label for="titel" class="person-label">{{__("Titel(optional)")}}</label>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="titel" name="titel">
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom-td">
                            <label for="nachname" class="person-label">{{__("Nachname")}}</label>
                        </td>
                        <td class="bottom-td">
                            <label for="vorname" class="person-label">{{__("Vorname")}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="nachname" name="nachname"
                                value='<?php echo isset($_POST['nachname']) ? $_POST['nachname'] : ''; ?>' required>
                        </td>
                        <td>
                            <input type="text" id="vorname" name="vorname" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom-td">
                            <label for="email" class="person-label">Email</label>
                        </td>
                        <td class="bottom-td">
                            <label for="kennung" class="person-label">Kennung</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="email" name="email" required>
                        </td>
                        <td>
                            <input type="text" id="kennung" name="kennung" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom-td top-padding-td">
                            <label for="rollen" class="person-label">{{__("Rollen")}}</label>
                        </td>
                        <td class="bottom-td top-padding-td">
                            <label for="matrikelnummer4" class="person-label">Matrikelnummer</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="rolle" id="rollen" onchange="showMatrikel()">
                                <option value="">{{__("Rolle auswählen")}}</option>
                                <option value="student">Student</option>
                                <option value="professor">Professor</option>
                                <option value="wimi">WiMi</option>
                                <option value="hiwi">HiWi</option>
                            </select>
                        </td>
                        <td>

                            <input type="number" id="matrikelnummer4" name="matrikelnummer" placeholder="XXXXXXX" min="1111111" max="9999999">
                        </td>
                    </tr>
                    <tr>
                        <td class="top-padding-td" colspan="2">
                            <button type="submit" class="big-buttons full-width-button" value=addPerson" name="addPerson" id="addPerson">{{__("Senden")}}</button>
                        </td>

                    </tr>
                </table>
            </form>
        </div>
        {{--
            Wenn Fehler bei Validierung von Benutzer hinzufügen passiert
        --}}
        @if($errors->first('rolle'))
            {{phpAlert("Keine Rolle ausgewählt")}}
            <script> myFunction(p1, 'p1'); </script>
        @elseif($errors->any())
            {{phpAlert($errors->first())}}
            <script> myFunction(p1, 'p1'); </script>
    @endif



    <!-- col1 start -->
        <div id="col-1">
            <!-- Knopf Neue Person erstellen die Div #p1 aufruft wenn gedrückt -->
            <div id="col-1-buttons">
                <button class="big-buttons" onclick="myFunction(p1, 'p1')">{{ __("Neue Person erstellen")}}</button>
            </div>

            <!-- File Upload von neu hinzuzufügenden Studierenden -->
            <div id="col-1-fileUpload">
                <h3>{{ __("Studierende Liste")}}</h3>
                <form action="/pruefungsamt/fileUpload" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="file" name="file" onchange="checkType('file')" required>
                    <button type="submit" name="fileUpload" value="fileUpload">{{__("Senden")}}</button>
                </form>
            </div>
            <!-- zeigt letzten 5 Benutzer an -->
            <div id="col-1-last-added">
                <h3>{{ __("Zuletzt hinzugefügt")}}</h3>
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
            <!-- Überprüft Klausurzulassung vom Studenten -->
            <div id="klausurzulassung">
                <h3>{{ __("Klausurzulassung prüfen")}}</h3>
                <form action="/pruefungsamt/klausurZulassung" method="post">
                    @csrf
                    <div>
                        <label for="matrikelnummer1" class="form-label">{{ __("Matrikelnummer")}}</label>
                        <input type="number" class="matrikelnummer-input" id="matrikelnummer1" name="matrikelnummer" placeholder="XXXXXXX" min="1111111" max="9999999" value="3566465" required>
                        <!-- Module werden reingeladen aus DB und werden unterteilt in Wintermodule und Sommermodule -->
                        <select class="select-form" name="modul">
                            <option value="">{{ __("Modul auswählen")}}</option>
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
                        <button type="submit" class="form-button">{{__("Senden")}}</button>
                    </div>
                </form>
            </div>

            <!-- Überprüft mehrere Studenten aus csv Datei und überprüft Klausurzulassung -->
            <div id="klausurzulassungen">
                <h3>{{__("Klausurzulassungen prüfen")}}</h3>
                <!-- macht neuen Tab auf mit Tabelle von Studenten -->
                <form action="/pruefungsamt/klausurZulassungen" target="_blank"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <input type="file" id="file2" name="file" onchange="checkType('file2')" required>
                        <select class="select-form" name="modul">
                            <option>{{ __("Modul auswählen")}}</option>
                            <optgroup label="WiSe">
                                <!-- Module werden reingeladen aus DB und werden unterteilt in Wintermodule und Sommermodule -->
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
                        <button type="submit" class="form-button">{{__("Senden")}}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- col 2 end -->

        <!-- col3 start -->
        <!-- Praktikum anerkennen bedeutet dem Studenten das Endtestat vom Modul auf bestanden zu setzen -->
        <div id="col-3">
            <div id="praktikum">
                <h3>{{__("Praktikum anerkennen")}}</h3>
                <form action="/pruefungsamt/praktikumAnerkennen" method="post">
                    @csrf
                    <div>
                        <label for="matrikelnummer2" class="form-label">Matrikelnummer</label>
                        <input type="number" class="matrikelnummer-input" id="matrikelnummer2" name="matrikelnummer" placeholder="XXXXXX" min="1111111" max="9999999">
                        <select class="select-form" name="modul">
                            <option value="">{{__("Modul auswählen")}}</option>
                            <optgroup label="WiSe">
                                <!-- Module werden reingeladen aus DB und werden unterteilt in Wintermodule und Sommermodule -->
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
                            <button type="submit" class="form-button">{{__("Senden")}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Testatbogen anzeigen, zeigt Benutzer mit allen Modulen die ein Testat haben an -->
            <div id="testatbogen">
                <form action="/pruefungsamt/Testatbogen" method="post" target="_blank">
                    @csrf
                    <h3>{{__("Testatbogen anzeigen")}}</h3>
                    <div>
                        <label for="matrikelnummer3" class="form-label">Matrikelnummer</label>
                        <input type="number" class="matrikelnummer-input" id="matrikelnummer3" name="matrikelnummer" value="4444446" placeholder="XXXXXXX" min="1111111" max="9999999">
                        <button type="submit" class="form-button" name="matrikel-anzeigen">{{__("Anzeigen")}}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- col3 end -->

    </div>
@endsection

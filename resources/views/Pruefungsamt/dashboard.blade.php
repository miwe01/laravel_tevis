<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1" charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="layout.css">
    <!-- header css -->
    <link rel="stylesheet" href="{{URL::asset("CSS/Templates/Header/header.css")}}">
    <link rel="stylesheet" href="{{URL::asset("CSS/layout.css")}}">
    <!--js skripte -->
    <script src="{{URL::asset("JS/functions.js")}}"></script>
</head>
<body>
<?php
// Functions php
/*
Funktion um Fehler anzuzeigen
*/

?>

<?php
// included die header Datei

// include_once("../Connection/ConnectionData.php");
// include_once(".\App/Functions/lastAdded.php");
/*include_once("../phpFunctions/lastAdded.php");
include_once("../phpFunctions/benutzerAdd.php");
include_once ("../phpFunctions/phpAlert.php");
*/
?>
@if(isset($fehler))
    {{phpAlert($fehler)}}
@endif
    <div id="wrapper">
        <div id="p1" class="loading">
            <div class="close" onclick="myFunction(p1, 'p1')">X</div>
            <h1>Student hinzufügen</h1>
                <form action="/addPerson" method="post">
                    @csrf
                <input type="text" name="titel" placeholder="Titel(optional)">
                <input type="text" name="nachname" placeholder="Nachname" value="abc" required>
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
                <label class="big-buttons">
                    <form action="/fileUpload" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- <input type="file" onchange="form.submit()" name="studierende-liste-upload">
                        Studierenden Liste importieren -->
                        <input type="file" id="file" name="file" onchange="checkType()" required>Hallo
                            <button type="submit" name="fileUpload" value="fileUpload">Schicken</button>
                    </form>
                </label>
            </div>
            <?php
            // check ob Button gedrückt wurde muss hierhin kommen oder es gibt probleme mit Header Funktion,
            // weil ein echo früher aufgerufen werde bei last-added
            // wenn funktion am Ende von dashboard.blade.php stehen würde, würde das echo vor BenutzerAdd aufgerufen und das gibt Probleme
          //  BenutzerAdd();
           // studentenListeAdd();

            ?>
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
                <form action="/klausurZulassung" method="post">
                    @csrf
                <div>
                <label for="matrikelnummer1">Matrikelnummer</label>
                <input type="number" id="matrikelnummer1" name="matrikelnummer" placeholder="XXXXXX" min="1111111" max="9999999">
                <select name="modul">
                    <option>Modul auswählen</option>
                    <optgroup label="WiSe">
                        <option value="SWE">SWE</option>
                        <option value="DBWTt">DBWT</option>
                        <option value="BWL">BWL</option>
                    </optgroup>
                    <optgroup label="SoSe">
                        <option value="ti">Ti</option>
                    </optgroup>
                </select>

                <button type="submit" class="form-button">Senden</button>
                    </div>
                </form>
            </div>

            <div id="klausurzulassungen">
                <h3>Klausurzulassungen prüfen</h3>
                <form action="dashboard.blade.php" method="get">
                    <div>
                <input type="file">
                <select>
                    <option>Modul auswählen</option>
                    <optgroup label="WiSe">
                        <option value="swe">SWE</option>
                        <option value="dbwt">DBWT</option>
                        <option value="bwl">BWL</option>
                    </optgroup>
                    <optgroup label="SoSe">
                        <option value="ti">Ti</option>
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
                <form action="dashboard.blade.php" method="get">
                    <div>
                <label for="matrikelnummer2">Matrikelnummer</label>
                <input type="number" id="matrikelnummer2" name="matrikelnummer" placeholder="XXXXXX" min="111111" max="999999">
                <select>
                    <option>Modul auswählen</option>
                    <optgroup label="WiSe">
                    <option value="swe">SWE</option>
                    <option value="dbwt">DBWT</option>
                    <option value="bwl">BWL</option>
                    </optgroup>
                    <optgroup label="SoSe">
                        <option value="ti">Ti</option>
                    </optgroup>
                </select>
                    <div>
                <button type="submit" class="form-button">Senden</button>
                    </div>
                    </div>
                </form>
            </div>
                <div id="testatbogen">
                    <form action="../Playground/testatbogenStudent.php" method="get" target="_blank">
                    <h3>Testatbogen anzeigen</h3>
                        <div>
                    <label for="matrikelnummer3">Matrikelnummer</label>

                    <input type="number" id="matrikelnummer3" name="matrikelnummer" placeholder="XXXXXX" min="111111" max="999999">

                    <button type="submit" class="form-button" name="matrikel-anzeigen">Anzeigen</button>
                        </div>
                    </form>
                </div>


        </div>
        <!-- col3 end -->
    </div>

<?php

// if button Student hinzufügen set



?>
</body>
</html>

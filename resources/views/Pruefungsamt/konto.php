<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1" charset="UTF-8">
    <title>Mein Konto</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="../Templates/Header/header.css">
    <script src="../Playground/toggle.js"></script>

    <style>
        div{
           margin-top: 20px;
        }
    </style>
</head>
<body>
<?php
include_once("../Templates/Header/header.html");
?>

<div id="p2" class="loading">
    <div class="close" onclick="myFunction(p2, 'p2')">X</div>
    <h1>Passwort ändern</h1>
    <form action="konto.php" method="post">
        <input type="password" placeholder="Altes Passwort" name="opassword">
        <input type="password" placeholder="Neues Passwort" name="npassword"><br><br>
        <button name="passwortChange" type="submit" class="big-buttons">Submit</button>
    </form>
</div>
<?php

// Functions php
/*
Funktion um Fehler anzuzeigen
*/
function phpAlert($msg)
{
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

BenutzerAdd();
?>

<div>
<button class="big-buttons" onclick="myFunction(p2, 'p2')">Passwort ändern</button>
</div>
<?php
function BenutzerAdd()
{
    if (isset($_POST["passwortChange"])) {
    // wenn kein Passwort angegeben wurde => Fehler
        if (empty($_POST["opassword"]) || empty($_POST["npassword"])) {
            echo "<script> myFunction(p2, 'p2'); </script>";
            phpAlert("Bitte Passwort angeben");

        } else {
            $oldpassword = $_POST["opassword"];
            $newpassword = $_POST["npassword"];

            // connect db
            $link = mysqli_connect("localhost", // Host der Datenbank
                "Selector",                 // Benutzername zur Anmeldung
                "test..123",    // Passwort
                "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                3306// optional port der Datenbank
            );
            // error beim verbinden der DB
            if (!$link) {
                echo "<script> myFunction(p2, 'p2'); </script>";
                phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
            }

            // prevent injection
            $oldpassword = mysqli_real_escape_string($link, $oldpassword);

            // query

            // !!!!!!!!!!!!!!!!
            // muss noch geändert werden überprüft auch ob Benutzer gleich ist
            // weil sonst könnte auch ein anderer Benutzer das Passwort haben
            // man könnte mit einer $_SESSION["benutzername"] den Benutzer auch fragen
            // !!!!!!!!!!!!!!!!

            $sql = "SELECT * FROM benutzer WHERE Password='$oldpassword' AND Kennung ='mw'";
            $result = mysqli_query($link, $sql);

            // error bei Query
            if (!$result) {
                echo "<script> myFunction(p2, 'p2'); </script>";
                phpAlert("Falsches Passwort");
            }

            if (mysqli_num_rows($result) == 0) {
                echo "<script> myFunction(p2, 'p2'); </script>";
                phpAlert("Falsches Passwort");
            }

            // Verbindung schliessen
            mysqli_free_result($result);
            mysqli_close($link);


            // connect db um einzufügen

            // Updator braucht select und update permissions um zu updaten

                $link = mysqli_connect("localhost", // Host der Datenbank
                    "Updator",                 // Benutzername zur Anmeldung
                    "test..123",    // Passwort
                    "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                    3306// optional port der Datenbank
                );

                // error beim verbinden der DB
                if (!$link) {
                    echo "<script> myFunction(p2, 'p2'); </script>";
                    phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
                }

                // prevent injection
                $newpassword = mysqli_real_escape_string($link, $newpassword);

                // query
                $sql1 = "UPDATE benutzer SET Password='$newpassword' WHERE Kennung='mw'";
                $result1 = mysqli_query($link, $sql1);

                if (!$sql1) {
                    echo "<script> myFunction(p2, 'p2'); </script>";
                    phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
                }
            }
        }
    }
?>



</body>
</html>
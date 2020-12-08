<?php
$csv = array();

// check there are no errors
if(isset($_POST["importieren"])) {
    if ($_FILES['file']['size'] != 0) {
        if ($_FILES['file']['error'] == 0) {
            $name = $_FILES['file']['name'];

            // wird temporär gespeichert in php und gibt pfad zurück
            $tmpName = $_FILES['file']['tmp_name'];
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if ($ext == "csv") {
                if (($handle = fopen($tmpName, 'r')) !== FALSE) {
                    $fileArray = [];
                    while (!feof($handle)) {
                        $line = fgets($handle);
                        // echo $line. "<br>";
                        $str = explode(";", $line);
                        // wenn mehr als 7 Einträge sind Fehler (wird später noch umgeändert)
                        if (count($str) == 7){
                            echo "Falsches Format";
                            echo "Format soll: Kennung;Email;Nachname;Vorname;Studiengang;Matrielnummer sein";
                            exit;
                        }

                        // print_r($str);
                        array_push($fileArray, $str);
                    }
                    // alles korrekt bis jetzt, jetzt wird überprüft ob Daten korrekt sind
                    print_r($fileArray);

                    // villeicht später noch Daten untersuchen ob sie korrekt sind!!!!

                    // connect db
                    $link = mysqli_connect("localhost", // Host der Datenbank
                        "Selector",                 // Benutzername zur Anmeldung
                        "test..123",    // Passwort
                        "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                        3306// optional port der Datenbank
                    );

                    // error beim verbinden der DB
                    if (!$link) {
                        echo "Fehler aufgetreten bitte versuchen sie es normal";
                        echo"1";
                    }


                    for ($i=0;$i<count($fileArray);$i++){
                        $kennung = mysqli_real_escape_string($link, $fileArray[$i][0]);
                        $email = mysqli_real_escape_string($link, $fileArray[$i][1]);
                        $nachname = mysqli_real_escape_string($link, $fileArray[$i][2]);
                        $vorname = mysqli_real_escape_string($link, $fileArray[$i][3]);
                        $studiengang = mysqli_real_escape_string($link, $fileArray[$i][4]);
                        $matrikelnummer = mysqli_real_escape_string($link, $fileArray[$i][5]);

                        $sql1 = "SELECT * FROM benutzer WHERE Kennung='$kennung';";
                        $sql2 = "SELECT * FROM benutzer WHERE Email='$email';";
                        $result1 = mysqli_query($link, $sql1);
                        $result2 = mysqli_query($link, $sql2);

                        // Benutzer gibt es schon-> wird übersprungen
                        if (mysqli_num_rows($result1) > 0) {
                            echo "Benutzer Kennung gibt es schon";
                            continue;
                        }
                        if (mysqli_num_rows($result2) > 0) {
                            echo "Email gibt es schon";
                            continue;
                        }
                        mysqli_free_result($result1);
                        mysqli_free_result($result2);
                        mysqli_close($link);

                        $link = mysqli_connect("localhost", // Host der Datenbank
                            "Insertor",                 // Benutzername zur Anmeldung
                            "test..123",    // Passwort
                            "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                            3306// optional port der Datenbank
                        );
                        // error beim verbinden der DB
                        if (!$link) {
                            echo "Fehler aufgetreten bitte versuchen sie es normal";
                            echo"2";
                        }
                        echo $kennung . ' ' . $studiengang . ' ' . $matrikelnummer;


                        $sql1 = "INSERT INTO benutzer (Kennung, Email, Vorname, Nachname, Password)
                        VALUES ('$kennung', '$email','$vorname', '$nachname', '123456')";

                        $sql2 = "INSERT INTO student (Kennung, Studiengang)
                        VALUES ('$kennung', '$studiengang')";

                        $result1 = mysqli_query($link, $sql1);
                        $result2 = mysqli_query($link, $sql2);

                        if (!$result1 || !$result2) {
                            echo "Fehler aufgetreten bitte versuchen sie es normal";
                            echo "3";
                            exit;
                        }
                        echo "Erfolgreich\n";
                    }
                    echo "\nnach einfügen";


                }
            } else {
                echo "ALERT Keine CSV Datei";
            }
        } else {
            echo "ALERT Fehler bei Importierung";
        }
    }
    else{
        echo "ALERT Keine Datei ausgewählt";
    }
}
?>
<script>
    function checkType(){
        var fileName = document.getElementById("file").value;
        let extension = fileName.substring(fileName.lastIndexOf('.') + 1);

        if(extension != "csv"){
            document.getElementById("file").value = "";
            alert("Keine CSV Datei");
        }
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1" charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" value="" onchange="checkType()" id="file">
    <input type="submit" name="importieren" value="Save" /></form>
</body>

<?php
namespace App\Functions;
function benutzerAdd()
{
    if (isset($_GET["addPerson"])) {
        // wenn keine Rolle ausgewählt wird => Fehler
        if (empty($_GET["rolle"])) {
            echo "<script> myFunction(p1, 'p1'); </script>";
            phpAlert("Keine Rolle ausgewählt");
            //return;
        } else {
            $titel = $_GET["titel"];
            $nachname = $_GET["nachname"];
            $vorname = $_GET["vorname"];
            $email = filter_var($_GET["email"], FILTER_SANITIZE_EMAIL);
            $kennung = $_GET["kennung"];
            $rolle = $_GET["rolle"];
            // $matrikel = $_GET["matrikelnummer"];

            // connect db
            $link = mysqli_connect("localhost", // Host der Datenbank
                "Selector",                 // Benutzername zur Anmeldung
                "test..123",    // Passwort
                "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                3306// optional port der Datenbank
            );
            // error beim verbinden der DB
            if (!$link) {
                echo "<script> myFunction(p1, 'p1'); </script>";
                phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
                //return;
            }

            // prevent injection
            $kennung = mysqli_real_escape_string($link, $kennung);
            $email = mysqli_real_escape_string($link, $email);

            // query
            $sql1 = "SELECT * FROM benutzer WHERE Kennung='$kennung';";
            $sql2 = "SELECT * FROM benutzer WHERE Email='$email';";
            $result1 = mysqli_query($link, $sql1);
            $result2 = mysqli_query($link, $sql2);

            // error bei Query
            if (!$result1 || !$result2) {
                echo "<script> myFunction(p1, 'p1'); </script>";
                phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
                //return;
            }
            $error_array = [];

            if (mysqli_num_rows($result1) > 0) {
                /* echo "<script> myFunction(p1, 'p1'); </script>";
                 phpAlert("Kennung oder Email gibt es schon");
                 exit();*/
                array_push($error_array, "Kennung gibt es schon");
            }

            if (mysqli_num_rows($result2) > 0) {
                /*  echo "<script> myFunction(p1, 'p1'); </script>";
                  phpAlert("Kennung oder Email gibt es schon");
                  exit();*/
                array_push($error_array, "Email gibt es schon");
            }

            // Verbindung schliessen
            mysqli_free_result($result1);
            mysqli_free_result($result2);
            mysqli_close($link);


            // Wenn Problem mit Query ist wie zB unique Feld dann bricht Programm ab und gibt Array von Fehlern aus
            if ($error_array) {
                $s = "";
                $s = implode(", ", $error_array);
                echo "<script> myFunction(p1, 'p1'); </script>";
                phpAlert($s);
                //return;
            } else {
                // Wird ueberprueft welche Rolle ausgewählt wurde

                // connect db
                $link = mysqli_connect("localhost", // Host der Datenbank
                    "Insertor",                 // Benutzername zur Anmeldung
                    "test..123",    // Passwort
                    "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                    3306// optional port der Datenbank
                );


                // error beim verbinden der DB
                if (!$link) {
                    echo "<script> myFunction(p1, 'p1'); </script>";
                    phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
                    //return;
                }


                // prevent injection
                //  $titel = $_GET["titel"];
                $kennung = mysqli_real_escape_string($link, $kennung);
                $email = mysqli_real_escape_string($link, $email);
                $nachname = mysqli_real_escape_string($link, $_GET["nachname"]);
                $vorname = mysqli_real_escape_string($link, $_GET["vorname"]);
                // $rolle = $_GET["rolle"];
                // $matrikel = $_GET["matrikelnummer"];

                // query
                $sql1 = "INSERT INTO benutzer (Kennung, Email, Vorname, Nachname, Password)
                     VALUES ('$kennung', '$email','$vorname', '$nachname', '123456');";
                $result1 = mysqli_query($link, $sql1);

                if (!$sql1) {
                    echo "<script> myFunction(p1, 'p1'); </script>";
                    phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
                    //return;
                }


                if ($rolle == "professor")
                    echo "Professor";
                else if ($rolle == "student")
                    echo "Student";
                else if ($rolle == "wimi")
                    echo "WiMi";
                else if ($rolle == "hiwi")
                    echo "HiWi";

                // lösche alle Gets nachdem sie eingefügt wurden
                // unset($_GET["addPerson"]);
                // mysqli_free_result($result1);
                mysqli_close($link);
                // header("Refresh:0");
            }


            /*
            $kennung = $_GET["kennung"];
            $matrikelnummer = $_GET["matrikelnummer"];

            // escape string
            $kennung = mysqli_real_escape_string($kennung);
            $matrikelnummer = mysqli_real_escape_string($matrikelnummer);


            $link = mysqli_connect("localhost", // Host der Datenbank
                "root",                 // Benutzername zur Anmeldung
                "test..123",    // Passwort
                "tevis",     // Auswahl der Datenbanken (bzw. des Schemas)
                3306// optional port der Datenbank
            );


            if (!$link) {
                echo "<script> myFunction(p1, 'p1'); </script>";
                phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
            }

            $sql1 = "SELECT * FROM student WHERE Kennung=$kennung;";
            $sql2 = "SELECT * FROM student WHERE Kennung=$kennung;";

            $result1 = mysqli_query($link, $sql1);
            $result2 = mysqli_query($link, $sql2);

            if (!$result1 || !$result2) {
                echo "<script> myFunction(p1, 'p1'); </script>";
                phpAlert("Fehler aufgetreten bitte versuchen sie es normal");
            }

            $error_array = [];


            if (mysqli_num_rows($result1) > 0) {
                // echo "<script> myFunction(p1, 'p1'); </script>";
                // phpAlert("Matrikelnummer gibt es schon");
                array_push($error_array, "Matrikelnummer gibt es schon");
            }
            if (mysqli_num_rows($result2) > 0) {
               //  echo "<script> myFunction(p1, 'p1'); </script>";
                // phpAlert("Matrikelnummer gibt es schon");
                array_push($error_array, "Kennung gibt es schon");
            }


            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['ID'].' '.$row['Email'] . '<br>';
            }
            mysqli_free_result($result);
            mysqli_close($link);
            echo 'hallo';



            */
        }
    }
}

<?php
function lastAdded(){
    // connect db
    $link = mysqli_connect(HOST, USER_SELECTOR, PASSWORD, DB, PORT);
    // error beim verbinden der DB
    if (!$link) {
        echo "Problem augetreten";
    }
    // Zeigt die letzt hinzugefügten 5 Benutzer an
    $sql = "SELECT Nachname, Vorname, Email FROM benutzer ORDER BY erfasst_am DESC  LIMIT 5";

    $result = mysqli_query($link, $sql);
    // Fehler bei Query
    if (empty($result)) {
        echo "Leer";
    } elseif (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li class='last-added-li'>" . $row["Nachname"] . " " . $row["Vorname"] . " " . $row["Email"] . "</li>";
        }
    }

}

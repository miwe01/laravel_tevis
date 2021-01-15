<!-- Wenn Fehler auftritt -->


@if(isset($_SESSION['fehler']))
    <div id="message-div" class="error" onclick="document.getElementById('message-div').style.display = 'none';">
        {{$_SESSION['fehler']}}
    </div>
@endif
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1" charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{URL::asset("CSS/index.css")}}">
</head>
<body>
<div id="wrapper">
    <div id="login">
        <!-- Fh Aachen Logo -->
        <img id="fh-aachen-logo" src="{{URL::asset("Images/fh-aachen-logo.png")}}" alt="Fhaachen Logo" width="35px"
             height="auto">
        <figure>
            <img src="{{URL::asset("Images/tevis.jpg")}}" alt="Tevis Logo" width="200px" height="auto">
            <figcaption>Login</figcaption>
        </figure>

        <!-- Form für Kennung und PW -->
        <form action="/authentication" method="POST">
            @csrf
            <input type="text" name="kennung" id="kennung" placeholder="FH-Kennung"
                   value="<?php if (isset($_SESSION['kennung']))
                       echo htmlentities($_SESSION['kennung']);?>"
                   required>
            <input type="password" name="passwort" placeholder="Passwort" required>
            <button type="submit" class="big-buttons" name="einloggen">Einloggen</button>
        </form>
</div>

</div>
</body>
</html>

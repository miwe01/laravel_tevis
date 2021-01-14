@if(isset($info))
    {{phpAlert($info)}}
@endif

@extends('Template.layout')
@extends('Template.links_pruefungsamt')

@section('main')
<!-- Css für Konto -->
<link rel="stylesheet" href="{{URL::asset("CSS/dashboard.css")}}">

<!-- Loading Div wenn Knopf "Passwort ändern" gedrückt wurde -->
<div id="p2" class="loading">
    <div class="close" onclick="myFunction(p2, 'p2')">X</div>
    <h1>Passwort ändern</h1>
    <form action="/pruefungsamt/konto/passwortAendern" method="post">
        @csrf
        <input type="password" placeholder={{__("AltesPasswort")}} name="opassword">
        <input type="password" placeholder={{__("NeuesPasswort")}} name="npassword"><br><br>
        <button name="passwortChange" type="submit" class="big-buttons">Submit</button>
    </form>
</div>

<!-- Wenn Fehler aufgetreten ist dann Alert ausgeben und Div nochmal aufrufen -->
@if(isset($fehler_menu))
    {{phpAlert($fehler_menu)}}
    <script> myFunction(p2, 'p2'); </script>
@endif


<div>
<button class="big-buttons" onclick="myFunction(p2, 'p2')">{{__("Passwort ändern")}}</button>
</div>
@endsection

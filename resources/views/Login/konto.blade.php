@extends('Template.layout')


@section('main')

    @extends('Template.links')

<link rel="stylesheet" href="{{URL::asset("CSS/dashboard.css")}}">
@if(isset($info))
    {{$info}}
@endif
<div id="p2" class="loading">
    <div class="close" onclick="myFunction(p2, 'p2')">X</div>
    <h1>Passwort ändern</h1>
    <form action="./konto" method="post">
        @csrf
        <input type="password" placeholder="Altes Passwort" name="opassword">
        <input type="password" placeholder="Neues Passwort" name="npassword"><br><br>
        <button name="passwortChange" type="submit" class="big-buttons">Submit</button>
    </form>
</div>
@if(isset($fehler_menu))
    {{$fehler_menu}}
    <script> myFunction(p2, 'p2'); </script>
@endif

<div>
<button class="big-buttons" onclick="myFunction(p2, 'p2')">Passwort ändern</button>
</div>
@endsection

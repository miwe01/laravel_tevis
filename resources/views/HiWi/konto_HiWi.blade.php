@extends('Template.layout')
@extends('Template.links_hiwi')

@section('main')


    <link rel="stylesheet" href="{{URL::asset("CSS/styleHiWi.css")}}">

    <br>
    <h1 align="center">Mein Konto</h1>
    <br>
    <form action="">
        <input type="submit" value="Passwort ändern" />
    </form>
    <br>
    <br>
    <form action="/HiWi/testatbogen_HiWi">
        <input type="submit" value="Testatbogen..." />
    </form>


@endsection



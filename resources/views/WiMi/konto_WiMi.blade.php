@extends('Template.layout')
@extends('Template.links_wimi')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleWiMi.css")}}">

    <br>
    <h1 align="center">Mein Konto</h1>

    <br>
    <form action="">
        <input type="submit" value="Passwort ändern" />
    </form>


@endsection

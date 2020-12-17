@extends('Template.layout')
@extends('Template.links_student')

@section('main')


    <link rel="stylesheet" href="{{URL::asset("CSS/styleStudent.css")}}">

    <br>
<h1 align="center">Mein Konto</h1>
<br>
<form action="">
    <input type="submit" value="Passwort ändern" />
</form>
<br>
<br>
<form action="/Student/testatbogen_Student">
    <input type="submit" value="Testatbogen..." />
</form>


@endsection



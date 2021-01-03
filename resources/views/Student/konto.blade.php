@extends('layouts.student_layout')
@section('content')
    <h1 align="center">Mein Konto</h1>
    <br>
    <form action="Passwort.blade.php">
        <input type="submit" value="Passwort ändern" />
    </form>
    <br>
    <br>
    <form action="Testatbogen.blade.php">
        <input type="submit" value="Testatbogen..." />
    </form>
@endsection


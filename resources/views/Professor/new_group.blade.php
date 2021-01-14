@extends('Template.layout')
@extends('Template.links')

@section('main')

    <link rel="stylesheet" href="{{URL::asset("CSS/styleProfessor_gruppe.css")}}">

  <h1>Create a new group</h1>

    <form action="/Professor/kurs/new/group" method="post">
        @csrf
        <label for="groupName">Group name</label>
        <input type="text" id="groupName" name="groupName">

        <label for="moduleNumber">Module number</label>
        <input type="number" id="moduleNumber" name="moduleNumber">

        <label for="year">Year</label>
        <input type="number" id="year" name="year">

        <label for="webexLink">Webex Link</label>
        <input type="text" id="webexLink" name="webexLink">

        <button type="submit">Create</button>
    </form>
@endsection

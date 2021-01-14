@extends('Template.layout')


@section('main')

    @extends('Template.links')

<link rel="stylesheet" href="{{URL::asset("CSS/dashboard.css")}}">
<style>
    .password-change-button{
        background-color: #5C5C5C;
    }

    .password-change-button:hover{
        background-color: #00B5AD;
    }
</style>



@if(isset($info))
    <div id="message-div" class="info" onclick="document.getElementById('message-div').style.display = 'none';">
        {{$info}}
    </div>
@endif

@if(isset($fehler_menu))
    <div id="message-div" class="error" onclick="document.getElementById('message-div').style.display = 'none';">
        {{$fehler_menu}}
    </div>
@endif


<div id="p2" class="loading">
    <div class="close" onclick="myFunction(p2, 'p2')">X</div>
    <h1>{{__("Passwort ändern")}}</h1>
    <form action="/konto" method="post">
        @csrf
        <table id="konto-table">
            <tr>
                <td class="bottom-td">
                    <label for="opassword" class="person-label">{{__("Altes Passwort")}}</label>
                </td>
                <td class="bottom-td">
                    <label for="npassword" class="person-label">{{__("Neues Passwort")}}</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" id="opassword" name="opassword">
                </td>
                <td>
                    <input type="password" id="npassword" name="npassword">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="top-padding-td">
                    <button name="passwortChange" type="submit" class="big-buttons full-width-button">{{__("Senden")}}</button>
                </td>
            </tr>
        </table>
    </form>
</div>
@if(isset($fehler_menu))

    <script> myFunction(p2, 'p2'); </script>
@endif

<div>
<button class="big-buttons password-change-button" onclick="myFunction(p2, 'p2')">{{__("Passwort ändern")}}</button>
</div>
@endsection

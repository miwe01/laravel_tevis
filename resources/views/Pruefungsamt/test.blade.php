<form action="/benutzerAdd" method="post">
@csrf
<input name="Name">
    <button type="submit" name="submit" value="Check">Check</button>
</form>

<form action="/benutzerDelete" method="post">
    @csrf
    <input name="Name">
    <button type="submit" name="submit" value="Check">Check</button>
</form>


<!-- Layout Datei von jeder Rolle -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1" charset="UTF-8">
    <!-- Titel der mitgeschickt wird per Parameter -->
    <title></title>
</head>
<body>
<!-- header include -->
@include('Template.header')
<!--js skripte -->
<script src="{{URL::asset("JS/functions.js")}}"></script>

<!-- Main Content von jeder Rolle -->
@yield('main')
</body>
</html>

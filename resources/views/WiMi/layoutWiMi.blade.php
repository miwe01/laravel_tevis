<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1" charset="UTF-8">
    <title>Test</title>
</head>
<body>
<!-- header include -->
@include('Template.headerWiMi')
<!--js skripte -->
<script src="{{URL::asset("JS/functions.js")}}"></script>

@yield('main')
</body>
</html>

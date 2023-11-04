<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/sass/bootstrap.scss')
    @yield('stylesheets')
    <title>PVSYS</title>
</head>

<body>
    @yield('maincontent')
    @yield('scripts')
    @vite('resources/sass/bootstrap.js')
</body>

</html>

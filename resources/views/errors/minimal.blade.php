<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') | Administrador Up Trading</title>

        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
        <link href="{{ asset('img/favicon.png') }}" rel="apple-touch-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

        <link href="{{ asset('css/errors.css') }}" rel="stylesheet">
        <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Palanquin+Dark:400,500,600,700">
        <link rel="stylesheet" href="{{ asset('css/errors2.css') }}">

    </head>
    <body class="antialiased">
        @yield('content')
    </body>
</html>

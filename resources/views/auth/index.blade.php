<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
  <title>@yield('title') | Up Trading App</title>

  <link id="pagestyle" href="{{ asset('css/login.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/preloader.css') }}" rel="stylesheet">
  @yield('g-recaptcha')
  @laravelPWA
</head>

<body class="">

  <div id="loader" class="loader">
    <h1></h1>
    <span></span>
    <span></span>
    <span></span>
  </div>

  @yield('content')

  @yield('script')
  <script src="{{ asset('js/preloader.js') }}"></script>
</body>

</html>
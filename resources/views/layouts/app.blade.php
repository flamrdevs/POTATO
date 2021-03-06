<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
  {{-- <link href="{{ asset('css/bootstrap.theming.min.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('webfonts/fontawesome-free-5.15.1-web/css/all.min.css') }}" rel="stylesheet">

  @yield('head')
  
</head>

<body @yield('bodyStyle') class="bg-light-low">
  @yield('body')

  <!-- Scripts -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

  @yield('script')
</body>

</html>
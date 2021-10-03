<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->

        <!-- Styles -->

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- JS for Styles -->
        

    </head>

    <body>
    
    <!-- navbar -->
    <ul class="custom-navbar">
        <!-- <li><a href="#"><img src="{{ asset('img/logo.svg') }}" height="60" width="30"></a></li> -->
        <li><a href="#">Home</a></li>
        <li><a href="#">Settings</a></li>
    </ul>

    <div class="main">
        @yield('content')
    </div>
    
    </body>
</html>

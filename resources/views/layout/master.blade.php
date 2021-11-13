@extends('layout.base')

@section('body')
    <!-- navbar -->
    <ul class="custom-navbar">
        <!-- <li><a href="#"><img src="{{ asset('img/logo.svg') }}" height="60" width="30"></a></li> -->
        <li><a href="/">Home</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>

    <div class="main">
        @include('flash::message')
        @yield('content')
    </div>

@endsection
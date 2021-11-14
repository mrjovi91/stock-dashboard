@extends('custom_auth.base', ['title' => $title])
@section('content')

<form action="/forgot" method="post">
    @csrf
    <input class="form-input" type="text" id="email" name="email" placeholder="Email"><br>
    <input type="submit" class="form-buttons"> 
</form>
@endsection
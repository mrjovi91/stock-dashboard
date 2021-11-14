@extends('custom_auth.base', ['title' => $title])
@section('content')

<form action="/register" method="post">
    @csrf
    <input class="form-input" type="text" id="name" name="name" placeholder="Display Name"><br>
    <input class="form-input" type="text" id="email" name="email" placeholder="Email"><br>
    <input  class="form-input" type="password" id="password" name="password" placeholder="Password"><br>
    <input  class="form-input" type="password" id="vpassword" name="vpassword" placeholder="Verify Password"><br>
    <input type="submit" class="form-buttons">
    
</form>
@endsection
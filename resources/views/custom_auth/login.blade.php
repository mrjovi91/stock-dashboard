@extends('custom_auth.base', ['title' => $title])
@section('content')
<form action="/login" method="post">
    @csrf
    <input class="form-input" type="text" id="email" name="email" placeholder="Email"><br>
    <input  class="form-input" type="password" id="password" name="password" placeholder="Password"><br>
    <div class="login-box-footer">
        <input type="submit" class="form-buttons" value="Login">
        <a href="/register" class="form-buttons anchor-form-buttons">Register</a>
    </div>
    <a style="margin-left: 70px;" href="/forgot">Forgot Password?</a>
    
</form>
@endsection
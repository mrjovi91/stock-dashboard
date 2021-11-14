@extends('custom_auth.base')
@section('content')

<form action="/login" method="post">
    @csrf
    <input class="form-input" type="text" id="email" name="email" placeholder="Email"><br>
    <input  class="form-input" type="password" id="password" name="password" placeholder="Password"><br>
    <div class="login-box-footer">
        <input type="submit" class="form-buttons" value="Login"></button>
        <button class="form-buttons">Reset Password</button>
    </div>
</form>
@endsection
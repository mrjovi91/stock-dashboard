@extends('custom_auth.base', ['title' => $title])
@section('content')
<div style="text-align: center">
    <p>Your email address has not been verified yet!</p>
    <p>If you have not received a verification link in your email, click the button below to resend.</p>
</div\>
<a href="/resend-verification" class="form-buttons anchor-form-buttons">Resend Link</a>
<a href="/logout" class="form-buttons anchor-form-buttons">Logout</a>
@endsection
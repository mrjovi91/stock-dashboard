@extends('layout.master')

@section('content')
@for($i = 1; $i < 4; $i++)
    <div class="card">{{$i}}</div>
@endfor
@endsection
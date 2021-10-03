@extends('layout.master')

@section('content')
<div class="row-center">
@for($i = 1; $i <= 2; $i++)
    <div class="card row-item">{{$i}}</div>
@endfor
    <div class="chart-card row-item">3</div>
</div>

<div class="row-center">
    <table class="stocktable">
        <thead>
            <tr>
                <th>Ticker</th>
                <th>Name</th>
                <th>Industry</th>
                <th>Market Price</th>
                <th>Average Paid</th>
                <th>Position</th>
                <th>% Gain/Loss</th>
            <tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 20; $i++)
            @if($i %2 == 0)
            <tr class="stocktable-row-even">
            @else
            <tr class="stocktable-row-odd">
            @endif
                <td>Ticker</td>
                <td>Name</td>
                <td>Industry</td>
                <td>Market Price</td>
                <td>Average Paid</td>
                <td>Position</td>
                <td>% Gain/Loss</td>
            <tr>
        @endfor
        </tbody>
    <table>




@endsection
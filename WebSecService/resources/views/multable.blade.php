@extends('layouts.master')
@section('title', 'Prime Numbers')
@section('content')
<div class="card m-4 col-sm-3">	
  <div class="card-header">Multiplication Table of {{$j}}</div>
  <div class="card-body">
    <table>
      @foreach (range(1, 10) as $i)
      <tr><td>{{$i}} * {{$j}}</td><td> = {{ $i * $j }}</td></li>    
      @endforeach
    </table>
  </div>
</div>
@endsection

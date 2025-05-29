@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
<div class="row">
    <div class="m-4 col-sm-6">
        <div class="alert alert-success">
            <strong>Congratulation!</strong> Dear {{$user->name}}, your email {{$user->email}} is verified.
        </div>
    </div>
</div>
@endsection

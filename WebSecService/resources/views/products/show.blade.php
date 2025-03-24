@extends('layouts.master')

@section('title', $product['name'])

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/product' . $product['id'] . '.jpg') }}" class="img-fluid" alt="{{ $product['name'] }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $product['name'] }}</h1>
            <p class="lead">{{ $product['description'] }}</p>
            <h3>Price: ${{ number_format($product['price'], 2) }}</h3>
            <a href="{{ route('welcome') }}" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</div>
@endsection

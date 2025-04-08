@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
<div class="container mt-5">
    <!-- Hero Section -->
    <div class="row align-items-center g-5 py-5">
        <div class="col-12">
            <h1 class="display-4 fw-bold lh-1 mb-3">Discover Amazing Products</h1>
            <p class="lead mb-4">
                Welcome to our platform where quality meets innovation. Browse through our carefully curated collection of products designed to enhance your experience.
            </p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{ route('products_list') }}" class="btn btn-primary btn-lg px-4">
                    Browse Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

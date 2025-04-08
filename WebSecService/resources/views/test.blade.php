@extends('layouts.master')
@section('title', 'Test Page')
@section('content')
<div class="container my-5">
  <div class="card border-warning shadow">
    <div class="card-header bg-warning text-white">
      <h2 class="mb-0">Under Construction</h2>
    </div>
    <div class="card-body">
      <p class="card-text">This page is still under development. Please come back later.</p>
      <hr>
      <p class="mb-0">Thank you for your patience!</p>
      <div class="d-flex justify-content-center mt-4">
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

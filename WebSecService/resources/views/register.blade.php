@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="container mt-5">
    <h2>Register</h2>
    
    <!-- Display success message -->
    @if(session('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif

    <!-- Display validation errors -->
    @if($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="/register" method="POST">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <!-- <div class="mb-3">
          <label for="lucky_number" class="form-label">Lucky Number</label>
          <input type="number" name="lucky_number" id="lucky_number" class="form-control" required>
          <small class="text-muted">We will check if your lucky number is even or odd.</small>
        </div> -->
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection

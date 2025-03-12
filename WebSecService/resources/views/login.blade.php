@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <h2>Login</h2>
    
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

    <form action="/login" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
              type="email" 
              name="email" 
              id="email" 
              class="form-control" 
              value="{{ old('email') }}" 
              required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
              type="password" 
              name="password" 
              id="password" 
              class="form-control" 
              required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection

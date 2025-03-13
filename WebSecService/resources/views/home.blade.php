@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('user'))
            <div style="text-align: center; margin-top: 50px;">
                <h1>Welcome, {{ session('user')['name'] }}!</h1>
                <p>You are logged in with {{ session('user')['email'] }}</p>
                <a href="{{ url('/logout') }}" class="btn btn-danger">Logout</a>
            </div>
        @else
            <div style="text-align: center; margin-top: 50px;">
                <h1>Welcome Guest</h1>
                <p>Please <a href="{{ url('/login') }}">login</a> or <a href="{{ url('/register') }}">register</a></p>
            </div>
        @endif

        @if(session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif
    </div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .bg-custom-blue {
      background-color: #324Ab2 !important;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-custom-blue">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">Welcome</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <!-- <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/even') }}">Even Numbers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/prime') }}">Prime Numbers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/multable') }}">Multiplication Table</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('products_list') }}">Products</a>
          </li>
          @can('show_users')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users') }}">Users</a>
          </li>
          @endcan
          @can('show_students')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('students') }}">students</a>
          </li>
          @endcan
        </ul>
        <ul class="navbar-nav">
          @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('profile') }}">hello {{ auth()->user()->name }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
    <h1>@yield('header')</h1>
    @yield('content')
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

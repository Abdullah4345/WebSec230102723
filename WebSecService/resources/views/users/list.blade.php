@extends('layouts.master')
@section('title', 'Users')
@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Users Management</h2>
        @can('create_users')
        <a href="{{ route('users_create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New User
        </a>
        @endcan
    </div>

    <!-- Search Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search"></i>
                        </span>
                        <input name="keywords" type="text" class="form-control" 
                               placeholder="Search users..." value="{{ request()->keywords }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @foreach($users as $user)
        <div class="col">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">{{ $user->name }}</h5>
                        <span class="badge bg-light text-dark">#{{ $user->id }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        {{ $user->email }}
                    </div>
                    
                    <div class="mb-3">
                        <div class="text-muted small mb-2">Roles</div>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary rounded-pill me-1">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
                
                <div class="card-footer bg-light">
                    <div class="btn-group w-100">
                        @can('edit_users')
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('users_edit', [$user->id]) }}">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        @endcan
                        @can('admin_users')
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('edit_password', [$user->id]) }}">
                            <i class="fas fa-key me-1"></i>Password
                        </a>
                        @endcan
                        @can('delete_users')
                        <a class="btn btn-outline-danger btn-sm" href="{{ route('users_delete', [$user->id]) }}"
                           onclick="return confirm('Are you sure you want to delete this user?');">
                            <i class="fas fa-trash me-1"></i>Delete
                        </a>
                        @endcan

                        @can('block_users')
                        <a class="btn btn-outline-danger btn-sm" href="{{ route('users_delete', [$user->id]) }}"
                           onclick="return confirm('Are you sure you want to Block this user?');">
                            <i class="fas fa-trash me-1"></i>Block
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection

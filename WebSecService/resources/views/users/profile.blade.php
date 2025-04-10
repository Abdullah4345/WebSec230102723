@extends('layouts.master')
@section('title', 'User Profile')
@section('content')

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $user->name }}'s Profile</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Basic Information</h5>
                        <div class="d-flex mb-2">
                            <div class="fw-bold w-25">Name:</div>
                            <div>{{ $user->name }}</div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="fw-bold w-25">Email:</div>
                            <div>{{ $user->email }}</div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="fw-bold w-25">Credit:</div>
                            <div class="text-success fw-bold">${{ number_format($user->credit, 2) }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Roles & Permissions</h5>
                        <div class="mb-2">
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary rounded-pill me-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                        <div>
                            @foreach($permissions as $permission)
                                <span class="badge bg-success rounded-pill me-1">{{ $permission->display_name }}</span>
                            @endforeach
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Employee'))
                        <form action="{{ route('profile.add-credit', $user->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="amount" class="form-label">Add Credit</label>
                                <input type="number" name="amount" class="form-control" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Credit</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-end gap-2">
                @if(auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                    <a class="btn btn-outline-primary" href='{{ route("edit_password", $user->id) }}'>
                        <i class="fas fa-key me-1"></i>Change Password
                    </a>
                @endif
                @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                    <a href="{{ route('users_edit', $user->id) }}" class="btn btn-success">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.master')
@section('title', 'User Profile')
@section('content')

<div class="row">
    <div class="m-4 col-sm-6">
        <table class="table table-striped">
            <tr>
                <th>Name</th><td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Roles</th>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Permissions</th>
                <td>
                    @foreach($permissions as $permission)
                        <span class="badge bg-success">{{ $permission->display_name }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Credit Balance</th><td><strong>${{ number_format($user->credit, 2) }}</strong></td>
            </tr>
        </table>

        <!-- Add Credit Form (Only for Employees & Admins) -->
        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Employee'))
        <form action="{{ route('profile.add_credit', $user->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Add Credit</label>
                <input type="number" name="amount" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Credit</button>
        </form>
        @endif

        <div class="row mt-3">
            <div class="col col-6"></div>
            @if(auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
            <div class="col col-4">
                <a class="btn btn-primary" href='{{ route("edit_password", $user->id) }}'>Change Password</a>
            </div>
            @endif
            @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
            <div class="col col-2">
                <a href="{{ route('users_edit', $user->id) }}" class="btn btn-success form-control">Edit</a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

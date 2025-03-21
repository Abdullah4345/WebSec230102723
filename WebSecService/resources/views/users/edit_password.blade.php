@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{route('save_password', $user->id)}}" method="post">
            {{ csrf_field() }}
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">
            <strong>Error!</strong> {{$error}}
            </div>
            @endforeach

            @if(!auth()->user()->hasPermissionTo('admin_users') || auth()->id()==$user->id)
                <div class="row mb-2">
                    <div class="col-12">
                        <label class="form-label">Old Password:</label>
                        <input type="password" class="form-control" placeholder="Old Password" name="old_password" required>
                    </div>
                </div>
            @endcan

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Password Confirmtion:</label>
                    <input type="password" class="form-control" placeholder="Password Confirmtion" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
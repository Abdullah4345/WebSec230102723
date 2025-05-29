@extends('layouts.master')
@section('title', 'Edit Grade')
@section('content')

<form action="{{route('grades_save', $grade->id)}}" method="post">
    {{ csrf_field() }}
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
    <strong>Error!</strong> {{$error}}
    </div>
    @endforeach
    <div class="row mb-2">
        <div class="col">
            <label for="code" class="form-label">Student:</label>
            <select name="user_id" class="form-control">
                @foreach($users as $user)
                    <option {{ ($user->id==$grade->user_id)?"selected":"" }} value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label for="code" class="form-label">Course:</label>
            <select name="course_id" class="form-control">
                @foreach($courses as $course)
                    <option {{ ($course->id==$grade->course_id)?"selected":"" }} value="{{$course->id}}">{{$course->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Degree:</label>
            <input type="text" class="form-control" placeholder="Degree" name="degree" required value="{{$grade->degree}}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

@extends('layouts.master')
@section('title', 'List Grades')
@section('content')
<div class="row my-4">
    <div class="col col-10">
        <h1>Grades</h1>
    </div>
    <div class="col col-2">
        <a href="{{route('grades_edit')}}" class="btn btn-success form-control">Add Grade</a>
    </div>
</div>
<form>
    <div class="row mb-4">
        <div class="col col-sm-6">
            <input name="keywords" type="text"  class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="courses.name" {{ request()->order_by=="courses.name"?"selected":"" }}>Course Name</option>
                <option value="users.name" {{ request()->order_by=="users.name"?"selected":"" }}>Student Name</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
            </select>
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>


<div class="card mt-2">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Student</th>
                    <th scope="col">Course</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Freezed</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            @foreach($grades as $grade)
            <tr>
                <td scope="col">{{$grade->user->name}}</td>
                <td scope="col">{{$grade->course->name}}</td>
                <td scope="col">{{$grade->degree}} / {{$grade->course->max_degree}}</td>
                <td scope="col">
                    <div class="row mb-2">
                        <div class="col col-4">
                            <a href="{{route('grades_edit', $grade->id)}}" class="btn btn-success form-control">Edit</a>
                        </div>
                        <div class="col col-4">
                            <a href="{{route('grades_delete', $grade->id)}}" class="btn btn-danger form-control">Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
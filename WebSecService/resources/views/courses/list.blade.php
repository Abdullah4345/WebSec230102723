@extends('layouts.master')
@section('title', 'List Courses')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Courses</h1>
    </div>
    <div class="col col-2">
        <a href="{{route('courses_edit')}}" class="btn btn-success form-control">Add Course</a>
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-6">
            <input name="keywords" type="text"  class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                <option value="max_degree" {{ request()->order_by=="max_degree"?"selected":"" }}>Max Degree</option>
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

@if(!empty(request()->keywords))
<div class="card mt-2">
    <div class="card-body">
        View search result of keywords: <span>{!!request()->keywords!!}</span>
    </div>
</div>
@endif


@foreach($courses as $course)
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-12 mt-3">
                    <div class="row mb-2">
					    <div class="col-8">
					        <h3>{{$course->name}}</h3>
					    </div>
					    <div class="col col-2">
					        <a href="{{route('courses_edit', $course->id)}}" class="btn btn-success form-control">Edit</a>
					    </div>
					    <div class="col col-2">
					        <a href="{{route('courses_delete', $course->id)}}" class="btn btn-danger form-control">Delete</a>
					    </div>
					</div>
                    <table class="table table-striped">
                        <tr><th width="20%">Name</th><td>{{$course->name}}</td></tr>
                        <tr><th>Code</th><td>{{$course->code}}</td></tr>
                        <tr><th>Max Degree</th><td>{{$course->max_degree}}</td></tr>
                        <tr><th>Description</th><td>{!!$course->description!!}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
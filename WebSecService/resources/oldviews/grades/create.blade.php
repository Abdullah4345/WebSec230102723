@extends('layout')

@section('content')
<div class="container">
    <h1>Create New Grade</h1>
    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" name="course_name" id="course_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="text" name="grade" id="grade" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="credit_hours">Credit Hours</label>
            <input type="number" name="credit_hours" id="credit_hours" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="term">Term</label>
            <input type="text" name="term" id="term" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create Grade</button>
    </form>
</div>
@endsection
@extends('layout')

@section('content')
<div class="container">
    <h1>Edit Grade</h1>
    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Course Name Field -->
    <div class="form-group">
        <label for="course_name">Course Name</label>
        <input type="text" name="course_name" id="course_name" class="form-control" value="{{ $grade->course_name }}" required>
        @error('course_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Grade Field -->
    <div class="form-group">
        <label for="grade">Grade</label>
        <input type="text" name="grade" id="grade" class="form-control" value="{{ $grade->grade }}" required>
        @error('grade')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Credit Hours Field -->
    <div class="form-group">
        <label for="credit_hours">Credit Hours</label>
        <input type="number" name="credit_hours" id="credit_hours" class="form-control" value="{{ $grade->credit_hours }}" required>
        @error('credit_hours')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Term Field -->
    <div class="form-group">
        <label for="term">Term</label>
        <input type="text" name="term" id="term" class="form-control" value="{{ $grade->term }}" required>
        @error('term')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary mt-3">Update Grade</button>
</form>
</div>
@endsection
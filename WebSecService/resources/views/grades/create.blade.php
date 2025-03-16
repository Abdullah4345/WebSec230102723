@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Grade</h1>
    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="student_id">Student</label>
            <select class="form-control" id="student_id" name="student_id" required>
                <option value="">Select a student</option>
                @foreach($students as $id => $std)
                    <option value="{{ $id }}" {{ $studentId == $id ? 'selected' : '' }}>
                        {{ $std['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <select class="form-control" id="grade" name="grade" required>
                @foreach($gradeOptions as $grade)
                    <option value="{{ $grade }}">{{ $grade }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="credit_hours">Credit Hours</label>
            <input type="number" class="form-control" id="credit_hours" name="credit_hours" min="1" required>
        </div>
        <div class="form-group">
            <label for="term">Term</label>
            <input type="text" class="form-control" id="term" name="term" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Grade</button>
    </form>
</div>
@endsection

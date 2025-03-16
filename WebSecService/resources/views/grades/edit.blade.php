@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Grade</h1>
    <form action="{{ route('grades.update', $grade['id']) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" value="{{ $grade['course_name'] }}" required>
            @error('course_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="grade">Grade</label>
            <select class="form-control" id="grade" name="grade" required>
                @foreach(['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'] as $gradeOption)
                    <option value="{{ $gradeOption }}" {{ $grade['grade'] == $gradeOption ? 'selected' : '' }}>
                        {{ $gradeOption }}
                    </option>
                @endforeach
            </select>
            @error('grade')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="credit_hours">Credit Hours</label>
            <input type="number" class="form-control" id="credit_hours" name="credit_hours" value="{{ $grade['credit_hours'] }}" required min="1">
            @error('credit_hours')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="term">Term</label>
            <input type="text" class="form-control" id="term" name="term" value="{{ $grade['term'] }}" required>
            @error('term')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Grade</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection

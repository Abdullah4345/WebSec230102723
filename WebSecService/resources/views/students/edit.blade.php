@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Student</h1>
    <form action="{{ route('students.update', $id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $student['name'] }}" required>
        </div>
        <div class="form-group">
            <label for="email">Student Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $student['email'] }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>
</div>
@endsection

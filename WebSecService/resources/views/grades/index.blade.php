@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Grade Management</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Actions</th>
                <th>Grades</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $id => $student)
                <tr>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['email'] }}</td>
                    <td>
                        <a href="{{ route('grades.create', $id) }}" class="btn btn-primary btn-sm">Add Grade</a>
                    </td>
                    <td>
                        @if (isset($studentGrades[$id]))
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Grade</th>
                                        <th>Credit Hours</th>
                                        <th>Term</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentGrades[$id] as $grade)
                                        <tr>
                                            <td>{{ $grade['course_name'] }}</td>
                                            <td>{{ $grade['grade'] }}</td>
                                            <td>{{ $grade['credit_hours'] }}</td>
                                            <td>{{ $grade['term'] }}</td>
                                            <td>
                                                <a href="{{ route('grades.edit', $grade['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('grades.destroy', $grade['id']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            No grades yet
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No students found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

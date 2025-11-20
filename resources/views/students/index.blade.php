{{-- @php
    dump($students)
@endphp --}}


@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Students</h2>
    <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>Courses</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @foreach($students as $student)
        <tr>
            <td>{{ $student->student_id }}</td>
            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
            <td>{{ $student->department->name }}</td>
            <td>{{ $student->courses->pluck('name')->join(', ') }}</td>
            <td>{{ $student->email }}</td>

            <td>
                <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('students.destroy', $student) }}" 
                      method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this student?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $students->links() }}
@endsection

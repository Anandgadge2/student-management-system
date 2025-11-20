@extends('layouts.app')

@section('content')
<h3>Student Details</h3>

<div class="card p-3">

    <p><strong>ID:</strong> {{ $student->student_id }}</p>
    <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
    <p><strong>Email:</strong> {{ $student->email }}</p>

    <p><strong>Department:</strong> {{ $student->department->name ?? 'N/A' }}</p>

    <p><strong>Courses:</strong> {{ $student->courses->pluck('name')->join(', ') ?? 'N/A' }}</p>

    <p><strong>Country:</strong> {{ $student->country->name ?? 'N/A' }}</p>
    <p><strong>State:</strong> {{ $student->state->name ?? 'N/A' }}</p>
    <p><strong>City:</strong> {{ $student->city->name ?? 'N/A' }}</p>

    @if($student->profile_photo)
        <img src="{{ asset('storage/' . $student->profile_photo) }}" width="150">
    @endif

    <div class="mt-3">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

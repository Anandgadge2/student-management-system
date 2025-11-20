
@extends('layouts.app')

@section('content')
<h3>Add Student</h3>

{{-- Pass the required variables to the shared form --}}
@include('students.form', [
    'departments' => $departments,
    'countries' => $countries
])
@endsection

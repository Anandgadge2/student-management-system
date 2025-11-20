@extends('layouts.app')

@section('content')
<h3>Edit Student</h3>
@include('students.form', ['student' => $student, 'departments' => $departments])
@endsection




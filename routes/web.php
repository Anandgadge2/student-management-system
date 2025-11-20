<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::resource('students', StudentController::class);

// AJAX routes
Route::get('departments/{id}/courses', [StudentController::class, 'coursesByDepartment'])
    ->name('departments.courses');

Route::get('countries/{id}/states', [StudentController::class, 'statesByCountry'])
    ->name('countries.states');

Route::get('states/{id}/cities', [StudentController::class, 'citiesByState'])
    ->name('states.cities');

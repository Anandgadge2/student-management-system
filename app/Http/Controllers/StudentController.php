<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department;
use App\Models\Course;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('department', 'courses', 'country', 'state', 'city')->paginate(10);
     //   dump($students);
     //   dd($students);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $departments = Department::all();
        $countries = Country::all();
        return view('students.create', compact('departments', 'countries'));
    }

    public function store(Request $request)
    { //dd($request->all());
        //dump($request->all());
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'age'           => 'nullable|integer|min:1|max:120',
            'dob'           => 'nullable|date',
            'email'         => 'required|email|unique:students,email',
            'city'          => 'nullable|string',
            'pincode'       => 'nullable|string|max:10',
            'phone'         => 'nullable|string|max:15',
            'department_id' => 'required|exists:departments,id',
            'courses'       => 'nullable|array',
            'courses.*'     => 'exists:courses,id',
            'country_id'    => 'nullable|exists:countries,id',
            'state_id'      => 'nullable|exists:states,id',
            'city_id'       => 'nullable|exists:cities,id',
        ]);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $student = Student::create($data);

        if (!empty($data['courses'])) {
            $student->courses()->sync($data['courses']);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load('department', 'courses', 'country', 'state', 'city');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $departments = Department::all();
        $countries = Country::all();
        $student->load('courses', 'country', 'state', 'city');
        return view('students.edit', compact('student', 'departments', 'countries'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'age'           => 'nullable|integer|min:1|max:120',
            'dob'           => 'nullable|date',
            'email'         => 'required|email|unique:students,email,' . $student->id,
            'city'          => 'nullable|string',
            'pincode'       => 'nullable|string|max:10',
            'phone'         => 'nullable|string|max:15',
            'department_id' => 'required|exists:departments,id',
            'courses'       => 'nullable|array',
            'courses.*'     => 'exists:courses,id',
            'country_id'    => 'nullable|exists:countries,id',
            'state_id'      => 'nullable|exists:states,id',
            'city_id'       => 'nullable|exists:cities,id',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($student->profile_photo && Storage::disk('public')->exists($student->profile_photo)) {
                Storage::disk('public')->delete($student->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $student->update($data);
        $student->courses()->sync($data['courses'] ?? []);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->profile_photo && Storage::disk('public')->exists($student->profile_photo)) {
            Storage::disk('public')->delete($student->profile_photo);
        }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    // AJAX endpoints for chained selects
    public function coursesByDepartment($departmentId)
    {
        $courses = Course::where('department_id', $departmentId)->get(['id', 'name']);
        return response()->json($courses);
    }

    public function statesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)->get(['id', 'name']);
        return response()->json($states);
    }

    public function citiesByState($stateId)
    {
        $cities = City::where('state_id', $stateId)->get(['id', 'name']);
        return response()->json($cities);
    }
}

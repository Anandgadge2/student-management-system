<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;


class CoursesTableSeeder extends Seeder
{
public function run()
{
$mapping = [
'Computer Science' => ['Algorithms','Data Structures','Web Development','AI'],
'Mechanical' => ['Thermodynamics','Mechanics','CAD'],
'Civil' => ['Structural Analysis','Surveying','Concrete Technology'],
'Electronics' => ['Circuits','Digital Systems','Signal Processing'],
'Business' => ['Marketing','Finance','Human Resources']
];


foreach ($mapping as $deptName => $courses) {
$dept = Department::where('name',$deptName)->first();
if (!$dept) continue;
foreach ($courses as $c) {
Course::create(['department_id' => $dept->id, 'name' => $c]);
}
}
}
}
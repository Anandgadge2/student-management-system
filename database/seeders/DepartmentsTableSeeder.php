<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Department;


class DepartmentsTableSeeder extends Seeder
{
public function run()
{
$departments = [
'Computer Science',
'Mechanical',
'Civil',
'Electronics',
'Business'
];


foreach ($departments as $d) {
Department::firstOrCreate(['name' => $d]);

}
}
}
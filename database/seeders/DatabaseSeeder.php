<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
     
        $this->call([
    DepartmentsTableSeeder::class,
    CoursesTableSeeder::class,
    CountriesTableSeeder::class,
    StatesTableSeeder::class,
    CitiesTableSeeder::class,
]);

    }
}

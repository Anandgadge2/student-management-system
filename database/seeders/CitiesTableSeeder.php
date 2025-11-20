<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur'],
            'Karnataka' => ['Bengaluru', 'Mysore'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore'],
            'California' => ['Los Angeles', 'San Francisco'],
            'Texas' => ['Houston', 'Dallas'],
            'New York' => ['New York City', 'Buffalo'],
            'England' => ['London', 'Manchester'],
            'Scotland' => ['Edinburgh', 'Glasgow'],
            'Wales' => ['Cardiff']
        ];

        foreach ($mapping as $state => $cities) {
            $s = State::where('name', $state)->first();
            if (!$s) continue;
            foreach ($cities as $city) {
                City::create(['state_id' => $s->id, 'name' => $city]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            'India',
            'United States',
            'United Kingdom'
        ];

        foreach ($countries as $c) {
            Country::create(['name' => $c]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'India' => ['Maharashtra', 'Karnataka', 'Tamil Nadu'],
            'United States' => ['California', 'Texas', 'New York'],
            'United Kingdom' => ['England', 'Scotland', 'Wales'],
        ];

        foreach ($mapping as $country => $states) {
            $c = Country::where('name', $country)->first();
            if (!$c) continue;
            foreach ($states as $s) {
                State::create(['country_id' => $c->id, 'name' => $s]);
            }
        }
    }
}

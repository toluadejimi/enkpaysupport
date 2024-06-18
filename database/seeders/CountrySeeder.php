<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (country() as $key => $country) {
            $data = ['short_name' => $key, 'country_name' => $country, 'created_at' => now(), 'updated_at' => now()];
            Country::insert($data);
        }
    }
}

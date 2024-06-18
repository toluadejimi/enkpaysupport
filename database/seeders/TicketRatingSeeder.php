<?php

namespace Database\Seeders;

use App\Models\RatingCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Extremely Good', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Extremely Poor', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Somewhat Good', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Somewhat Poor', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slightly Good', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slightly Poor', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Good', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Poor', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Neutral', 'status' => '1',  'created_at' => now(), 'updated_at' => now()],
        ];
        RatingCategory::insert($data);
    }
}

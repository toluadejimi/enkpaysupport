<?php

namespace Database\Seeders;
use App\Models\CounterArea;
use Illuminate\Database\Seeder;

class CounterAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CounterArea::create(['number'=> '+04','description' => 'Years of experience','created_at' => now(), 'updated_at' => now()]);
        CounterArea::create(['number'=> '+04k','description' => 'Zaidesk active users','created_at' => now()]);
        CounterArea::create(['number'=> '+04','description' => 'Employees so far','created_at' => now()]);
        CounterArea::create(['number'=> '+04','description' => 'Zaidesk gateways','created_at' => now()]);
    }
}

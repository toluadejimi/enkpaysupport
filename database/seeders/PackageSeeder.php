<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Trail', 'slug' => 'Trail', 'number_of_agent' => 0, 'access_community' => 'Trail Community', 'support' => 'Trail Support', 'monthly_price' => 0, 'yearly_price' => 0, 'device_limit' => 1, 'status' => 1,'is_trail' => ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Basic', 'slug' => 'Basic', 'number_of_agent' => 2, 'access_community' => 'Full Community', 'support' => 'Basic Support', 'monthly_price' => 10, 'yearly_price' => 120, 'device_limit' => 1, 'status' => 1,'is_trail' => DEACTIVATE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Standard', 'slug' => 'Standard', 'number_of_agent' => 20, 'access_community' => 'Full Community', 'support' => 'Standard Support', 'monthly_price' => 50, 'yearly_price' => 600, 'device_limit' => 1, 'status' => 1,'is_trail' => DEACTIVATE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Premium', 'slug' => 'Premium', 'number_of_agent' => 30, 'access_community' => 'Full Community', 'support' => 'Premium Support', 'monthly_price' => 100, 'yearly_price' => 1200, 'device_limit' => 1, 'status' => 1,'is_trail' => DEACTIVATE, 'created_at' => now(), 'updated_at' => now()],
        ];
        Package::insert($data);
    }
}

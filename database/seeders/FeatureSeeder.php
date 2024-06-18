<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::create(['created_by'=>1, 'title' => 'Secure Payments', 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo.', 'icon' => 24, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()]);
        Feature::create(['created_by'=>1, 'title' => '24/7 Support', 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo..', 'icon' => 24, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()]);
        Feature::create(['created_by'=>1, 'title' => 'Quality Templates', 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo.', 'icon' => 24, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()]);
    }
}

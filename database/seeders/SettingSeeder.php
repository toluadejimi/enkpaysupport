<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['option_key' => 'build_version', 'option_value' => '6',  'created_at' => now(), 'updated_at' => now()],
            ['option_key' => 'current_version', 'option_value' => '2.0',  'created_at' => now(), 'updated_at' => now()],
            ['option_key' => 'MAIL_FROM_ADDRESS', 'option_value' => '0', 'created_at' => now(), 'updated_at' => now()],
        ];
        Setting::insert($data);
    }
}

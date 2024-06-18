<?php

namespace Database\Seeders;

use App\Models\FrontendSection;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'World Wide Service', 'description' => 'Morbi eget varius risus, venenatis liberoPellentesque in porta dui.', 'icon' => '', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Unlimited Gateway', 'description' => 'Morbi eget varius risus, venenatis liberoPellentesque in porta dui.', 'icon' => '', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Margin Trading', 'description' => 'Morbi eget varius risus, venenatis liberoPellentesque in porta dui.', 'icon' => '', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cloud Mining', 'description' => 'Morbi eget varius risus, venenatis liberoPellentesque in porta dui.', 'icon' => '', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Payment Options', 'description' => 'Morbi eget varius risus, venenatis liberoPellentesque in porta dui.', 'icon' => '', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'News And Articles', 'description' => 'Morbi eget varius risus, venenatis liberoPellentesque in porta dui.', 'icon' => '', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];
        
        Service::insert($data);
    }
}

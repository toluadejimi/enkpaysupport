<?php

namespace Database\Seeders;

use App\Models\HowItWork;
use Illuminate\Database\Seeder;

class HowItWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HowItWork::create(['title' => 'Create your account','description' => 'A sodales ac tristique ut. Proin eget nibh scelerisque condimentum','created_at' => now(), 'updated_at' => now()]);
        HowItWork::create(['title' => 'Choose Plans','description' => 'Lorem ipsum dolor amet matter consectetur adipiscing mattis.','created_at' => now()]);
        HowItWork::create(['title' => 'Start Investing','description' => 'A sodales ac tristique ut. Proin eget nibh scelerisque condimentum','created_at' => now()]);
        HowItWork::create(['title' => 'Get profits','description' => 'Eum dicta pariatur laudantium modi corrupti voluptate.','created_at' => now()]);
    }
}

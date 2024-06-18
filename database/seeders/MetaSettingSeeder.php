<?php

namespace Database\Seeders;

use App\Models\Meta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MetaSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * set default meta
         */

        Meta::insert([
            ['page_name' => 'login', 'meta_title' => 'Log In', 'meta_description' => 'ZAIPROPARTY A property management system', 'meta_keyword' => 'zaiproperty, property, property management system, property management software'],
        ]);
    }
}

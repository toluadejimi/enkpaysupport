<?php

namespace Database\Seeders;

use App\Models\CmsSetting;
use App\Models\FrontendSection;
use Illuminate\Database\Seeder;

class CmsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CmsSetting::create(['created_by' => 1, 'auth_page_title' =>'', 'auth_page_sub_title' => '', 'app_footer_text' => '', 'facebook_url' => '', 'instagram_url' => '', 'linkedin_url' => '','twitter_url'=>'','skype_url'=>'', 'created_at' => now(), 'updated_at' => now()]);
    }
}

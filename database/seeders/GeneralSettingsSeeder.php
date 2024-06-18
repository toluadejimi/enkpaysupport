<?php

namespace Database\Seeders;

use App\Models\CmsSetting;
use App\Models\FrontendSection;
use App\Models\GeneralSettings;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralSettings::create(['created_by' => 1, 'app_name' =>'', 'app_email' => '', 'app_contact_number' => '', 'app_location' => '', 'app_copyright' => '', 'app_developed' => '','app_timezone'=>'','app_debug'=>'','app_date_format'=>'','app_time_format'=>'','app_preloader'=>'','app_logo' =>'','app_fav_icon'=>'','app_footer_logo'=>'','login_left_image'=>'','created_at' => now(), 'updated_at' => now()]);
    }
}

<?php

namespace App\Http\Services;

use App\Http\Controllers\Admin\CmsSettingController;
use App\Models\CmsSetting;
use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Models\GeneralSettings;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GeneralSettingService
{
    use ResponseTrait;

    public function applicationSettingsUpdate($request)
    {
        DB::beginTransaction();
        try {

            $checkDataExistOrNot = GeneralSettings::where('created_by', auth()->id())->first();

            if ($checkDataExistOrNot && $checkDataExistOrNot != null) {
                $checkDataExistOrNot->app_name = $request->app_name;
                $checkDataExistOrNot->app_email = $request->app_email;
                $checkDataExistOrNot->app_contact_number = $request->app_contact_number;
                $checkDataExistOrNot->app_location = $request->app_location;
                $checkDataExistOrNot->app_copyright = $request->app_copyright;
                $checkDataExistOrNot->app_developed = $request->app_developed;
                $checkDataExistOrNot->app_timezone = $request->app_timezone;
                $checkDataExistOrNot->app_debug = $request->app_debug;
                $checkDataExistOrNot->app_date_format = $request->app_date_format;
                $checkDataExistOrNot->app_time_format = $request->app_time_format;

                if ($request->hasFile('app_preloader')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_preloader);
                    $checkDataExistOrNot->app_preloader = $uploaded->id;
                }
                if ($request->hasFile('app_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_logo);
                    $checkDataExistOrNot->app_logo = $uploaded->id;
                }
                if ($request->hasFile('app_fav_icon')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_fav_icon);
                    $checkDataExistOrNot->app_fav_icon = $uploaded->id;
                }
                if ($request->hasFile('app_footer_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_footer_logo);
                    $checkDataExistOrNot->app_footer_logo = $uploaded->id;
                }
                if ($request->hasFile('login_left_image')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->login_left_image);
                    $checkDataExistOrNot->login_left_image = $uploaded->id;
                }
                $checkDataExistOrNot->save();
            } else {
                $checkDataExistOrNot = new GeneralSettings();
                $checkDataExistOrNot->app_name = $request->app_name;
                $checkDataExistOrNot->app_email = $request->app_email;
                $checkDataExistOrNot->app_contact_number = $request->app_contact_number;
                $checkDataExistOrNot->app_location = $request->app_location;
                $checkDataExistOrNot->app_copyright = $request->app_copyright;
                $checkDataExistOrNot->app_developed = $request->app_developed;
                $checkDataExistOrNot->app_timezone = $request->app_timezone;
                $checkDataExistOrNot->app_debug = $request->app_debug;
                $checkDataExistOrNot->app_date_format = $request->app_date_format;
                $checkDataExistOrNot->app_time_format = $request->app_time_format;

                if ($request->hasFile('app_preloader')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_preloader);
                    $checkDataExistOrNot->app_preloader = $uploaded->id;
                }
                if ($request->hasFile('app_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_logo);
                    $checkDataExistOrNot->app_logo = $uploaded->id;
                }
                if ($request->hasFile('app_fav_icon')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_fav_icon);
                    $checkDataExistOrNot->app_fav_icon = $uploaded->id;
                }
                if ($request->hasFile('app_footer_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_footer_logo);
                    $checkDataExistOrNot->app_footer_logo = $uploaded->id;
                }
                if ($request->hasFile('login_left_image')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->login_left_image);
                    $checkDataExistOrNot->login_left_image = $uploaded->id;
                }
                $checkDataExistOrNot->tenant_id = auth()->user()->tenant_id != null ? auth()->user()->tenant_id : '';
                $checkDataExistOrNot->created_by = auth()->id();
                $checkDataExistOrNot->save();
            }
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function logoSettingsUpdate($request)
    {
        DB::beginTransaction();
        try {
            $checkDataExistOrNot = GeneralSettings::where('created_by', auth()->id())->first();

            if ($checkDataExistOrNot && $checkDataExistOrNot != null) {
                if(isset($request->app_name)){
                    $checkDataExistOrNot->app_name = $request->app_name;
                }
                if(isset($request->app_email)){
                    $checkDataExistOrNot->app_email = $request->app_email;
                }
                if(isset($request->app_contact_number)){
                    $checkDataExistOrNot->app_contact_number = $request->app_contact_number;
                }
                if(isset($request->app_location)){
                    $checkDataExistOrNot->app_location = $request->app_location;
                }
                if(isset($request->app_copyright)){
                    $checkDataExistOrNot->app_copyright = $request->app_copyright;
                }
                if(isset($request->app_developed)){
                    $checkDataExistOrNot->app_developed = $request->app_developed;
                }
                if(isset($request->app_timezone)){
                    $checkDataExistOrNot->app_timezone = $request->app_timezone;
                }
                if(isset($request->app_debug)){
                    $checkDataExistOrNot->app_debug = $request->app_debug;
                }
                if(isset($request->app_date_format)){
                    $checkDataExistOrNot->app_date_format = $request->app_date_format;
                }
                if(isset($request->app_time_format)){
                    $checkDataExistOrNot->app_time_format = $request->app_time_format;
                }



                if ($request->hasFile('app_preloader')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_preloader);
                    $checkDataExistOrNot->app_preloader = $uploaded->id;
                }
                if ($request->hasFile('app_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_logo);
                    $checkDataExistOrNot->app_logo = $uploaded->id;
                }
                if ($request->hasFile('app_fav_icon')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_fav_icon);
                    $checkDataExistOrNot->app_fav_icon = $uploaded->id;
                }
                if ($request->hasFile('app_footer_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_footer_logo);
                    $checkDataExistOrNot->app_footer_logo = $uploaded->id;
                }
                if ($request->hasFile('login_left_image')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->login_left_image);
                    $checkDataExistOrNot->login_left_image = $uploaded->id;
                }
                $checkDataExistOrNot->save();
            } else {
                $checkDataExistOrNot = new GeneralSettings();
                if(isset($request->app_name)){
                    $checkDataExistOrNot->app_name = $request->app_name;
                }
                if(isset($request->app_email)){
                    $checkDataExistOrNot->app_email = $request->app_email;
                }
                if(isset($request->app_contact_number)){
                    $checkDataExistOrNot->app_contact_number = $request->app_contact_number;
                }
                if(isset($request->app_location)){
                    $checkDataExistOrNot->app_location = $request->app_location;
                }
                if(isset($request->app_copyright)){
                    $checkDataExistOrNot->app_copyright = $request->app_copyright;
                }
                if(isset($request->app_developed)){
                    $checkDataExistOrNot->app_developed = $request->app_developed;
                }
                if(isset($request->app_timezone)){
                    $checkDataExistOrNot->app_timezone = $request->app_timezone;
                }
                if(isset($request->app_debug)){
                    $checkDataExistOrNot->app_debug = $request->app_debug;
                }
                if(isset($request->app_date_format)){
                    $checkDataExistOrNot->app_date_format = $request->app_date_format;
                }
                if(isset($request->app_time_format)){
                    $checkDataExistOrNot->app_time_format = $request->app_time_format;
                }

                if ($request->hasFile('app_preloader')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_preloader);
                    $checkDataExistOrNot->app_preloader = $uploaded->id;
                }
                if ($request->hasFile('app_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_logo);
                    $checkDataExistOrNot->app_logo = $uploaded->id;
                }
                if ($request->hasFile('app_fav_icon')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_fav_icon);
                    $checkDataExistOrNot->app_fav_icon = $uploaded->id;
                }
                if ($request->hasFile('app_footer_logo')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->app_footer_logo);
                    $checkDataExistOrNot->app_footer_logo = $uploaded->id;
                }
                if ($request->hasFile('login_left_image')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('themeSettings', $request->login_left_image);
                    $checkDataExistOrNot->login_left_image = $uploaded->id;
                }
                $checkDataExistOrNot->tenant_id = auth()->user()->tenant_id != null ? auth()->user()->tenant_id : '';
                $checkDataExistOrNot->created_by = auth()->id();
                $checkDataExistOrNot->save();
            }
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function getData(){
        return GeneralSettings::where('created_by',auth()->id())->first();
    }

//    public function allData(){
//        return CmsSetting::all();
//    }

//    public function cmsSocialLink($created_by){
//        return CmsSetting::where('created_by', $created_by)->get();
//    }

}

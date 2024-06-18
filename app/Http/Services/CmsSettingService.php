<?php

namespace App\Http\Services;

use App\Http\Controllers\Admin\CmsSettingController;
use App\Models\CmsSetting;
use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CmsSettingService
{
    use ResponseTrait;

    public function store( $request)
    {


        DB::beginTransaction();
        try {

            $checkDataExistOrNot = CmsSetting::where('created_by',auth()->id())->first();

            if($checkDataExistOrNot && $checkDataExistOrNot !=null){
                $checkDataExistOrNot->auth_page_title = $request->auth_page_title;
                $checkDataExistOrNot->auth_page_sub_title = $request->auth_page_sub_title;
                $checkDataExistOrNot->app_footer_text = $request->app_footer_text;
                $checkDataExistOrNot->facebook_url = $request->facebook_url;
                $checkDataExistOrNot->instagram_url = $request->instagram_url;
                $checkDataExistOrNot->linkedin_url = $request->linkedin_url;
                $checkDataExistOrNot->twitter_url = $request->twitter_url;
                $checkDataExistOrNot->skype_url = $request->skype_url;
                $checkDataExistOrNot->save();
            }else{
                $cmsSettings = new CmsSetting();
                $cmsSettings->auth_page_title = $request->auth_page_title;
                $cmsSettings->auth_page_sub_title = $request->auth_page_sub_title;
                $cmsSettings->app_footer_text = $request->app_footer_text;
                $cmsSettings->facebook_url = $request->facebook_url;
                $cmsSettings->instagram_url = $request->instagram_url;
                $cmsSettings->linkedin_url = $request->linkedin_url;
                $cmsSettings->twitter_url = $request->twitter_url;
                $cmsSettings->skype_url = $request->skype_url;
                $cmsSettings->tenant_id = auth()->user()->tenant_id !=null?auth()->user()->tenant_id:'';
                $cmsSettings->created_by = auth()->id();
                $cmsSettings->save();
            }
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function settingData(){
       return CmsSetting::where('created_by',auth()->id())->first();
    }

    public function cmsSocialLink($created_by){
        return CmsSetting::where('created_by', $created_by)->get();
    }

}

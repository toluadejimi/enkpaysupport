<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\GeneralSettingService;
use App\Models\Currency;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class GeneralSettingController extends Controller
{
    use ResponseTrait;
    public $generalSettingService;

    public function __construct()
    {
        $this->generalSettingService = new GeneralSettingService();
    }

    public function applicationSettingsIndex()
    {
        $data['pageTitle'] = __("Application Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subApplicationSettingActiveClass'] = 'active';
        $data['currencies'] = Currency::all();
        $data['current_currency'] = Currency::where('current_currency', 1)->first();
        $data['languages'] = Language::all();
        $data['timezones'] = getTimeZone();
        $data['default_language'] = Language::where('default', STATUS_ACTIVE)->first();
        $data['general_setting_data']= $this->generalSettingService->getData();
        return view('admin.setting.general_settings.application-settings', $data);
    }

    public function applicationSettingsStore(Request $request){

        return $this->generalSettingService->applicationSettingsUpdate($request);
    }

    public function logoSettingsIndex()
    {
        $data['pageTitle'] = __('Theme Setting');
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subColorSettingActiveClass'] = 'active';
        $data['generalSettingsLogo']=$this->generalSettingService->getData();
        return view('admin.setting.general_settings.color-settings', $data);
    }

    public function logoSettingsStore(Request $request){

        return $this->generalSettingService->logoSettingsUpdate($request);
    }

}

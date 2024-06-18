<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FrontendSectionRequest;
use App\Http\Services\CmsSettingService;
use App\Http\Services\FrontendService;
use App\Models\FrontendSection;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class FrontendController extends Controller
{
    use ResponseTrait;
    public $frontendService;
    public $cmsSettingService;

    public function __construct()
    {
        $this->frontendService = new FrontendService();
        $this->cmsSettingService = new CmsSettingService();
    }

    public function index(Request $request)
    {

        $data['pageTitle'] = __('Basic Frontend Settings');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subFrontendBasicSectionListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->frontendService->sectionList();
        }
        $data['settings_data'] =$this->cmsSettingService->settingData();
        return view('admin.setting.frontend_settings.basic_settings.index', $data);
    }

    public function section(Request $request)
    {
        $data['pageTitle'] = __('Frontend Section Settings');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subFrontendSectionListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->frontendService->sectionList();
        }
        return view('admin.setting.frontend_settings.section.index', $data);
    }

    public function frontendSectionInfo(Request $request)
    {
        $data['section'] = FrontendSection::findOrFail($request->id);
        return view('admin.setting.frontend_settings.section.edit-form', $data);
    }

    public function frontendSectionUpdate(FrontendSectionRequest $request)
    {
        return $this->frontendService->update($request);
    }
}

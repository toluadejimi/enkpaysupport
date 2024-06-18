<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FrontendSectionRequest;
use App\Http\Services\CmsSettingService;
use App\Models\FrontendSection;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class CmsSettingController extends Controller
{
    use ResponseTrait;
    public $cmsSettingService;

    public function __construct()
    {
        $this->cmsSettingService = new CmsSettingService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Basic Frontend Settings');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subFrontendBasicSectionListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->cmsSettingService->store($request);
        }
        return view('admin.setting.frontend_settings.basic_settings.index', $data);
    }

    public function frontendSectionInfo(Request $request)
    {
        $data['section'] = FrontendSection::findOrFail($request->id);
        return view('admin.setting.frontend_settings.section.edit-form', $data);
    }

    public function frontendSectionUpdate(FrontendSectionRequest $request)
    {
        return $this->cmsSettingService->update($request);
    }
}

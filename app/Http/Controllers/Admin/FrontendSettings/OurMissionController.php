<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Services\FrontendService\OurMissionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class OurMissionController extends Controller
{
    use ResponseTrait;

    public $ourMissionService;

    public function __construct()
    {
        $this->ourMissionService = new OurMissionService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Our Mission');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subOurMissionListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->ourMissionService->list();
        }
        return view('admin.setting.frontend_settings.our_mission.index', $data);
    }

    public function info($id)
    {
        $data['ourMission'] = $this->ourMissionService->getById($id);
        return view('admin.setting.frontend_settings.our_mission.edit-form', $data);
    }

    public function update($id, Request $request)
    {
        return $this->ourMissionService->update($id, $request);
    }
}

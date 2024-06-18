<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Services\FrontendService\HowItWorkService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class HowItWorkController extends Controller
{
    use ResponseTrait;

    public $howItWorkService;

    public function __construct()
    {
        $this->howItWorkService = new HowItWorkService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('How It Work');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subHowToWorkListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->howItWorkService->list();
        }
        return view('admin.setting.frontend_settings.how_it_work.index', $data);
    }

    public function info($id)
    {
        $data['howItWork'] = $this->howItWorkService->getById($id);
        return view('admin.setting.frontend_settings.how_it_work.edit-form', $data);
    }

    public function update($id, Request $request)
    {
        return $this->howItWorkService->update($id, $request);
    }
}

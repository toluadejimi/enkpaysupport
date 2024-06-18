<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FeatureRequest;
use App\Http\Services\FrontendService\FeatureService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class FeatureController extends Controller
{
    use ResponseTrait;

    public $featureService;

    public function __construct()
    {
        $this->featureService = new FeatureService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Features');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subFeatureListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->featureService->list();
        }
        return view('admin.setting.frontend_settings.features.index', $data);
    }

    public function store(FeatureRequest $request)
    {
        return $this->featureService->store($request);
    }

    public function info($id)
    {
        $data['feature'] = $this->featureService->getById($id);
        return view('admin.setting.frontend_settings.features.edit-form', $data);
    }

    public function update($id, Request $request)
    {
        return $this->featureService->update($id, $request);
    }

    public function delete(Request $request)
    {
        return $this->featureService->delete($request);
    }
}

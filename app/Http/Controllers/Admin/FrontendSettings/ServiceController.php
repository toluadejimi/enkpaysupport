<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FeatureRequest;
use App\Http\Services\FrontendService\ServiceService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTrait;

    public $serviceService;

    public function __construct()
    {
        $this->serviceService = new ServiceService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Services');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subServicesListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->serviceService->list();
        }
        return view('admin.setting.frontend_settings.services.index', $data);
    }

    public function store(FeatureRequest $request)
    {
        return $this->serviceService->store($request);
    }

    public function info($id)
    {
        $data['service'] = $this->serviceService->getById($id);
        return view('admin.setting.frontend_settings.services.edit-form', $data);
    }

    public function update($id, Request $request)
    {
        return $this->serviceService->update($id, $request);
    }
}

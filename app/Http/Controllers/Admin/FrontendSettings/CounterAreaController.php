<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FaqRequest;
use App\Http\Services\FrontendService\CounterAreaService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class CounterAreaController extends Controller
{
    use ResponseTrait;

    public $counterAreaService;

    public function __construct()
    {
        $this->counterAreaService = new CounterAreaService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Counter Area');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subCounterAreaListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->counterAreaService->list();
        }
        return view('admin.setting.frontend_settings.counter_area.index', $data);
    }

    public function info($id)
    {
        $data['counterArea'] = $this->counterAreaService->getById($id);
        return view('admin.setting.frontend_settings.counter_area.edit-form', $data);
    }

    public function store(FaqRequest $request)
    {
        return $this->counterAreaService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->counterAreaService->update($id, $request);
    }
}

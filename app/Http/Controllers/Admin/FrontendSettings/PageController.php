<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Services\FrontendService\PageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class PageController extends Controller
{
    use ResponseTrait;

    public $pageService;

    public function __construct()
    {
        $this->pageService = new PageService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Pages');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subPageListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->pageService->list();
        }
        return view('admin.setting.frontend_settings.pages.index', $data);
    }

    public function info($id)
    {
        $data['page'] = $this->pageService->getById($id);
        return view('admin.setting.frontend_settings.pages.edit-form', $data);
    }

    public function update($id, Request $request)
    {
        return $this->pageService->update($id, $request);
    }
}

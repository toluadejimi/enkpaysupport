<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FaqCategoryRequest;
use App\Http\Services\FrontendService\FaqCategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class FaqCategoryController extends Controller
{
    use ResponseTrait;

    public $faqCategoryService;

    public function __construct()
    {
        $this->faqCategoryService = new FaqCategoryService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Faq Category');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subFeqCategoryListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->faqCategoryService->list();
        }
        return view('admin.setting.frontend_settings.faq.category.index', $data);
    }

    public function info($id)
    {
        $data['faqCategory'] = $this->faqCategoryService->getById($id);
        return view('admin.setting.frontend_settings.faq.category.edit', $data);
    }

    public function store(FaqCategoryRequest $request)
    {
        return $this->faqCategoryService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->faqCategoryService->update($id, $request);
    }

    public function faqCategoryDelete(Request $request)
    {
        return $this->faqCategoryService->delete($request);
    }
}

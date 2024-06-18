<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\FaqRequest;
use App\Http\Services\FrontendService\FaqCategoryService;
use App\Http\Services\FrontendService\FaqService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class FaqController extends Controller
{
    use ResponseTrait;

    public $faqService;

    public function __construct()
    {
        $this->faqService = new FaqService;
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Faq');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subFeqListActiveClass'] = 'active';
        $categoryService = new FaqCategoryService();
        $data['catagory'] = $categoryService->getCategoryName();
        if ($request->ajax()) {
            return $this->faqService->list();
        }
        return view('admin.setting.frontend_settings.faq.index', $data);
    }

    public function info($id)
    {
        $data['faq'] = $this->faqService->getById($id);
        return view('admin.setting.frontend_settings.faq.edit-form', $data);
    }

    public function store(FaqRequest $request)
    {
        return $this->faqService->store($request);
    }

    public function update($id, FaqRequest $request)
    {
        return $this->faqService->update($id, $request);
    }

    public function faqDelete(Request $request)
    {
        return $this->faqService->delete($request);
    }
}

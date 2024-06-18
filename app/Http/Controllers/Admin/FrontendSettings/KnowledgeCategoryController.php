<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\KnowledgeCategoryRequest;
use App\Http\Services\FrontendService\KnowledgeCategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class KnowledgeCategoryController extends Controller
{
    use ResponseTrait;

    public $knowledgeCategoryService;

    public function __construct()
    {
        $this->knowledgeCategoryService = new KnowledgeCategoryService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Knowledge Category');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subKnowledgeCategoryListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->knowledgeCategoryService->list();
        }
        return view('admin.setting.frontend_settings.knowledge.category.index', $data);
    }

    public function info($id)
    {
        $data['knowledgeCategory'] = $this->knowledgeCategoryService->getById($id);
        return view('admin.setting.frontend_settings.knowledge.category.edit', $data);
    }

    public function store(KnowledgeCategoryRequest $request)
    {
        return $this->knowledgeCategoryService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->knowledgeCategoryService->update($id, $request);
    }

    public function knowledgeCategoryDelete(Request $request)
    {
        return $this->knowledgeCategoryService->delete($request);
    }
}

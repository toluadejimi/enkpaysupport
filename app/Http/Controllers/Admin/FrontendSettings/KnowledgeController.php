<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\KnowledgeRequest;
use App\Http\Services\FrontendService\KnowledgeCategoryService;
use App\Http\Services\FrontendService\KnowledgeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class KnowledgeController extends Controller
{
    use ResponseTrait;

    public $knowledgeService;

    public function __construct()
    {
        $this->knowledgeService = new KnowledgeService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Knowledge');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subKnowledgeListActiveClass'] = 'active';
        $categoryService = new KnowledgeCategoryService();
        $data['knowledge'] = $categoryService->getCategoryName();
        if ($request->ajax()) {
            return $this->knowledgeService->list();
        }
        return view('admin.setting.frontend_settings.knowledge.index', $data);
    }

    public function info($id)
    {
        $data['knowledge'] = $this->knowledgeService->getById($id);
        return view('admin.setting.frontend_settings.knowledge.edit-form', $data);
    }

    public function store(KnowledgeRequest $request)
    {
        return $this->knowledgeService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->knowledgeService->update($id, $request);
    }

    public function knowledgeDelete(Request $request)
    {
        return $this->knowledgeService->delete($request);
    }
}

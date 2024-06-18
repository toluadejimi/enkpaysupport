<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Services\NewsService;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public $newsService;

    public function __construct()
    {
        $this->newsService = new NewsService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->newsService->getData();
        }
        $data['pageTitle'] = 'News Settings';
        $data['subNavNewsSettingActiveClass'] = 'mm-active';
        return view('admin.setting.news.index', $data);
    }

    public function newsStore(NewsRequest $request)
    {
        return $this->newsService->store($request);
    }

    public function newsInfo(Request $request)
    {
        $data['data'] = News::findOrFail($request->id);
        return view('admin.setting.news.edit-form', $data);
    }

    public function newsUpdate(NewsRequest $request)
    {
        return $this->newsService->update($request);
    }

    public function newsDelete(Request $request)
    {
        return $this->newsService->delete($request);
    }

    public function newsDetails(Request $request)
    {
        $data ['pageTitle'] = "News Details";
        $data['news'] = News::findOrFail($request->id);
        return view('admin.setting.news.details', $data);
    }
}

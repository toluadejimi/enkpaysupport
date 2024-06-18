<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsAndArticlesRequest;
use App\Http\Services\FrontendService\NewsArticleService;
use App\Models\NewArticles;
use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
    public $newsArticleService;

    public function __construct()
    {
        $this->newsArticleService = new NewsArticleService();
    }

    public function newsArticlesList(Request $request)
    {
        if ($request->ajax()) {
            return $this->newsArticleService->getNewsArticlesList();
        }
        $data['pageTitle'] = 'News Articles Settings';
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subNewsArticlesListActiveClass'] = 'active';
        return view('admin.setting.frontend_settings.news_articles.index', $data);
    }

    public function newsArticlesAdd()
    {
    }

    public function newsArticlesStore(NewsAndArticlesRequest $request)
    {
        return $this->newsArticleService->newsArticlesStore($request);
    }

    public function newsArticlesEdit($id)
    {
        $data['news'] = NewArticles::findOrFail($id);
        return view('admin.setting.frontend_settings.news_articles.edit-form', $data);
    }

    public function newsArticlesUpdate(NewsAndArticlesRequest $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        return $this->newsArticleService->newsArticlesUpdate($request);
    }

    public function newsArticlesDelete($id)
    {
        return $this->newsArticleService->newsArticlesDelete($id);
    }

    public function newsArticlesDetails($id)
    {
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Http\Services\BlogCategoryService;
use App\Http\Services\BlogService;
use App\Http\Services\BlogTagService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ResponseTrait;

    public $blogService;

    public function __construct()
    {
        $this->blogService = new BlogService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->blogService->list();
        }
        $categoryService = new BlogCategoryService();
        $tagService = new BlogTagService();
        $data['pageTitle'] = __('Blog');
        $data['navBlogActiveClass'] = 'mm-active';
        $data['subNavBlogActiveClass'] = 'mm-active';
        $data['categories'] = $categoryService->activeCategory();
        $data['tags'] = $tagService->activeTag();
        return view('admin.blogs.index', $data);
    }

    public function store(BlogRequest $request)
    {
        return $this->blogService->store($request);
    }

    public function info($id)
    {
        $categoryService = new BlogCategoryService();
        $tagService = new BlogTagService();
        $data['blog'] = $this->blogService->getById($id);
        $data['categories'] = $categoryService->activeCategory();
        $data['tags'] = $tagService->activeTag();
        $data['oldTags'] = $data['blog']->tags->pluck('id')->toArray();
        return view('admin.blogs.edit-form', $data);
    }

    public function update($id, BlogRequest $request)
    {
        return $this->blogService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->blogService->deleteById($id);
    }
}

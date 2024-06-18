<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Http\Services\BlogCategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    use ResponseTrait;
    public $blogCategoryService;

    public function __construct()
    {
        $this->blogCategoryService = new BlogCategoryService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Category');
        $data['navBlogActiveClass'] = 'mm-active';
        $data['subNavBlogCategoryActiveClass'] = 'mm-active';
        if ($request->ajax()) {
            return $this->blogCategoryService->list();
        }
        return view('admin.blogs.categories.index', $data);
    }

    public function store(BlogCategoryRequest $request)
    {
        return  $this->blogCategoryService->store($request);
    }

    public function info($id)
    {
        $data['blogCategory'] = $this->blogCategoryService->getById($id);
        return view('admin.blogs.categories.edit-form', $data);
    }

    public function update(BlogCategoryRequest $request, $id)
    {
        return $this->blogCategoryService->update($id, $request);
    }
    public function delete($id)
    {
        return $this->blogCategoryService->deleteById($id);
    }

}

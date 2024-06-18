<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogTagRequest;
use App\Http\Services\BlogTagService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BlogTagController extends Controller
{
    use ResponseTrait;
    public $blogTagService;

    public function __construct()
    {
        $this->blogTagService = new BlogTagService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Tags');
        $data['navBlogActiveClass'] = 'mm-active';
        $data['subNavBlogTagActiveClass'] = 'mm-active';
        if ($request->ajax()) {
            return $this->blogTagService->list();
        }
        return view('admin.blogs.tags.index', $data);
    }

    public function store(BlogTagRequest $request)
    {
        return  $this->blogTagService->store($request);
    }
    public function info($id)
    {
        $data['blogTag'] = $this->blogTagService->getById($id);
        return view('admin.blogs.tags.edit-form', $data);
    }
    public function update(BlogTagRequest $request, $id)
    {
        return $this->blogTagService->update($id, $request);
    }
    public function delete($id)
    {
        return $this->blogTagService->deleteById($id);
    }
}

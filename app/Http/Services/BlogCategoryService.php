<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class BlogCategoryService
{
    use ResponseTrait;

    public function list()
    {
        $blogCategory = BlogCategory::all();
        return datatables($blogCategory)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">Active</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.blogs.categories.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action me-2 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.blogs.categories.delete', $data->id) . '\', \'blogCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (BlogCategory::where('slug', getSlug($request->name))->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }
            $blogCategory = new BlogCategory();
            $blogCategory->name = $request->name;
            $blogCategory->slug = $slug;
            $blogCategory->status = $request->status;
            $blogCategory->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {

            if (BlogCategory::where('slug', getSlug($request->name))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }

            $blogCategory = BlogCategory::findOrFail($id);
            $blogCategory->name = $request->name;
            $blogCategory->slug = $slug;
            $blogCategory->status = $request->status;
            $blogCategory->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return BlogCategory::findOrFail($id);
    }
   
    public function activeCategory()
    {
        return BlogCategory::where('status', STATUS_ACTIVE)->get();
    }
   
    public function getACtiveBlogCategory()
    {
        return BlogCategory::join('blogs', 'blogs.blog_category_id', 'blog_categories.id')->where('blogs.status', STATUS_ACTIVE)->groupBy('blog_categories.id')->groupBy('blog_categories.name')->select('blog_categories.name', 'blog_categories.id')->get();
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $category = BlogCategory::where('id', $id)->firstOrFail();
            if(count($category->blogs()) == 0){
                return $this->error([], __('This category is already used'));
            }
            $category->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}

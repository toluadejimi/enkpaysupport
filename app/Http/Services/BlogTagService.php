<?php

namespace App\Http\Services;

use App\Models\BlogTag;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class BlogTagService
{
    use ResponseTrait;

    public function list()
    {
        $blogtags = BlogTag::all();
        return datatables($blogtags)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.blogs.tags.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action me-2 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.blogs.tags.delete', $data->id) . '\', \'blogTagDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (BlogTag::where('slug', getSlug($request->name))->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }

            $blogTags = new BlogTag();
            $blogTags->name = $request->name;
            $blogTags->slug = $slug;
            $blogTags->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            if (BlogTag::where('slug', getSlug($request->name))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }
            $blogTags = BlogTag::findOrFail($id);
            $blogTags->name = $request->name;
            $blogTags->slug = $slug;
            $blogTags->save();
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
        return BlogTag::findOrFail($id);
    }

    public function activeTag()
    {
        return BlogTag::all();
    }

    public function deleteById($id)
    {
        try {
            $tag = BlogTag::where('id', $id)->firstOrFail();
            if(count($tag->blogs()) == 0){
                return $this->error([], __('This tag is already used'));
            }
            $tag->delete();
            DB::beginTransaction();
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

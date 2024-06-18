<?php

namespace App\Http\Services;

use App\Models\Blog;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class BlogService
{
    use ResponseTrait;

    public function list()
    {
        $features = Blog::with(['category', 'author'])->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img src="' . getFileUrl($data->thumbnail) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('author', function ($data) {
                return $data->author->name;
            })
            ->addColumn('category', function ($data) {
                return $data->category->name;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">Published</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.blogs.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.blogs.delete', $data->id) . '\', \'blogDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['status', 'thumbnail', 'action', 'name', 'blog_category_id'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (Blog::where('slug', getSlug($request->title))->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->slug = $slug;
            $blog->blog_category_id = $request->category_id;
            $blog->details = $request->details;
            $blog->status = $request->status;
            $blog->user_id = auth()->id();

            if ($request->hasFile('thumbnail')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('blog', $request->thumbnail);
                $blog->thumbnail = $uploaded->id;
            }

            $blog->save();
            $blog->tags()->sync($request->tag_ids);

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
            if (Blog::where('slug', getSlug($request->title))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $blog = Blog::where('id', $id)->firstOrFail();
            $blog->title = $request->title;
            $blog->slug = $slug;
            $blog->blog_category_id = $request->category_id;
            $blog->details = $request->details;
            $blog->status = $request->status;

            if ($request->hasFile('thumbnail')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('blog', $request->thumbnail);
                $blog->thumbnail = $uploaded->id;
            }

            $blog->save();
            $blog->tags()->sync($request->tag_ids);

            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function getById($id)
    {
        return Blog::with(['category', 'author'])->where('id', $id)->firstOrFail();
    }

    public function getBlogBySlug($slug)
    {
        return Blog::where('slug', $slug)->with(['category', 'author'])->firstOrFail();
    }

    public function getFirst()
    {
        return Blog::where('status', STATUS_ACTIVE)->with(['category', 'author'])->first();
    }

    public function deleteById($id)
    {
        try {
            $tag = Blog::where('id', $id)->firstOrFail();
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

    public function getAllActive($limit = NULL)
    {
        $first = $this->getFirst()?->id;
        if(is_null($limit)){
            return Blog::where('status', STATUS_ACTIVE)->where('id', '!=', $first)->with(['category', 'author'])->paginate(6);
        }else{
            return Blog::where('status', STATUS_ACTIVE)->limit($limit)->with(['category', 'author'])->get();
        }
    }
}

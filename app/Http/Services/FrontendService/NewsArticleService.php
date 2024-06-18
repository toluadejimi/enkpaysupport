<?php

namespace App\Http\Services\FrontendService;

use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Models\NewArticles;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class NewsArticleService
{
    use ResponseTrait;

    public function getNewsArticlesList()
    {
        $news = NewArticles::orderBy('id', 'DESC')->get();
        return datatables($news)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == ACTIVE) {
                    return '<span class="active-status">Active</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })->addColumn('created_at', function ($data) {
                return  date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.news-articles.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.frontend.news-articles.delete', $data->id) . '\', \'commonDataTable\')" class="p-1 tbl-action-btn"   title="Delete"><span class="iconify" data-icon="ep:delete-filled"></span></button>
                </div>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }
    public function newsArticlesStore($request)
    {
        try {
            DB::beginTransaction();
            $newsObj = new NewArticles();
            $newsObj->title = $request->title;
            $newsObj->description = $request->description;
            $newsObj->section_id = NEWS_AND_ARTICLES_SECTION_ID;
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('news-articles', $request->image);
                $newsObj->image = $uploaded->id;
            }
            $newsObj->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function newsArticlesUpdate($request)
    {
        try {
            DB::beginTransaction();
            $newsData = NewArticles::where('id', $request->id)->first();
            $newsData->title = $request->title;
            $newsData->description = $request->description;
            $newsData->status = $request->status;
            $newsData->section_id = NEWS_AND_ARTICLES_SECTION_ID;
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('news-articles', $request->image);
                $newsData->image = $uploaded->id;
            }
            $newsData->save();
            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function newsArticlesDelete($id)
    {
        try {
            DB::beginTransaction();
            $news = NewArticles::findOrFail($id);

            $file = FileManager::where('id', $news->image)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $news->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
    public function allActiveNews()
    {
        return NewArticles::where('status', ACTIVE)->orderBy('id', 'DESC')->get();
    }
    public function newsSection(){
        return FrontendSection::where('id', NEWS_AND_ARTICLES_SECTION_ID)->where('status', ACTIVE)->first();
    }
}
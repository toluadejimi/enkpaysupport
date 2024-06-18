<?php

namespace App\Http\Services\FrontendService;

use App\Models\FileManager;
use App\Models\Testimonial;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestimonialService
{
    use ResponseTrait;

    public function list()
    {
        $testimonials = Testimonial::where('created_by', auth()->id())->get();
        return datatables($testimonials)
            ->addIndexColumn()
            ->addColumn('logo', function ($data) {
                return '<img src="' . getFileUrl($data->logo) . '" alt="icon" class="rounded avatar-xs tbl-user-logo">';

            })
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">Active</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.testimonial.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.frontend.testimonial.delete', $data->id) . '\', \'testimonialDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })

            ->rawColumns(['logo','status', 'image', 'action'])

            ->make(true);
    }

    public function store($request)
    {

        try {
            DB::beginTransaction();
            $testimonial = new Testimonial();
            $testimonial->name = $request->name;
            $testimonial->designation = $request->designation;
            $testimonial->comment = $request->comment;
            $testimonial->star = $request->star;
            $testimonial->status = $request->status;
            $testimonial->created_by= auth()->id();
            $testimonial->updated_by= auth()->id();


            if ($request->hasFile('logo')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('testimonial', $request->logo);
                $testimonial->logo = $uploaded->id;
            }

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('testimonial', $request->image);
                $testimonial->image = $uploaded->id;
            }
            $testimonial->save();
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
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->name = $request->name;
            $testimonial->designation = $request->designation;
            $testimonial->comment = $request->comment;
            $testimonial->star = $request->star;
            $testimonial->status = $request->status;
            $testimonial->updated_by= auth()->id();

            if ($request->hasFile('logo')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('testimonial', $request->logo);
                $testimonial->logo = $uploaded->id;
            }
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('testimonial', $request->image);
                $testimonial->image = $uploaded->id;
            }
            $testimonial->save();
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
        return Testimonial::findOrFail($id);
    }

    public function getActiveTestimonial()
    {
        return Testimonial::where('status', 1)->get();
    }
    public function getHomeFrontendSection(){

        return Testimonial::where('created_by',getUserIdByTenant())->get();
    }
    public function getTenantShow(){
        return Testimonial::where('created_by',getUserIdByTenant())->get();
    }

    public function delete($request)
    {
        try {
            DB::beginTransaction();
            $data = Testimonial::findOrFail($request->id);
            $fileImage = FileManager::where('id', $data->image)->first();
            $fileLogo = FileManager::where('id', $data->logo)->first();
            if ($fileImage) {
                $fileImage->removeFile();
                $fileImage->delete();
            }
            if ($fileLogo) {
                $fileLogo->removeFile();
                $fileLogo->delete();
            }
            $data->delete();
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

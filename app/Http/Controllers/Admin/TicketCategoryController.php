<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\TicketCategoryService;
use App\Models\GalleryPoint;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    use ResponseTrait;
    public $ticketCategoryService;

    public function __construct()
    {
        $this->ticketCategoryService = new TicketCategoryService;
    }

    public function category(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketCategoryService->list();
        } else {
            $data['pageTitle'] = __('Category');
            $data['navCategoryActiveClass'] = 'mm-active';
            $data['userList'] = $this->ticketCategoryService->userList();
            return view('admin.tickets.category.index', $data);
        }
    }

    public function categoryStore(Request $request)
    {
       return $this->ticketCategoryService->sotre($request);
    }


    public function categoryEdit($id)
    {
        $data['userList'] = $this->ticketCategoryService->userList();
        $data['singleData'] = $this->ticketCategoryService->getById($id);
        $data['categoryUserData'] = $data['singleData']->users->pluck('id')->toArray();
        return view('admin.tickets.category.edit-form', $data);
    }

    public function categoryDelete($id)
    {
        return $this->ticketCategoryService->deleteById($id);
    }
}

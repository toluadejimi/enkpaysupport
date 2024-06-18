<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ticketTagService;
use App\Http\Services\TicketTagsService;
use App\Models\GalleryPoint;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TicketTagController extends Controller
{
    use ResponseTrait;
    public $ticketTagService;

    public function __construct()
    {
        $this->ticketTagService = new TicketTagsService;
    }

    public function tag(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketTagService->list();
        } else {
            $data['pageTitle'] = __('Tags');
            $data['navTagActiveClass'] = 'mm-active';
            $data['userList'] = $this->ticketTagService->userList();
            return view('admin.tickets.tag.index', $data);
        }
    }

    public function tagStore(Request $request)
    {
       return $this->ticketTagService->sotre($request);
    }
    public function tagEdit($id)
    {
        $data['userList'] = $this->ticketTagService->userList();
        $data['singleData'] = $this->ticketTagService->getById($id);
        $data['tagUserData'] = $data['singleData']->users->pluck('id')->toArray();
        return view('admin.tickets.tag.edit-form', $data);
    }
    public function tagDelete($id)
    {
        return $this->ticketTagService->deleteById($id);
    }
}

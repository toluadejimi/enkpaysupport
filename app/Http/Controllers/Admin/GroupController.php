<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\GroupService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use ResponseTrait;
    public $groupService;

    public function __construct()
    {
        $this->groupService = new GroupService();
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->groupService->list($request);
        } else {
            $data['pageTitle'] = __('Group');
            $data['subNavGroupActiveClass'] = 'mm-active';
            $data['userList'] = $this->groupService->userList();
            return view('admin.group.index', $data);
        }
    }

    public function store(Request $request)
    {
       return $this->groupService->sotre($request);
    }
    public function edit($id)
    {
        $data['singleData'] = $this->groupService->getById($id);
        $data['userList'] = $this->groupService->userList();
        return view('admin.group.edit-form', $data);
    }
    public function delete($id)
    {
        return $this->groupService->deleteById($id);
    }
}

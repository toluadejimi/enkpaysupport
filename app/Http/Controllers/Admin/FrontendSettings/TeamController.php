<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\TeamRequest;
use App\Http\Services\FrontendService\TeamService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class TeamController extends Controller
{
    use ResponseTrait;

    public $teamService;

    public function __construct()
    {
        $this->teamService = new TeamService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Team');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subTeamlListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->teamService->list();
        }
        return view('admin.setting.frontend_settings.teams.index', $data);
    }

    public function store(TeamRequest $request)
    {
        return $this->teamService->store($request);
    }

    public function info($id)
    {
        $data['team'] = $this->teamService->getById($id);
        return view('admin.setting.frontend_settings.teams.edit-form', $data);
    }

    public function update($id, Request $request)
    {
        return $this->teamService->update($id, $request);
    }

    public function delete(Request $request)
    {
        return $this->teamService->delete($request);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['title'] = 'Manage Roles';
        $data['roles'] = Role::paginate(25);
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['subNavUserRoleActiveClass'] = 'mm-active';
        return view('admin.user.role.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Role';
        $data['roles'] = Role::all();
        $data['permissions'] = Permission::all();
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserRoleActiveClass'] = 'mm-active';
        return view('admin.user.role.create', $data);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo($request->permissions);
        return $this->success([], __("Role Created Successfully"));
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Role';
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();
        $data['selected_permissions'] = DB::table('role_has_permissions')->where('role_id', $id)->select('permission_id')->pluck('permission_id')->toArray();
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserRoleActiveClass'] = 'mm-active';
        return view('admin.user.role.edit', $data);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => ['required', 'array', 'min:1'],
        ]);

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        DB::table('role_has_permissions')->where('role_id', $id)->delete();
        $role->givePermissionTo($request->permissions);
        Artisan::call('cache:clear');
        $this->success([], __("Role Updated Successfully"));
        return redirect()->route('admin.setting.role.settings');
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($id);
            $checkRoleExist = User::where('role', $id)->get()->count();

            if ($checkRoleExist == 0) {
                DB::table('role_has_permissions')->where('role_id', $id)->delete();
                $role->delete();
                $message = __("Role Deleted Successfully");
                return $this->success([], $message);
            }
            $message = __("Sorry!This Role Assigned To User");
            return $this->error([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }

    }


}

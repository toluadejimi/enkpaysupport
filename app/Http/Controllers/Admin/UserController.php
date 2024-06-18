<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\AccountingService;
use App\Http\Services\CoinService;
use App\Http\Services\UserService;
use App\Models\CmsSetting;
use App\Models\Coin;
use App\Models\Feature;
use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Models\GeneralSettings;
use App\Models\Package;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ResponseTrait;

    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('admin_list')) {
            abort('403');
        } // end permission checking
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (env('APP_DEMO') == 'active') {
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function userList(Request $request)
    {
        if ($request->ajax()) {

            $user = null;
            if(isAddonInstalled('DESKSAAS') > 0){
                if (auth()->user()->role == USER_ROLE_SUPER_ADMIN && auth()->user()->tenant_id != null) {
                    $user = User::where('role', USER_ROLE_ADMIN)->get();
                } elseif (auth()->user()->role == USER_ROLE_ADMIN && auth()->user()->tenant_id != null) {
                    $user = User::where('tenant_id', auth()->user()->tenant_id)
                        ->whereIn('role', [USER_ROLE_AGENT])
                        ->get();
                }
            } else {
                $user = User::where('tenant_id', auth()->user()->tenant_id)
                    ->whereIn('role', [USER_ROLE_AGENT])
                    ->get();
            }

            return datatables($user)
                ->addIndexColumn()
                ->addColumn('picture', function ($data) {
                    return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
                })
                ->addColumn('email', function ($data) {
                    if (auth()->user()->role == USER_ROLE_ADMIN && auth()->user()->tenant_id != null) {
                        if ($data->role == USER_ROLE_AGENT) {
                            return $data->email . '(Agent)';
                        } else {
                            return $data->email . '(Customer)';
                        }
                    } else {
                        return $data->email;
                    }
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == USER_STATUS_ACTIVE) {
                        return '<span class="">Active</span>';
                    } elseif ($data->status == STATUS_SUSPENDED) {
                        return '<span class="">Suspended</span>';
                    } else {
                        return '<span class="">Inactive</span>';
                    }

                })
                ->addColumn('action', function ($data) {
                    if ($data->status == STATUS_SUSPENDED) {
                        return '<div class="action__buttons row-gap-2 d-flex justify-content-end flex-wrap">
                    <a href="' . route('admin.user.details', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Details">
                        <img src="' . asset('admin/images/icons/eye-2.svg') . '" alt="Details">
                    </a>
                    <a href="' . route('admin.user.edit', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Update">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="Update">
                    </a>
                    <a href="' . route('admin.user.suspend', $data->id) . '" class="btn-action text-green mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Unsuspend">
                        <img src="' . asset('admin/images/icons/cancel.svg') . '" alt="Unsuspend">
                    </a>
                    <a onclick="deleteItem(\'' . route('admin.user.delete', $data->id) . '\', \'commonDataTable\')" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Trash">
                        <img src="' . asset('admin/images/icons/action/trash.svg') . '" alt="Trash">
                    </a>

                </div>';
                    } else {
                        return '<div class="action__buttons row-gap-2 d-flex justify-content-end flex-wrap">
                    <a href="' . route('admin.user.details', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Details">
                        <img src="' . asset('admin/images/icons/eye-2.svg') . '" alt="Details">
                    </a>
                    <a href="' . route('admin.user.edit', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Update">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="Update">
                    </a>
                    <a href="' . route('admin.user.suspend', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Suspend">
                        <img src="' . asset('admin/images/icons/cancel.svg') . '" alt="Suspend">
                    </a>
                    <a onclick="deleteItem(\'' . route('admin.user.delete', $data->id) . '\', \'commonDataTable\')" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Trash">
                        <img src="' . asset('admin/images/icons/action/trash.svg') . '" alt="Trash">
                    </a>

                </div>';
                    }

                })
                ->rawColumns(['status', 'picture', 'action'])
                ->make(true);
        }

        $data['pageTitle'] = 'User List';
        $data['navUser'] = 'mm-active';
        return view('admin.user.list', $data);
    }

    public function customerList()
    {

        $user = User::where('tenant_id', auth()->user()->tenant_id)
            ->whereIn('role', [USER_ROLE_CUSTOMER])
            ->get();

        return datatables($user)
            ->addIndexColumn()
            ->addColumn('picture', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('email', function ($data) {
                return $data->email . '(Customer)';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == USER_STATUS_ACTIVE) {
                    return '<span class="">Active</span>';
                } elseif ($data->status == STATUS_SUSPENDED) {
                    return '<span class="">Suspended</span>';
                } else {
                    return '<span class="">Inactive</span>';
                }

            })
            ->addColumn('action', function ($data) {
                if ($data->status == STATUS_SUSPENDED) {
                    return '<div class="action__buttons row-gap-2 d-flex justify-content-end flex-wrap">
                    <a href="' . route('admin.user.details', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Details">
                        <img src="' . asset('admin/images/icons/eye-2.svg') . '" alt="Details">
                    </a>
                    <a href="' . route('admin.user.edit', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Update">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="Update">
                    </a>
                    <a href="' . route('admin.user.suspend', $data->id) . '" class="btn-action text-green mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Unsuspend">
                        <img src="' . asset('admin/images/icons/cancel.svg') . '" alt="Unsuspend">
                    </a>
                    <a onclick="deleteItem(\'' . route('admin.user.delete', $data->id) . '\', \'commonDataTableForCustomer\')" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Trash">
                        <img src="' . asset('admin/images/icons/action/trash.svg') . '" alt="Trash">
                    </a>

                </div>';
                } else {
                    return '<div class="action__buttons row-gap-2 d-flex flex-wrap">
                    <a href="' . route('admin.user.details', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Details">
                        <img src="' . asset('admin/images/icons/eye-2.svg') . '" alt="Details">
                    </a>
                    <a href="' . route('admin.user.edit', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Update">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="Update">
                    </a>
                    <a href="' . route('admin.user.suspend', $data->id) . '" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Suspend">
                        <img src="' . asset('admin/images/icons/cancel.svg') . '" alt="Suspend">
                    </a>
                    <a onclick="deleteItem(\'' . route('admin.user.delete', $data->id) . '\', \'commonDataTableForCustomer\')" class="btn-action mr-1 edit flex-shrink-0" data-toggle="tooltip" title="Trash">
                        <img src="' . asset('admin/images/icons/action/trash.svg') . '" alt="Trash">
                    </a>

                </div>';
                }

            })
            ->rawColumns(['status', 'picture', 'action'])
            ->make(true);

    }

    public function userDetails($id)
    {
        $data['pageTitle'] = 'User Details';
        $data['navUser'] = 'mm-active';
        $data['user'] = $this->userService->userDetails($id);
        $data['domainInfo'] = $this->userService->userDomain($data['user']->tenant_id);
        return view('admin.user.details', $data);
    }

    public function userEdit($id)
    {
        $data['pageTitle'] = 'User Edit';
        $data['navUser'] = 'mm-active';
        $data['user'] = $this->userService->userDetails($id);
//        $data['user_role'] = Role::all();
        return view('admin.user.edit', $data);
    }

    public function userUpdate(Request $request)
    {
        if (isAddonInstalled('DESKSAAS') > 0) {
            if (auth()->user()->role == USER_ROLE_ADMIN && $request->user_role == USER_ROLE_AGENT) {
                if (!checkAdminCanMakeAgentOrNot()) {
                    return redirect()->back()->with('error', __("Check your agent creation limitations"));
                }
            }
        }

        try {
            DB::beginTransaction();
            $user = User::find($request->id);

            /*File Manager Call upload*/
            if ($request->profile_image) {
                $new_file = FileManager::where('id', $user->image)->first();

                if ($new_file) {
                    $new_file->removeFile();
                    $upload = $new_file->upload('User', $request->profile_image, '', $new_file->id);
                    $user->image = $upload->id;
                } else {
                    $new_file = new FileManager();
                    $upload = $new_file->upload('User', $request->profile_image);
                    $user->image = $upload->id;
                }
            }
            /*End*/
            $user->name = $request->name;
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->mobile = $request->mobile;
            $user->phone_verification_status = $request->phone_verification_status;
            $user->email_verification_status = $request->email_verification_status;
            $user->address = $request->address;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);


            if (isAddonInstalled('DESKSAAS') > 0) {
                if (auth()->user()->role == USER_ROLE_SUPER_ADMIN) {
                    $user->role = USER_ROLE_ADMIN;
                } else {
                    if (\auth()->user()->tenant_id == "" || \auth()->user()->tenant_id == null) {
                        return redirect()->back()->with('error', __("Setup your domain configuration"));
                    }
                    $user->role = $request->user_role;
                    $user->tenant_id = \auth()->user()->tenant_id;
                }
            } else {
                $user->role = $request->user_role;
                $user->tenant_id = \auth()->user()->tenant_id;
            }

            $user->updated_at = now();
            $user->save();

            DB::commit();
            return redirect()->back()->with('success', __('Updated Successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    public function userSuspend($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            if ($user->status == STATUS_SUSPENDED) {
                $msg = __('Unsuspend Successfully');
            } else {
                $msg = __('Suspend Successfully');
            }
            $user->status = $user->status == STATUS_SUSPENDED ? STATUS_ACTIVE : STATUS_SUSPENDED;
            $user->save();
            DB::commit();
            return redirect()->back()->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userDelete($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $file = FileManager::where('id', $user->image)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $user->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function userActivity(Request $request, $user_id)
    {
        if ($request->ajax()) {
            if (!$user_id) {
                return redirect()->back()->with(['dismiss' => __('User Not found.')]);
            }
            $item = UserActivityLog::where(['user_id' => $user_id])->orderBy('id', 'DESC')->get();
            return datatables($item)
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d H:i:s', strtotime($item->created_at));
                })
                ->rawColumns(['created_at'])
                ->make(true);
        }

    }

    public function userAdd()
    {
        $data['pageTitle'] = 'Add New User';
        $data['navUser'] = 'mm-active';
//        $data['user_role'] = Role::all();
        return view('admin.user.add-new', $data);
    }

    public function store(UserRequest $request)
    {
        if (isAddonInstalled('DESKSAAS') > 0) {
            if (auth()->user()->role == USER_ROLE_ADMIN && $request->user_role == USER_ROLE_AGENT) {
                if (!checkAdminCanMakeAgentOrNot()) {
                    return redirect()->back()->with('error', __("Check your agent creation limitations"));
                }
            }
        }

        try {
            DB::beginTransaction();

            if (isAddonInstalled('DESKSAAS') > 0) {
                if (auth()->user()->role == USER_ROLE_SUPER_ADMIN) {
                //domain part
                    $random = generateRandomString();
                    $central_domains = Config::get('tenancy.central_domains')[0];
                    $central_domains = implode('.', array_slice(explode('.', parse_url($central_domains, PHP_URL_HOST)), -2));
                    $domain = $random . '.' . $central_domains;
                    $ifExist = Tenant::where('id', $random)->first();
                    if ($ifExist && $ifExist != null) {
                        $random = generateRandomString();
                    }

                    $tenant = Tenant::create(['id' => $random]);
                    $tenant->domains()->create(['domain' => $domain]);
                //domain part

                }
            }

            $user = new User();

            $remember_token = Str::random(64);
            $google2fa = app('pragmarx.google2fa');

            /*File Manager Call upload*/
            if ($request->profile_image) {
                $new_file = new FileManager();
                $upload = $new_file->upload('User', $request->profile_image);
                $user->image = $upload->id;
            }
            /*End*/
            $user->name = $request->name;
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->mobile = $request->mobile;
            $user->phone_verification_status = $request->phone_verification_status;
            $user->email_verification_status = $request->email_verification_status;
            $user->address = $request->address;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);
            $user->remember_token = $remember_token;
            $user->google2fa_secret = $google2fa->generateSecretKey();

            if (isAddonInstalled('DESKSAAS') > 0) {
                if (auth()->user()->role == USER_ROLE_SUPER_ADMIN) {
                    $user->role = USER_ROLE_ADMIN;
                    $user->tenant_id = $random;

                } else {
                    if (\auth()->user()->tenant_id == "" || \auth()->user()->tenant_id == null) {
                        return redirect()->back()->with('error', __("Setup your domain configuration"));
                    }
                    $user->role = $request->user_role;
                    $user->tenant_id = \auth()->user()->tenant_id;
                }
            } else {
                $user->role = $request->user_role;
                $user->tenant_id = \auth()->user()->tenant_id;
            }

            $user->updated_at = now();
            $user->save();

            if (isAddonInstalled('DESKSAAS') > 0) {
                if (auth()->user()->role == USER_ROLE_SUPER_ADMIN) {
                    $duration = (int)getOption('trail_duration', 1);
                    $defaultPackage = Package::where(['is_trail' => ACTIVE])->first();
                    setUserPackage($user->id, $defaultPackage, $duration);

                    //tenant setting data insert
                    $frontendSectionData = [
                        ['created_by' => $user->id, 'name' => 'Hero Banner', 'title' => 'Zaidesk Simple & Secure Way to Enter your Mining.', 'slug' => 'hero_banner', 'has_image' => STATUS_ACTIVE, 'description' => 'Zaidesk is a cryptocurrency mining application designed to be a highly secure platform design for future miners. Start mining and achieve the highest level of Hashrate.', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()],
                        ['created_by' => $user->id, 'name' => 'Features Area', 'title' => 'All The logical_reason You Will Get', 'slug' => 'features_area', 'has_image' => STATUS_PENDING, 'description' => 'Nisl diam sodales lacus laoreet commodo congue. maece blandit montes lobort parturient..', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                        ['created_by' => $user->id, 'name' => 'Testimonial Area', 'title' => 'Hear what our users have said about Zaidesk.', 'slug' => 'testimonial_area', 'has_image' => STATUS_PENDING, 'description' => 'Praesent consectetur iaculis et, malesuada facilisi. Suspendisse pretium quis pulvinar tempor commodo, eget tellus morbi. Morbi netus', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                        ['created_by' => $user->id, 'name' => 'Faq Area', 'title' => 'Frequently Asked Questions', 'slug' => 'faq_area', 'has_image' => STATUS_PENDING, 'description' => 'Praesent consectetur iacul vitae, malesua facilisi. Suspendisse pretium quis pulvinar tempor commodo, at eget tellus morbi.', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                        ['created_by' => $user->id, 'name' => 'Faq Mood Area', 'title' => 'Frequently asked questions', 'slug' => 'faq_mood_area', 'has_image' => STATUS_PENDING, 'description' => 'Get answers to commonly asked questions and find solutions to your queries in our comprehensive faq section', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                        ['created_by' => $user->id, 'name' => 'knowledge Area', 'title' => 'knowledge Area', 'slug' => 'knowledge_area', 'has_image' => STATUS_PENDING, 'description' => 'knowledge area Get answers to commonly asked questions and find solutions to your queries in our comprehensive faq section', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                        ['created_by' => $user->id, 'name' => 'Need Support Area', 'title' => 'Need Support & Response within 24 hours?', 'slug' => 'need_support_area', 'has_image' => STATUS_PENDING, 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam quae ab illo inventore.', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                        ['created_by' => $user->id, 'name' => 'Looking Support Area', 'title' => 'Looking For Support?', 'slug' => 'looking_support_area', 'has_image' => STATUS_PENDING, 'description' => "Can't find the answer you're looking for? Don't worry we're here to solve your problem!", 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now()],
                    ];

                    foreach ($frontendSectionData as $item) {
                        FrontendSection::create($item);
                    }

                    $featureData = [
                        ['created_by' => $user->id, 'title' => 'Secure Payments', 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo.', 'icon' => 24, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()],
                        ['created_by' => $user->id, 'title' => '24/7 Support', 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo..', 'icon' => 24, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()],
                        ['created_by' => $user->id, 'title' => 'Quality Templates', 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ips quae sunt explicabo.', 'icon' => 24, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()]
                    ];

                    foreach ($featureData as $item) {
                        Feature::create($item);
                    }

                    CmsSetting::create(['created_by' => $user->id, 'auth_page_title' => '', 'auth_page_sub_title' => '', 'app_footer_text' => '', 'facebook_url' => '', 'instagram_url' => '', 'linkedin_url' => '', 'twitter_url' => '', 'skype_url' => '', 'created_at' => now(), 'updated_at' => now()]);
                    GeneralSettings::create(['created_by' => $user->id, 'app_name' => '', 'app_email' => '', 'app_contact_number' => '', 'app_location' => '', 'app_copyright' => '', 'app_developed' => '', 'app_timezone' => '', 'app_debug' => '', 'app_date_format' => '', 'app_time_format' => '', 'app_preloader' => '', 'app_logo' => '', 'app_fav_icon' => '', 'app_footer_logo' => '', 'login_left_image' => '', 'created_at' => now(), 'updated_at' => now()]);


                }
            }

            DB::commit();
            return redirect()->back()->with('success', __('Create Successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

}

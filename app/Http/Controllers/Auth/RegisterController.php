<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Controller;
use App\Mail\UserEmailVerification;
use App\Models\CmsSetting;
use App\Models\Feature;
use App\Models\FrontendSection;
use App\Models\GeneralSettings;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\ReCaptcha;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(getOption('google_recaptcha_status') == 1){
            return Validator::make($data, [
                'terms_and_condition' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],
                'g-recaptcha-response' => ['required', new Recaptcha()]
            ]);
        }else{
            return Validator::make($data, [
                'terms_and_condition' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        DB::beginTransaction();
        try {
            $verify_token=Str::random(64);
            $google2fa = app('pragmarx.google2fa');

            $userStatus = USER_STATUS_ACTIVE;
            if (getOption('email_verification_status', 0) == 1) {
                $userStatus = USER_STATUS_UNVERIFIED;
            }

            if(isAddonInstalled('DESKSAAS') > 0){
                $user = User::where('tenant_id', getTenantId())->first();
                if($user->role != USER_ROLE_SUPER_ADMIN){
                    $user =  User::create([
                        'role' => USER_ROLE_CUSTOMER,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'verify_token' =>$verify_token,
                        'status' => $userStatus,
                        'tenant_id' => getTenantId(),
                        'google2fa_secret' => $google2fa->generateSecretKey(),
                    ]);
                }else{
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

                    $user =  User::create([
                        'role' => USER_ROLE_ADMIN,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'verify_token' =>$verify_token,
                        'status' => $userStatus,
                        'tenant_id' => $random,
                        'google2fa_secret' => $google2fa->generateSecretKey(),
                    ]);

                    $duration = (int)getOption('trail_duration', 1);
                    $defaultPackage = Package::where(['is_trail' => ACTIVE])->first();
                    if($defaultPackage) {
                        setUserPackage($user->id, $defaultPackage, $duration);
                    }

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
            }else{
                $user =  User::create([
                    'role' => USER_ROLE_CUSTOMER,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'verify_token' =>$verify_token,
                    'status' => $userStatus,
                    'tenant_id' => getTenantId(),
                    'google2fa_secret' => $google2fa->generateSecretKey(),
                ]);
            }
            addUserActivityLog('Sign Up', $user->id);
            if (getOption('email_verification_status', 0) == 1) {
                emailVerifyEmailNotify($user);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages(['name' => __(SOMETHING_WENT_WRONG)]);
        }

    }

    protected function signup()
    {
        return view('auth.register');
    }
}

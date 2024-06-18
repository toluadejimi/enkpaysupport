<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SMSConfigRequest;
use App\Http\Services\SettingsService;
use App\Mail\TestMail;
use App\Models\ChatConfiguration;
use App\Models\CmsSetting;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Models\GeneralSettings;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Varity;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stancl\Tenancy\Database\Models\Domain;


class SettingController extends Controller
{
    use ResponseTrait;

    public $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
    }

    public function applicationSetting()
    {
        $data['pageTitle'] = __("Application Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subApplicationSettingActiveClass'] = 'active';
        $data['currencies'] = Currency::all();
        $data['current_currency'] = Currency::where('current_currency', 1)->first();
        $data['languages'] = Language::all();
        $data['timezones'] = getTimeZone();
        $data['default_language'] = Language::where('default', STATUS_ACTIVE)->first();
        return view('admin.setting.general_settings.application-settings')->with($data);
    }

    public function configurationSetting()
    {
        $data['pageTitle'] = __("Configuration Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavConfigurationSettingActiveClass'] = 'mm-active';
        return view('admin.setting.general_settings.configuration')->with($data);
    }

    public function configurationSettingConfigure(Request $request)
    {
        if ($request->key == 'email_verification_status' || $request->key == 'app_mail_status') {
            return view('admin.setting.general_settings.configuration.form.email_configuration');
        } else if ($request->key == 'app_sms_status') {
            return view('admin.setting.general_settings.configuration.form.sms_configuration');
        } else if ($request->key == 'pusher_status') {
            return view('admin.setting.general_settings.configuration.form.pusher_configuration');
        } else if ($request->key == 'google_login_status') {
            return view('admin.setting.general_settings.configuration.form.social_login_google_configuration');
        } else if ($request->key == 'facebook_login_status') {
            return view('admin.setting.general_settings.configuration.form.social_login_facebook_configuration');
        } else if ($request->key == 'google_recaptcha_status') {
            return view('admin.setting.general_settings.configuration.form.google_recaptcha_configuration');
        } else if ($request->key == 'google_analytics_status') {
            return view('admin.setting.general_settings.configuration.form.google_analytics_configuration');
        } else if ($request->key == 'chat_gpt_api_key_status') {
            return view('admin.setting.general_settings.configuration.form.chat_gtp_api_key_configuration');
        } else if ($request->key == 'enable_kyc') {
            return view('admin.setting.general_settings.configuration.form.kyc_configuration');
        } else if ($request->key == 'cookie_status') {
            return view('admin.setting.general_settings.configuration.form.cookie_configuration');
        } else if ($request->key == 'referral_status') {
            return view('admin.setting.general_settings.configuration.form.referral_configuration');
        } else if ($request->key == 'chat_setting_status') {
            $data['chatConfigurData'] = ChatConfiguration::where('created_by', auth()->id())->first();
            return view('admin.setting.general_settings.configuration.form.chat_configuration', $data);
        } else if ($request->key == 'email_ticket_config_status') {
            return view('admin.setting.general_settings.configuration.form.email_tickets_configuration');
        }
    }

    public function chatGtpApiSettingUpdate(Request $request)
    {
        $inputs = Arr::except($request->all(), ['_token']);
        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function configurationSettingHelp(Request $request)
    {
        if ($request->key == 'email_verification_status' || $request->key == 'app_mail_status') {
            return view('admin.setting.general_settings.configuration.help.email_help');
        } else if ($request->key == 'app_sms_status') {
            return view('admin.setting.general_settings.configuration.help.sms_help');
        } else if ($request->key == 'pusher_status') {
            return view('admin.setting.general_settings.configuration.help.pusher_help');
        } else if ($request->key == 'google_login_status') {
            return view('admin.setting.general_settings.configuration.help.social_login_google_help');
        } else if ($request->key == 'facebook_login_status') {
            return view('admin.setting.general_settings.configuration.help.social_login_facebook_help');
        } else if ($request->key == 'google_recaptcha_status') {
            return view('admin.setting.general_settings.configuration.help.google_recaptcha_help');
        } else if ($request->key == 'email_ticket_config_status') {
            return view('admin.setting.general_settings.configuration.help.email_ticket_config_help');
        } else if ($request->key == 'google_analytics_status') {
            return view('admin.setting.general_settings.configuration.help.google_analytics_help');
        } else if ($request->key == 'cookie_status') {
            return view('admin.setting.general_settings.configuration.help.google_cookie_consent_help');
        } else if ($request->key == 'chat_gpt_api_key_status') {
            return view('admin.setting.general_settings.configuration.help.chat_gtp_api_key_help');
        } else if ($request->key == 'app_preloader_status') {
            return view('admin.setting.general_settings.configuration.help.preloader_help');
        } else if ($request->key == 'chat_setting_status') {
            return view('admin.setting.general_settings.configuration.help.chat_setting_status_help');
        }
    }

    public function applicationSettingUpdate(Request $request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key]);

            if ($request->hasFile('app_preloader') && $key == 'app_preloader') {
                $upload = settingImageStoreUpdate($value, $request->app_preloader);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('app_logo') && $key == 'app_logo') {
                $upload = settingImageStoreUpdate($value, $request->app_logo);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('app_fav_icon') && $key == 'app_fav_icon') {
                $upload = settingImageStoreUpdate($value, $request->app_fav_icon);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('app_footer_logo') && $key == 'app_footer_logo') {
                $upload = settingImageStoreUpdate($value, $request->app_footer_logo);
                $option->option_value = $upload;
                $option->save();
            } elseif ($request->hasFile('login_left_image') && $key == 'login_left_image') {
                $upload = settingImageStoreUpdate($value, $request->login_left_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }
        /**  ====== Set Currency ====== */
        if ($request->currency_id) {
            Currency::where('id', $request->currency_id)->update(['current_currency' => 1]);
            Currency::where('id', '!=', $request->currency_id)->update(['current_currency' => 0]);
        }
        /**  ====== Set Language ====== */
        if ($request->language_id) {
            Language::where('id', $request->language_id)->update(['default' => STATUS_ACTIVE]);
            Language::where('id', '!=', $request->language_id)->update(['default' => STATUS_DEACTIVATE]);
            $language = Language::where('default', STATUS_ACTIVE)->first();
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
        }
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function configurationSettingUpdate(Request $request)
    {
        try {
            $option = Setting::firstOrCreate(['option_key' => $request->key]);
            $option->option_value = $request->value;
            $option->save();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function storageSetting()
    {
        $data['pageTitle'] = __("Storage Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subStorageSettingActiveClass'] = 'active';
        return view('admin.setting.general_settings.storage-setting')->with($data);
    }

    public function storageSettingsUpdate(Request $request)
    {
        if ($request->STORAGE_DRIVER == STORAGE_DRIVER_AWS) {
            $values = $request->validate([
                'AWS_ACCESS_KEY_ID' => 'bail|required',
                'AWS_SECRET_ACCESS_KEY' => 'bail|required',
                'AWS_DEFAULT_REGION' => 'bail|required',
                'AWS_BUCKET' => 'bail|required',
                'AWS_URL' => 'bail|required',
            ]);
        } elseif ($request->STORAGE_DRIVER == STORAGE_DRIVER_WASABI) {
            $values = $request->validate([
                'WASABI_ACCESS_KEY_ID' => 'bail|required',
                'WASABI_SECRET_ACCESS_KEY' => 'bail|required',
                'WASABI_DEFAULT_REGION' => 'bail|required',
                'WASABI_BUCKET' => 'bail|required',
            ]);
        } elseif ($request->STORAGE_DRIVER == STORAGE_DRIVER_VULTR) {
            $values = $request->validate([
                'VULTR_ACCESS_KEY_ID' => 'bail|required',
                'VULTR_SECRET_ACCESS_KEY' => 'bail|required',
                'VULTR_DEFAULT_REGION' => 'bail|required',
                'VULTR_BUCKET' => 'bail|required',
            ]);
        } elseif ($request->STORAGE_DRIVER == STORAGE_DRIVER_DO) {
            $values = $request->validate([
                'DO_ACCESS_KEY_ID' => 'bail|required',
                'DO_SECRET_ACCESS_KEY' => 'bail|required',
                'DO_DEFAULT_REGION' => 'bail|required',
                'DO_BUCKET' => 'bail|required',
                'DO_FOLDER' => 'bail|required',
                'DO_CDN_ID' => 'bail|required',
            ]);
        }
        $values['STORAGE_DRIVER'] = $request->STORAGE_DRIVER;
        if (!updateEnv($values)) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        } else {
            Artisan::call('optimize:clear');
            $this->updateSettings($values);
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        }
    }

    public function socialLoginSetting()
    {
        $data['pageTitle'] = __("Social Login Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subSocialLoginSettingActiveClass'] = 'active';
        return view('admin.setting.general_settings.social-login-settings')->with($data);
    }

    public function colorSettings()
    {
        $data['pageTitle'] = __('Color Setting');
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subColorSettingActiveClass'] = 'active';
        return view('admin.setting.general_settings.color-settings', $data);
    }

    public function googleRecaptchaSetting()
    {
        $data['pageTitle'] = __("Google Recaptcha Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subGoogleRecaptchaSettingActiveClass'] = 'active';
        return view('admin.setting.general_settings.google-recaptcha-settings')->with($data);
    }

    public function pusherConfiguration()
    {
        $data['pageTitle'] = __("Pusher Setting");
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subPusherSettingActiveClass'] = 'active';
        return view('admin.setting.general_settings.pusher-settings')->with($data);
    }


    public function mailConfiguration()
    {
        $data['pageTitle'] = __('Mail Configuration');
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subMailConfigurationActiveClass'] = 'active';
        return view('admin.setting.general_settings.mail-configuration', $data);
    }

    public function smsConfiguration()
    {
        $data['pageTitle'] = __('SMS Configuration');
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subSMSConfigurationActiveClass'] = 'active';
        return view('admin.setting.general_settings.sms-configuration', $data);
    }

    public function smsConfigurationStore(SMSConfigRequest $request)
    {
        return $this->settingsService->smsConfigurationStore($request);
    }

    public function smsTest(Request $request)
    {
        $request->validate([
            'to' => 'required|numeric|',
            'message' => 'required|',
        ]);
        return $this->settingsService->smsTest($request);
    }

    public function mailTest(Request $request)
    {

        if (!getOption('app_mail_status')) {
            return redirect()->back()->with('error', __('Check your mail configuration'));
        }

        $request->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        try {
            Mail::to($request->to)->send(new TestMail($request));
            return redirect()->back()->with('success', __(SENT_SUCCESSFULLY));
        } catch (Exception $exception) {
            return redirect()->back()->with('error', __(SOMETHING_WENT_WRONG));
        }
    }

    public function maintenanceMode()
    {
        $data['pageTitle'] = __('Maintenance Mode Settings');
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subMaintenanceModeActiveClass'] = 'active';
        return view('admin.setting.general_settings.maintenance-mode', $data);
    }

    public function maintenanceModeChange(Request $request)
    {
        if ($request->maintenance_mode == 1) {
            $request->validate(
                [
                    'maintenance_mode' => 'required',
                    'maintenance_secret_key' => 'required|min:6'
                ],
                [
                    'maintenance_secret_key.required' => 'The maintenance mode secret key is required.',
                ]
            );
        } else {
            $request->validate([
                'maintenance_mode' => 'required',
            ]);
        }

        $inputs = Arr::except($request->all(), ['_token']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }

        if ($request->maintenance_mode == 1) {
            Artisan::call('up');
            $secret_key = 'down --secret="' . $request->maintenance_secret_key . '"';
            Artisan::call($secret_key);
        } else {
            $option = Setting::firstOrCreate(['option_key' => 'maintenance_secret_key']);
            $option->option_value = null;
            $option->save();
            Artisan::call('up');
        }
        return $this->success([], __("'Maintenance Mode Has Been Changed'"));
    }

    public function saveSetting(Request $request)
    {
        $inputs = Arr::except($request->all(), ['_token']);
        $this->updateSettings($inputs);
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    private function updateSettings($inputs)
    {
        $keys = [];
        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }
        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
            setEnvironmentValue($key, $value);
        }
    }

    public function contactUsCMS()
    {
        $data['pageTitle'] = 'Contact Us CMS';
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subContactUsCMSSettingActiveClass'] = 'mm-active';
        $data['subContactUsCMSActiveClass'] = 'active';
        return view('admin.setting.contact-us', $data);
    }

    public function faq()
    {
        $data['pageTitle'] = 'FAQ Question & Answer';
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavFaqSettingActiveClass'] = 'mm-active';
        $data['subFaqActiveClass'] = 'active';
        $data['faqs'] = Faq::all();
        return view('admin.setting.faq', $data);
    }

    public function faqUpdate(Request $request)
    {
        $now = now();
        if ($request['faqs']) {
            if (count(@$request['faqs']) > 0) {
                foreach ($request['faqs'] as $faqs) {
                    if (@$faqs['question']) {
                        if (@$faqs['id']) {
                            $question_answer = Faq::find($faqs['id']);
                        } else {
                            $question_answer = new Faq();
                        }
                        $question_answer->question = @$faqs['question'];
                        $question_answer->answer = @$faqs['answer'];
                        $question_answer->updated_at = $now;
                        $question_answer->save();
                    }
                }
            }
        }
        Faq::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $q->delete();
        });
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function homeSettings()
    {
        $data['pageTitle'] = 'Home Setting';
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subHomeSettingActiveClass'] = 'mm-active';
        $data['subHomeActiveClass'] = 'active';
        return view('admin.setting.home.home-settings', $data);
    }

    public function whyUs()
    {
        $data['pageTitle'] = 'Why Us';
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subHomeSettingActiveClass'] = 'mm-active';
        $data['subWhyUsActiveClass'] = 'active';
        $data['points'] = WhyUsPoint::all();
        return view('admin.setting.home.why-us')->with($data);
    }

    public function whyUsUpdate(Request $request)
    {
        $request->validate([
            'why_us_title' => 'required|max:255',
            'why_us_subtitle' => 'required',
        ]);
        $inputs = Arr::except($request->all(), ['_token', 'why_us_points']);
        $keys = [];
        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }
        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            if ($request->hasFile('why_us_image') && $key == 'why_us_image') {
                $request->validate([
                    'why_us_image' => 'mimes:jpg,png|file|dimensions:min_width=815,min_height=639,max_width=815,max_height=639'
                ]);
                $upload = settingImageStoreUpdate($option->id, $request->why_us_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }

        $now = now();
        if ($request['why_us_points']) {
            if (count(@$request['why_us_points']) > 0) {
                foreach ($request['why_us_points'] as $why_us_point) {
                    if ($why_us_point['title'] && $why_us_point['subtitle'] || @$why_us_point['image']) {
                        if (@$why_us_point['id']) {
                            $point = WhyUsPoint::find($why_us_point['id']);
                        } else {
                            $point = new WhyUsPoint();
                        }
                        $point->updated_at = $now;
                        $point->title = @$why_us_point['title'];
                        $point->subtitle = @$why_us_point['subtitle'];
                        $point->save();

                        /*File Manager Call upload*/
                        if (@$why_us_point['id']) {
                            if (@$why_us_point['image']) {
                                $new_file = FileManager::where('origin_type', 'App\Models\WhyUsPoint')->where('origin_id', $point->id)->first();
                                if ($new_file) {
                                    $new_file->removeFile();
                                    $upload = $new_file->updateUpload($new_file->id, 'WhyUsPoint', $why_us_point['image']);
                                } else {
                                    $new_file = new FileManager();
                                    $upload = $new_file->upload('WhyUsPoint', $why_us_point['image']);
                                }

                                if (@$upload->code != 100) {
                                    $upload->origin_id = $point->id;
                                    $upload->origin_type = "App\Models\WhyUsPoint";
                                    $upload->save();
                                }
                            }
                        } else {
                            if (@$why_us_point['image']) {
                                $new_file = new FileManager();
                                $upload = $new_file->upload('WhyUsPoint', $why_us_point['image']);

                                if (@$upload->code != 100) {
                                    $upload->origin_id = $point->id;
                                    $upload->origin_type = "App\Models\WhyUsPoint";
                                    $upload->save();
                                }
                            }
                        }
                        /* End */
                    }
                }
            }
        }

        WhyUsPoint::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $file = FileManager::where('origin_type', 'App\Models\WhyUsPoint')->where('origin_id', $q->id)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $q->delete();
        });
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function testimonial()
    {
        $data['pageTitle'] = 'Testimonial';
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subHomeSettingActiveClass'] = 'mm-active';
        $data['subTestimonialActiveClass'] = 'active';
        $data['testimonials'] = Testimonial::all();
        return view('admin.setting.home.testimonial', $data);
    }

    public function testimonialUpdate(Request $request)
    {
        $request->validate([
            'testimonial_title' => 'required|max:255',
            'testimonial_subtitle' => 'required'
        ]);
        /*Setting Create or Update*/
        $inputs = Arr::except($request->all(), ['_token', 'testimonials']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }
        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }
        /*End*/

        $now = now();
        if ($request['testimonials']) {
            if (count($request['testimonials']) > 0) {
                foreach ($request['testimonials'] as $testimonial) {
                    if ($testimonial['name'] && $testimonial['designation'] && $testimonial['quote'] || @$testimonial['image']) {
                        if (@$testimonial['id']) {
                            $item = Testimonial::find($testimonial['id']);
                        } else {
                            $item = new Testimonial();
                        }

                        $item->name = $testimonial['name'];
                        $item->designation = $testimonial['designation'];
                        $item->quote = $testimonial['quote'];
                        $item->updated_at = $now;
                        $item->save();
                        /*File Manager Call upload*/
                        if (@$testimonial['id']) {
                            if (@$testimonial['image']) {
                                $new_file = FileManager::where('origin_type', 'App\Models\Testimonial')->where('origin_id', $item->id)->first();
                                if ($new_file) {
                                    $new_file->removeFile();
                                    $upload = $new_file->updateUpload($new_file->id, 'Testimonial', $testimonial['image']);
                                } else {
                                    $new_file = new FileManager();
                                    $upload = $new_file->upload('Testimonial', $testimonial['image']);
                                }

                                if (@$upload->code != 100) {
                                    $upload->origin_id = $item->id;
                                    $upload->origin_type = "App\Models\Testimonial";
                                    $upload->save();
                                }
                            }
                        } else {
                            if (@$testimonial['image']) {
                                $new_file = new FileManager();
                                $upload = $new_file->upload('Testimonial', $testimonial['image']);

                                if (@$upload->code != 100) {
                                    $upload->origin_id = $item->id;
                                    $upload->origin_type = "App\Models\Testimonial";
                                    $upload->save();
                                }
                            }
                        }
                        /*End*/
                    }
                }
            }
        }

        Testimonial::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $file = FileManager::where('origin_type', 'App\Models\Testimonial')->where('origin_id', $q->id)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $q->delete();
        });
        return redirect()->back()->with('success', 'Updated Successfully');
    }


    public function cacheSettings()
    {
        $data['pageTitle'] = __('Cache Settings');
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subCacheActiveClass'] = 'active';
        return view('admin.setting.cache-settings', $data);
    }

    public function cacheUpdate($id)
    {
        if (env('APP_DEMO') == true) {
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }
        if ($id == 1) {
            Artisan::call('view:clear');
            return redirect()->back()->with('success', 'Views cache cleared successfully');
        } elseif ($id == 2) {
            Artisan::call('route:clear');
            return redirect()->back()->with('success', 'Route cache cleared successfully');
        } elseif ($id == 3) {
            Artisan::call('config:clear');
            return redirect()->back()->with('success', 'Configuration cache cleared successfully');
        } elseif ($id == 4) {
            Artisan::call('cache:clear');
            return redirect()->back()->with('success', 'Application cache cleared successfully');
        } elseif ($id == 5) {
            try {
                $dirname = public_path("storage");
                if (is_dir($dirname)) {
                    rmdir($dirname);
                }

                Artisan::call('storage:link');
                return redirect()->back()->with('success', 'Application Storage Linked successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
        return redirect()->back();
    }

    public function migrateSettings()
    {
        $data['pageTitle'] = 'Migrate Settings';
        $data['navSettingParentActiveClass'] = 'mm-active';
        $data['subNavMigrateActiveClass'] = 'mm-active';
        $data['subMigrateActiveClass'] = 'active';
        return view('admin.setting.migrate-settings', $data);
    }

    public function migrateUpdate()
    {
        Artisan::call('migrate');
        return redirect()->back()->with('success', 'Migrated Successfully');
    }

    public function storageLink()
    {
        try {
            if (file_exists(public_path('storage'))) {
                //$this->deleteDir(public_path('storage'));
                Artisan::call('storage:link');
                return redirect()->back()->with('success', 'Created Storage Link Updated Successfully');
            } else {
                Artisan::call('storage:link');
            }
            return redirect()->back()->with('success', 'Created Storage Link Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cookieSetting()
    {
        $data['pageTitle'] = __('Features Settings');
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subCookieActiveClass'] = 'active';
        return view('admin.setting.general_settings.cookie-settings', $data);
    }


    public function commonSettingUpdate(Request $request)
    {
        return $this->settingsService->commonSettingUpdate($request);
    }

    public function cookieSettingUpdated(Request $request)
    {
        return $this->settingsService->cookieSettingUpdated($request);
    }


    public function liveChatSettings()
    {
        $data['pageTitle'] = 'Live Chat Settings';
        $data['navFeaturesParentActiveClass'] = 'mm-active';
        $data['subLiveChatActiveClass'] = 'active';
        return view('admin.setting.features_settings.live-chat-settings', $data);
    }

    public function faqSettings()
    {
        $data['pageTitle'] = 'FAQ Settings';
        $data['navFeaturesParentActiveClass'] = 'mm-active';
        $data['subFaqActiveClass'] = 'active';
        return view('admin.setting.features_settings.faq-settings', $data);
    }


    public function googleAnalyticsSetting()
    {
        $data['pageTitle'] = 'Api Settings';
        $data['navAPIParentActiveClass'] = 'mm-active';
        $data['subCoogleAnalyticsCompareApiActiveClass'] = 'active';
        return view('admin.setting.general_settings.google_analytics_settings', $data);
    }




    public function securitySettings()
    {
        $data['pageTitle'] = 'Security Settings';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subSecurityGatewayActiveClass'] = 'active';
        return view('admin.setting.general_settings.security-settings', $data);
    }


    public function countrySettings(Request $request)
    {
        if ($request->ajax()) {
            return $this->settingsService->getCountryList();
        }
        $data['pageTitle'] = 'Country Settings';
        $data['subNavCountrySettingActiveClass'] = 'mm-active';
        $data['subCountryActiveClass'] = 'active';
        return view('admin.setting.country.country', $data);
    }

    public function countrySettingsUpdate(Request $request)
    {

        try {
            $obj = Country::find($request->id);
            $obj->status = $obj->status == 1 ? 0 : 1;
            $obj->save();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));

        } catch (Exception $e) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }


    public function dbBackupSettings()
    {
        $data['pageTitle'] = __('Backup Settings');
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subDbBackupActiveClass'] = 'active';
        return view('admin.setting.database-backup-settings.index', $data);
    }

    public function createBackup($id)
    {
        try {
            if ($id == 1) {
                $backupResult = Artisan::call('backup:run --only-db');
                return redirect()->back()->with(['success' => 'Database Backed Up successfully', 'backupResult' => $backupResult]);
            } elseif ($id == 2) {
                $backupResult = Artisan::call('backup:run');
                return redirect()->back()->with(['success' => 'Source And Database Backed Up successfully', 'backupResult' => $backupResult]);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'Something Went Wrong!', 'backupResult' => $e]);
        }

    }

    public function customCSS()
    {
        $data['pageTitle'] = __('Custom CSS');
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subCustomCssActiveClass'] = 'active';
        $data['custom_css'] = getOption('custom_css');
        return view('admin.setting.general_settings.custom-css', $data);
    }


    public function trackingNoPreFixed()
    {
        $data['pageTitle'] = 'Setting';
        $data['subNavTrackingNoPreFixedSettingActiveClass'] = 'mm-active';
        $data['subCountryActiveClass'] = 'active';
        $data['configData'] = Varity::where('created_by', auth()->id())->first();
        return view('admin.setting.ticket_tracking_no', $data);
    }

    public function trackingNoPreFixedDataStore(Request $request)
    {

        $agent_fake_name_allowed = 0;
//        $rules = [
//            'pre_fixed' => 'required',
//        ];
//        $request->validate($rules);

        if (isset($request->agentFakeName)) {
            $rules['agentFakeName'] = 'required';
            if ($request->agentFakeName == 'on') {
                $agent_fake_name_allowed = 1;
            }
        };

        DB::beginTransaction();
        try {
            $checkData = Varity::where('created_by', $request->user_id)->first();
            if ($checkData && $checkData != null) {
                if ($request->pre_fixed != null) {
                    $checkData->ticket_tracking_no_pre_fixed = $request->pre_fixed;
                } else {
                    $checkData->ticket_tracking_no_pre_fixed = null;
                }
                $checkData->agent_fake_name = $agent_fake_name_allowed;
                $checkData->save();
            } else {
                $dataObj = new Varity();
                if ($request->pre_fixed != null) {
                    $dataObj->ticket_tracking_no_pre_fixed = $request->pre_fixed;
                }
                $dataObj->agent_fake_name = $request->agentFakeName;
                $dataObj->created_by = auth()->id();
                $dataObj->save();
            }

            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

}

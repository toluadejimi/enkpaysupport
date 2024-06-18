<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Paginator::useBootstrapFive();
        /**
         * Create Some Buttons
         */
        Blade::include('admin.layouts.element.form.save-with-another', 'saveWithAnotherButton');
        Blade::include('admin.layouts.element.form.update-button', 'updateButton');


        Blade::if('admin',function (){
            return auth()->check() && auth()->user()->role == 1;
        });
        if (function_exists('bcscale')) {
            bcscale(8);
        }

        try {
            $connection = DB::connection()->getPdo();
            if ($connection){
                $allOptions = [];
                $allOptions['settings'] = Setting::all()->pluck('option_value', 'option_key')->toArray();
                config($allOptions);

                config(['broadcasting.connections.pusher.key' => getOption('pusher_app_key', 'null')]);
                config(['broadcasting.connections.pusher.secret' => getOption('pusher_app_secret', 'null')]);
                config(['broadcasting.connections.pusher.app_id' => getOption('pusher_app_id', 'null')]);
                config(['broadcasting.connections.pusher.options.host' => 'api-'.getOption('pusher_cluster', 'mt1').'.pusher.com']);

                config(['app.defaultLanguage' => getDefaultLanguage()]);
                config(['app.currencySymbol' => getCurrencySymbol()]);
                config(['app.isoCode' => getIsoCode()]);
                config(['app.currencyPlacement' => getCurrencyPlacement()]);

                config(['services.google.client_id' => getOption('google_client_id')]);
                config(['services.google.client_secret' => getOption('google_client_secret')]);
                config(['services.google.redirect' => url('auth/google/callback')]);

                config(['services.facebook.client_id' => getOption('facebook_client_id')]);
                config(['services.facebook.client_secret' => getOption('facebook_client_secret')]);
                config(['services.facebook.redirect' => url('auth/facebook/callback')]);
            }

            $language = Language::where('default', ACTIVE)->first();
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }


        } catch (\Exception $e) {
            Log::info('Service Provider - '. $e->getMessage());
        }
    }
}

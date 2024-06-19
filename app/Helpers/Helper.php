<?php

use App\Http\Services\BroadcastService;
use App\Mail\EmailNotify;
use App\Mail\UserEmailVerification;
use App\Models\Announcement;
use App\Models\Conversation;
use App\Models\Envato;
use App\Models\Feature;
use App\Models\FrontendSection;
use App\Models\Package;
use App\Models\Tenant;
use App\Models\Ticket;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Varity;
use App\Models\Setting;
use App\Models\AIReplay;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Language;
use App\Models\CmsSetting;
use App\Models\FileManager;
use App\Models\UserPackage;
use App\Models\TicketRating;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Models\Notification;
use App\Models\BusinessHours;
use App\Models\EmailTemplate;
use App\Models\GeneralSettings;
use App\Models\UserActivityLog;
use App\Models\ChatConfiguration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Models\Domain;

if (!function_exists("getOption")) {
    function getOption($option_key, $default = NULL)
    {
        $system_settings = config('settings');

        if ($option_key && isset($system_settings[$option_key])) {
            return $system_settings[$option_key];
        } else {
            return $default;
        }
    }
}


function getCmsSetting($user_id, $property)
{
    $cmsSetting = CmsSetting::where('created_by', $user_id)->first();
    return isset($cmsSetting->{$property}) ? $cmsSetting->{$property} : null;
}

function getGeneralSetting($property)
{
    $tenantId = Auth::check() ? \auth()->user()->tenant_id : getTenantId();
    $cmsSetting = GeneralSettings::where('created_by', getIdByTenantId($tenantId))->first();
    return isset($cmsSetting->{$property}) ? $cmsSetting->{$property} : null;
}

function getChatConfiguration($user_id, $property)
{
    $chatConfiguration = ChatConfiguration::where('created_by', $user_id)->first();
    return isset($chatConfiguration->{$property}) ? $chatConfiguration->{$property} : null;
}

function getGeneralSettingData($user_id, $property)
{
    $data = GeneralSettings::where('created_by', $user_id)->first();
    return isset($data->{$property}) ? $data->{$property} : null;
}

function getSettingImage($option_key)
{
    if ($option_key && $option_key != null) {
        $setting = Setting::where('option_key', $option_key)->first();
        if (isset($setting->option_value) && isset($setting->option_value) != null) {
            $file = FileManager::select('path', 'storage_type')->find($setting->option_value);
            if (!is_null($file)) {
                if (Storage::disk($file->storage_type)->exists($file->path)) {
                    if ($file->storage_type == 'public') {
                        return asset('storage/' . $file->path);
                    }
                    return Storage::disk($file->storage_type)->url($file->path);
                }
            }
        }
    }
    return asset('assets/images/no-image.jpg');
}


function settingImageStoreUpdate($option_value, $requestFile)
{

    if ($requestFile) {

        /*File Manager Call upload*/
        if ($option_value && $option_value != null) {
            $new_file = FileManager::where('id', $option_value)->first();

            if ($new_file) {
                $new_file->removeFile();
                $uploaded = $new_file->upload('Setting', $requestFile, '', $new_file->id);
            } else {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('Setting', $requestFile);
            }
        } else {
            $new_file = new FileManager();
            $uploaded = $new_file->upload('Setting', $requestFile);
        }

        /*End*/

        return $uploaded->id;
    }

    return null;
}


if (!function_exists("getDefaultImage")) {
    function getDefaultImage()
    {
        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists("activeIfMatch")) {
    function activeIfMatch($path)
    {
        if (auth::user()->is_admin()) {
            return Request::is($path . '*') ? 'mm-active' : '';
        } else {
            return Request::is($path . '*') ? 'active' : '';
        }
    }
}

if (!function_exists("activeIfFullMatch")) {
    function activeIfFullMatch($path)
    {
        if (auth::user()->is_admin()) {
            return Request::is($path) ? 'mm-active' : '';
        } else {
            return Request::is($path) ? 'active' : '';
        }
    }
}

if (!function_exists("openIfFullMatch")) {
    function openIfFullMatch($path)
    {
        return Request::is($path) ? 'has-open' : '';
    }
}


if (!function_exists("toastMessage")) {
    function toastMessage($message_type, $message)
    {
        Toastr::$message_type($message, '', ['progressBar' => true, 'closeButton' => true, 'positionClass' => 'toast-top-right']);
    }
}

if (!function_exists("getDefaultLanguage")) {
    function getDefaultLanguage()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists("getCurrencySymbol")) {
    function getCurrencySymbol()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists("getIsoCode")) {
    function getIsoCode()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists("getCurrencyPlacement")) {
    function getCurrencyPlacement()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->currency_placement;
            return $placement;
        }

        return $placement;
    }
}

if (!function_exists("showPrice")) {
    function showPrice($price)
    {
        $price = getNumberFormat($price);
        if (config('app.currencyPlacement') == 'after') {
            return $price . config('app.currencySymbol');
        } else {
            return config('app.currencySymbol') . $price;
        }
    }
}


if (!function_exists("getNumberFormat")) {
    function getNumberFormat($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}

if (!function_exists("decimalToInt")) {
    function decimalToInt($amount)
    {
        return number_format(number_format($amount, 2, '.', '') * 100, 0, '.', '');
    }
}

if (!function_exists("intToDecimal")) {
}
function intToDecimal($amount)
{
    return number_format($amount / 100, 2, '.', '');
}

if (!function_exists("appLanguages")) {
    function appLanguages()
    {
        return Language::where('status', 1)->get();
    }
}

if (!function_exists("selectedLanguage")) {
    function selectedLanguage()
    {

        $language = Language::where('iso_code', session()->get('local'))->first();

        if (!$language) {
            $language = Language::find(1);
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
        }
        return $language;
    }
}

if (!function_exists("getVideoFile")) {
    function getFile($file)
    {
        if ($file == '' || $file == null) {
            return null;
        }

        try {
            if (env('STORAGE_DRIVER') == "s3") {
                if (Storage::disk('s3')->exists($file)) {
                    $s3 = Storage::disk('s3');
                    return $s3->url($file);
                }
            }
        } catch (Exception $e) {
        }

        return asset($file);
    }
}


if (!function_exists("adminNotifications")) {
    function adminNotifications()
    {
        return \App\Models\Notification::where('user_type', 1)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->paginate(5);
    }
}

if (!function_exists('getSlug')) {
    function getSlug($text)
    {
        if ($text) {
            $data = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
            $slug = preg_replace("/[\/_|+ -]+/", "-", $data);
            return $slug;
        }
        return '';
    }
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int)$buildVersion;
    }
}

if (!function_exists('setCustomerBuildVersion')) {
    function setCustomerBuildVersion($version)
    {
        $option = Setting::firstOrCreate(['option_key' => 'build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerCurrentVersion')) {
    function setCustomerCurrentVersion()
    {
        $option = Setting::firstOrCreate(['option_key' => 'current_version']);
        $option->option_value = config('app.current_version');
        $option->save();
    }
}

if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

if (!function_exists('updateEnv')) {
    function updateEnv($values)
    {
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                setEnvironmentValue($envKey, $envValue);
            }
            return true;
        }
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            if ($keyPosition) {
                if (PHP_OS_FAMILY === 'Windows') {
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                } else {
                    $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
                }
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"";
                if ($oldLine != $newLine) {
                    $str = str_replace($oldLine, $newLine, $str);
                    $str = substr($str, 0, -1);
                    $fp = fopen($envFile, 'w');
                    fwrite($fp, $str);
                    fclose($fp);
                }
            } else if (strtoupper($envKey) == $envKey) {
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"\n";
                $str .= $newLine;
                $str = substr($str, 0, -1);
                $fp = fopen($envFile, 'w');
                fwrite($fp, $str);
                fclose($fp);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('base64urlEncode')) {
    function base64urlEncode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}

if (!function_exists('getTimeZone')) {
    function getTimeZone()
    {
        return DateTimeZone::listIdentifiers(
            DateTimeZone::ALL
        );
    }
}

if (!function_exists('getErrorMessage')) {
    function getErrorMessage($e, $customMsg = null)
    {
        if ($customMsg != null) {
            return $customMsg;
        }
        if (env('APP_DEBUG')) {
            return $e->getMessage() . $e->getLine();
        } else {
            return SOMETHING_WENT_WRONG;
        }
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($id = null)
    {
        $file = FileManager::select('path', 'storage_type')->find($id);
        if (!is_null($file)) {
            if ($file->storage_type != null) {
                if (Storage::disk($file->storage_type)->exists($file->path)) {
                    if ($file->storage_type != "public") {
                        $s3 = Storage::disk($file->storage_type);
                        return $s3->url($file->path);
                    }
                    if ($file->path != '/') {
                        return asset('storage/' . $file->path);
                    }
                }
            }
        }
        return asset('assets/images/no-image.jpg');
    }
}

//function  getFileUrl($folderName, $fileName)
//{
//
//    if ($fileName == '' || $folderName == '') {
//        return asset('assets/images/no-image.jpg');
//    }
//    $destinationPath = $folderName . '/' . $fileName;
//
//    if (Storage::disk(config('app.STORAGE_DRIVER'))->exists($destinationPath)) {
//        if (config('app.STORAGE_DRIVER') != "public") {
//            $s3 = Storage::disk(config('app.STORAGE_DRIVER'));
//            return $s3->url($destinationPath);
//        }
//        if ($destinationPath != '/') {
//            return asset('storage/' . $destinationPath);
//        }
//    }
//
//    return asset('assets/images/no-image.jpg');
//}

if (!function_exists('getFileType')) {
    function getFileType($id = null)
    {
        $file = FileManager::select('file_type')->find($id);
        if (!is_null($file)) {
            return $file->file_type;
        }
        return null;
    }
}

if (!function_exists('getFileName')) {
    function getFileName($id = null)
    {
        $file = FileManager::select('file_name')->find($id);
        if (!is_null($file)) {
            return $file->file_name;
        }
        return null;
    }
}


if (!function_exists('languageLocale')) {
    function languageLocale($locale)
    {
        $data = Language::where('code', $locale)->first();
        if ($data) {
            return $data->code;
        }
        return 'en';
    }
}


if (!function_exists('getUseCase')) {
    function getUseCase($useCase = [])
    {
        if (in_array("-1", $useCase)) {
            return __("All");
        }
        return count($useCase);
    }
}

function currentCurrency($attribute = '')
{
    $currentCurrency = Currency::where('current_currency', 1)->first();
    if (isset($currentCurrency->{$attribute})) {
        return $currentCurrency->{$attribute};
    }
    return '';
}


function currentCurrencyType()
{
    $currentCurrency = Currency::where('current_currency', 1)->first();
    return $currentCurrency->currency_code;
}

function currentCurrencyIcon()
{
    $currentCurrency = Currency::where('current_currency', 1)->first();
    return $currentCurrency->symbol;
}


// Convert currency
function convertCurrency($amount, $to = 'USD', $from = 'USD')
{
    //1-BTC-GBP
    try {
        $jsondata = "";

        $coinPriceInCurrency = Setting::where('option_key', 'COIN_PRICE_IN_CURRENCY_FOR' . $from)->first();


        if ($coinPriceInCurrency != null) {

            if ($coinPriceInCurrency->option_value == null) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }

            $dateTime = Carbon::now()->addMinute(5);
            $currentTime = $dateTime->format('Y-m-d H:i:s');


            if (($coinPriceInCurrency->option_value != null) && (date('Y-m-d H:i:s', strtotime($coinPriceInCurrency->updated_at)) < $currentTime)) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }
        } else {

            $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jsondata = json_decode($json, TRUE);

            if ($jsondata != null) {
                $newObj = new Setting();
                $newObj->option_key = 'COIN_PRICE_IN_CURRENCY_FOR' . $from;
                $newObj->option_value = $jsondata[$to];
                $newObj->save();
            }
        }


        return [
            'total' => $amount * getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from),
            'price' => getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from)
        ];
    } catch (\Exception $e) {
        return [
            'total' => 0.00000000,
            'price' => 0.00000000
        ];
    }
}


function convertCurrencySwap($amount, $to = 'USD', $from = 'USD')
{
    try {
        $jsondata = "";

        $coinPriceInCurrency = Setting::where('option_key', 'COIN_PRICE_IN_CURRENCY_FOR' . $from)->first();
        if ($coinPriceInCurrency != null) {

            if ($coinPriceInCurrency->option_value == null) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }

            $dateTime = Carbon::now()->addMinute(5);
            $currentTime = $dateTime->format('Y-m-d H:i:s');

            if (($coinPriceInCurrency->option_value != null) && (date('Y-m-d H:i:s', strtotime($coinPriceInCurrency->updated_at)) < $currentTime)) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata = json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }
        } else {

            $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jsondata = json_decode($json, TRUE);

            if ($jsondata != null) {
                $newObj = new Setting();
                $newObj->option_key = 'COIN_PRICE_IN_CURRENCY_FOR' . $from;
                $newObj->option_value = $jsondata[$to];
                $newObj->save();
            }
        }

        return [
            'total' => $amount * getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from),
            'price' => getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from)
        ];
    } catch (\Exception $e) {
        return [
            'total' => 0.00000000,
            'price' => 0.00000000
        ];
    }
}

function random_strings($length_of_string)
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
}

function broadcastPrivate($eventName, $broadcastData, $userId)
{
    //    $channelName = 'private-'.env("PUSHER_PRIVATE_CHANEL_NAME").'.' . customEncrypt($userId);
    //    dispatch(new BroadcastJob($channelName, $eventName, $broadcastData))->onQueue('broadcast-data');
}

function getUserId()
{
    try {
        return Auth::id();
    } catch (\Exception $e) {
        return 0;
    }
}


if (!function_exists('visual_number_format')) {
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 10, '.', ''));
        $intVal = (int)$value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

function getError($e)
{
    if (env('APP_DEBUG')) {
        return " => " . $e->getMessage();
    }
    return '';
}

function notification($title = null, $body = null, $user_id = null, $link = null)
{
    try {
        $obj = new Notification();
        $obj->title = $title;
        $obj->body = $body;
        $obj->user_id = $user_id;
        $obj->link = $link;
        $obj->save();
        return "notification sent!";
    } catch (\Exception $e) {
        return "something error!";
    }
}

if (!function_exists('get_default_language')) {
    function get_default_language()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists('get_currency_code')) {
    function get_currency_code()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists('get_currency_placement')) {
    function get_currency_placement()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->currency_placement;
            return $placement;
        }

        return $placement;
    }
}


if (!function_exists('customNumberFormat')) {
    function customNumberFormat($value)
    {
        $number = explode('.', $value);
        if (!isset($number[1])) {
            return number_format($value, 8, '.', '');
        } else {
            $result = substr($number[1], 0, 8);
            if (strlen($result) < 8) {
                $result = number_format($value, 8, '.', '');
            } else {
                $result = $number[0] . "." . $result;
            }

            return $result;
        }
    }
}


if (!function_exists('setCommonNotification')) {
    function setCommonNotification($title, $details, $userId = NULL, $link = NULL)
    {
        try {
            DB::beginTransaction();
            $obj = new Notification();
            $obj->user_id = $userId != NULL ? $userId : NULL;
            $obj->title = $title;
            $obj->body = $details;
            $obj->link = $link != NULL ? $link : NULL;
            $obj->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

if (!function_exists('excluded_user')) {
    function excluded_user($param = null)
    {
        if ($param == null) {
            return ExcludedUser::all('user_id');
        }
        $userId = ExcludedUser::pluck('user_id')->toArray();

        return $userId;
    }
}


if (!function_exists('allsetting')) {
    function allsetting($keys = null)
    {

        if ($keys && is_array($keys)) {
            $settings = Setting::whereIn('option_key', $keys)->pluck('option_value', 'option_key')->toArray();
            $settingsNotFoundInDB = array_fill_keys(array_diff($keys, array_keys($settings)), false);
            if (!empty($settingsNotFoundInDB)) {
                $settings = array_merge($settings, $settingsNotFoundInDB);
            }
            return $settings;
        } elseif ($keys && is_string($keys)) {
            $setting = Setting::where('option_key', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return Setting::pluck('option_value', 'option_key')->toArray();
    }
}


if (!function_exists('getRandomDecimal')) {
    function getRandomDecimal($min, $max, $probabilityRatio)
    {
        // Calculate the adjusted maximum value based on the probability ratio
        $adjustedMax = $max + ($max - $min) * ($probabilityRatio - 1);

        // Generate a random decimal number within the range
        $randomDecimal = mt_rand($min * 10000, $adjustedMax * 10000) / 10000;

        // Check if the random decimal number needs to be adjusted
        if ($randomDecimal > $max) {
            // Set the number to the maximum value
            $randomDecimal = $max;
        }

        return $randomDecimal;
    }
}

if (!function_exists('privateUserNotification')) {
    function privateUserNotification()
    {
        return Notification::where('user_id', Auth::id())
            ->where('status', ACTIVE)
            ->orderBy('id', 'DESC')
            ->where('view_status', STATUS_PENDING)
            ->get();
    }
}
if (!function_exists('publicUserNotification')) {
    function publicUserNotification()
    {
        return Notification::where('user_id', null)
            ->where('status', ACTIVE)
            ->orderBy('id', 'DESC')
            ->where('view_status', STATUS_PENDING)
            ->get();
    }
}
//if (!function_exists('userNotification')) {
//    function userNotification()
//    {
//        return Notification::where(function ($query) {
//            $query->where('user_id', null)->orWhere('user_id', Auth::id());
//        })->where('status', ACTIVE)
//            ->where('view_status', STATUS_PENDING)
//            ->orderBy('id', 'DESC')
//            ->get();
//    }
//}

if (!function_exists('userNotification')) {
    function userNotification($type)
    {
        if ($type == 'seen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', '!=', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        } else if ($type == 'unseen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);

        } else if ($type == 'seen-unseen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        }

    }
}

function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

function addUserActivityLog($action, $user_id, $ticket_id = null)
{
    $current_ip = get_clientIp();
    $agent = new Agent();
    $deviceType = isset($agent) && $agent->isMobile() == true ? 'Mobile' : 'Web';
    $location = geoip()->getLocation($current_ip);
    $activity['user_id'] = $user_id;
    $activity['action'] = $action;
    $activity['ip_address'] = isset($current_ip) ? $current_ip : '0.0.0.0';
    $activity['source'] = $deviceType;
    $activity['location'] = $location->country;
    $activity['ticket_id'] = $ticket_id != null ? $ticket_id : '';
    UserActivityLog::create($activity);
}

function getEmailTemplate($template, $property, $link = null, $ticketData = null, $userData = null)
{
    $data = EmailTemplate::where('slug', $template)->first();
    if ($data && $data != null) {
        if ($property == 'body') {
            $body = $data->{$property};
            if($data->slug=='email-verification'){
                foreach (emailTempFields() as $key => $item) {
                    if ($key == '{{otp}}') {
                        $body = str_replace($key, $ticketData->otp, $body);
                    } else if ($key == '{{username}}') {
                        $body = str_replace($key, $userData['name'], $body);
                    } else {
                        $body = str_replace($key, $item, $body);
                    }
                }
                return $body;
            }
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{reset_password_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{email_verify_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{tracking_no}}') {
                    $body = str_replace($key, $ticketData->tracking_no, $body);
                } else if ($key == '{{ticket_title}}') {
                    $body = str_replace($key, $ticketData->ticket_title, $body);
                }else if ($key == '{{conversion_body}}') {
                    $body = str_replace($key, $ticketData->conv?->body, $body);
                }else if ($key == '{{ticket_description}}') {
                    $body = str_replace($key, $ticketData->ticket_description, $body);
                } else if ($key == '{{ticket_category}}') {
                    $body = str_replace($key, getCategoryNameById($ticketData->category_id), $body);
                } else if ($key == '{{ticket_created_time}}') {
                    $body = str_replace($key, date('d-m-Y H:i:s', strtotime($ticketData->created_at)), $body);
                } else if ($key == '{{username}}') {
                    $body = str_replace($key, $userData['name'], $body);
                } else if ($key == '{{app_name}}') {
                    $body = str_replace($key, getGeneralSetting('app_name'), $body);
                } else if ($key == '{{contact_email}}') {
                    $body = str_replace($key, getGeneralSetting('app_email'), $body);
                } else if ($key == '{{contact_phone}}') {
                    $body = str_replace($key, getGeneralSetting('app_contact_number'), $body);
                } else {
                    $body = str_replace($key, $item, $body);
                }
            }
            return $body;
        } else if ($property == 'subject') {

            $subject = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{tracking_no}}') {
                    if ($template != 'email-verification'){
                        $subject = str_replace($key, $ticketData->tracking_no, $subject);
                    }
                }
            }
            return $subject;
        } else {
            return $data->{$property};
        }
    }
    return '';
}

//function getEmailTemplate($category, $property, $link = null, $emailCustomDataArray = null)
//{
//    $data = EmailTemplate::where('category', $category)->first();
//    if ($data && $data != null) {
//        if ($property == 'body') {
//            $body = $data->{$property};
//            foreach (emailTempFields() as $key => $item) {
//                if ($key == '{{reset_password_url}}') {
//                    $body = str_replace($key, $link, $body);
//                } else if ($key == '{{email_verify_url}}') {
//                    $body = str_replace($key, $link, $body);
//                } else if (is_array($data) && array_key_exists($key, $data) && isset($data[$key])) {
//                    $body = str_replace($key, $data[$key], $body);
//                } else if (is_array($emailCustomDataArray) && array_key_exists($key, $emailCustomDataArray) && isset($emailCustomDataArray[$key])) {
//
//                    $body = str_replace($key, $emailCustomDataArray[$key], $body);
//                } else {
//                    $body = str_replace($key, $item, $body);
//                }
//            }
//            return $body;
//        } else {
//            return $data->{$property};
//        }
//    }
//    return '';
//}

function currencyPrice($price)
{
    if ($price == null) {
        return 0;
    }
    if (getCurrencyPlacement() == 'after')
        return number_format($price, 2) . '' . getCurrencySymbol();
    else {
        return getCurrencySymbol() . number_format($price, 2);
    }
}

if (!function_exists('setUserPackage')) {
    function setUserPackage($userId, $package, $duration, $orderId = NULL)
    {
        try {
            UserPackage::where(['user_id' => $userId])->whereIn('status', [ACTIVE, INITIATE])->update(['status' => DEACTIVATE]);

            UserPackage::create([
                'user_id' => $userId,
                'package_id' => $package->id,
                'name' => $package->name,
                'number_of_agent' => $package->number_of_agent,
                'custom_domain_setup' => $package->custom_domain_setup,
                'access_community' => $package->access_community,
                'support' => $package->support,
                'monthly_price' => $package->monthly_price,
                'yearly_price' => $package->yearly_price,
                'device_limit' => $package->device_limit,
                'order_id' => $orderId,
                'is_trail' => $package->is_trail,
                'start_date' => now(),
                'end_date' => Carbon::now()->addDays($duration),
                'status' => ACTIVE,
            ]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
        }

    }
}

function generateRandomString($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getTenantId()
{
    if (isAddonInstalled('DESKSAAS') > 0) {
        $host = request()->getHost();
        $domainDetails = Domain::where('domain', $host)->first();
        if ($domainDetails && $domainDetails != null) {
            return $domainDetails->tenant_id;
        }else{
            return User::where('role', USER_ROLE_SUPER_ADMIN)->first(['tenant_id'])?->tenant_id;
        }
        return 'zainiklab';
    } else {
        return 'zainiklab';
    }
}

function getUserIdByTenant()
{
    if (isAddonInstalled('DESKSAAS') > 0) {
        $host = request()->getHost();

        $domainDetails = Domain::where('domain', $host)->first();
        if ($domainDetails && $domainDetails != null) {
            return User::where('tenant_id', $domainDetails->tenant_id)->whereIn('role',[USER_ROLE_SUPER_ADMIN,USER_ROLE_ADMIN])->first(['id'])->id;
        }else{
            return User::where('role', USER_ROLE_SUPER_ADMIN)->first(['id'])?->id;
        }
        return null;
    } else {
        $user = User::where('tenant_id', getTenantId())->whereIn('role',[USER_ROLE_SUPER_ADMIN,USER_ROLE_ADMIN])->first(['id']);
//        $user = User::where('tenant_id', getTenantId())->whereIn('role',[USER_ROLE_ADMIN])->first(['id']);
        if (is_null($user)) {
            return null;
        } else {
            return $user->id;
        }
    }
}

function getUserIdByTenantId($tenant_id)
{
    return User::where(['tenant_id' => $tenant_id, 'role' => USER_ROLE_SUPER_ADMIN])->first(['id'])?->id;
}

function getIdByTenantId($tenant_id)
{
    return User::where(['tenant_id' => $tenant_id])->first(['id'])->id;
}

function getUserEmailByTenantId($tenant_id)
{
    return User::where(['tenant_id' => $tenant_id])->first(['email'])->email;
}


function timeFormat($date)
{
    return Carbon::parse($date)->format('Y-m-d');
}

function getDurationName($input = null)
{
    $output = [
        PACKAGE_DURATION_TYPE_MONTHLY => __('Monthly'),
        PACKAGE_DURATION_TYPE_YEARLY => __('Yearly')
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function getUserNameById($id)
{
    $user = User::where('id', $id)->first(['email']);
    return $user->email;
}

function getUserEmailById($id)
{
    $user = User::where('id', $id)->first(['email']);
    return $user->email;
}

function getUserInfoById($id, $properties)
{
    $user = User::where('id', $id)->first();
    return $user?->{$properties};
}

function checkAdminCanMakeAgentOrNot()
{
    $userPackageData = UserPackage::where(['status' => ACTIVE, 'user_id' => auth()->id()])->first();
    if ($userPackageData != null) {
        if ($userPackageData->number_of_agent == 0) {
            return false;
        }
        $userData = User::where(['role' => USER_ROLE_AGENT, 'tenant_id' => auth()->user()->tenant_id])->get();
        if (count($userData) > 0) {
            return count($userData) < $userPackageData->number_of_agent ? true : false;
        } else {
            return true;
        }
    } else {
        return false;
    }

}

function getDateDiffWithDay($previousDate)
{
    $date = Carbon::parse($previousDate);
    $now = Carbon::now();
    $diffInDays = $date->diffInDays($now);
    return $diffInDays;
}

function getCategoryNameById($id)
{
    try {
        return Category::where('id', $id)->first('name')->name;
    } catch (\Exception $e) {
        return '';
    }
}

function getSupportSchedule()
{
    // return BusinessHours::where('user_id',getUserIdByTenant())->get();
    return BusinessHours::where('user_id', getIdByTenantId(auth()->user()->tenant_id))->get();
}

function varityData($property_name)
{
    $data = Varity::where('created_by', getUserIdByTenant())->first();
    if ($data && $data != null) {
        return $data->{$property_name};
    }
    return null;
}

function getRoleByUserId($user_id)
{
    return User::where('id', $user_id)->first(['role'])->role;
}

function aiReplyList($ticket_id)
{
    return AIReplay::where('ticket_id', $ticket_id)->orderBy('id', 'DESC')->get();
}

function getAgentFakeNameConfig()
{
    try {
        $getTrackingPreFixed = Varity::where('created_by', getUserIdByTenant())->first()->agent_fake_name;
        return $getTrackingPreFixed;
    } catch (\Exception $e) {
        return 0;
    }

}

function getAgentFakeNameConfig2($tenant_id)
{
    try {
        $getTrackingPreFixed = Varity::where('created_by', getIdByTenantId($tenant_id))->first()->agent_fake_name;
        return $getTrackingPreFixed;
    } catch (\Exception $e) {
        return 0;
    }

}


function getUserNameUsingID($id)
{
    $user = User::where('id', $id)->first(['username']);
    return isset($user->username) ? $user->username : 'Customer';
}

function getUserFullNameUsingID($id)
{
    $user = User::find($id);
    return $user->name;
}

function getAgentNameUsingID($id)
{
    $user = User::where('id', $id)->first(['name']);
    return isset($user->username) ? $user->username : 'Agent';
}

function getRatingByTicketId($id)
{
    $ticketRating_data = TicketRating::where('ticket_id', $id)->first(['rating']);
    $ticketRating = isset($ticketRating_data->rating) ? $ticketRating_data->rating : 0;
    return $ticketRating;
}

function broadcastChatData($pushable_data)
{
    $broadcastService = new BroadcastService();
    return $broadcastService->broadCast(getOption('pusher_chanel_name'), "chat-data", $pushable_data);
}

//email notification helper start
function newTicketEmailNotify($ticket_id, $email = null)
{

    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);

            if ($ticketData && $ticketData != null) {
                if (Auth::check()) {
                    $userData = User::find(auth()->id());
                } else {
                    $userData = User::find($ticketData->created_by);
                }


                //send customer mail
                $templeate = 'ticket-create-notify-for-customer';
                Mail::to($userData->email)->send(new EmailNotify($ticketData, $userData, $templeate));

                //send admin mail
                $templeate = 'ticket-create-notify-for-admin';
                $adminData = User::where('tenant_id', $ticketData->tenant_id)
                    ->where(function ($query) {
                        if (getOption('ZAIDESKTENANCY_build_version') != null && getOption('ZAIDESKTENANCY_build_version') > 0) {
                            $query->where('role', USER_ROLE_ADMIN);
                        } else {
                            $query->where('role', USER_ROLE_SUPER_ADMIN);
                        }
                    })
                    ->first();
                Mail::to($adminData->email)->send(new EmailNotify($ticketData, $adminData, $templeate));

                //send agent mail if exist
                $agentAssignee = getTicketAssignedAgent($ticket_id);
                if (count($agentAssignee) > 0) {
                    $templeate = 'ticket-create-notify-for-agent';
                    foreach ($agentAssignee as $agent) {
                        Mail::to($agent->email)->send(new EmailNotify($ticketData, $agent, $templeate));
                    }
                }
            }
        }

    } catch (\Exception $e) {
        return false;
    }
}

function newEmailTicketEmailNotify($ticket_id, $data = null)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);

            if ($ticketData && $ticketData != null) {
                $userData = User::find(auth()->id());


                //send customer mail
                $templeate = 'email-ticket-create-notify-for-customer';
                Mail::to($userData->email)->send(new EmailNotify($ticketData, $userData, $templeate));

                //send admin mail
                $templeate = 'ticket-create-notify-for-admin';
                $adminData = User::where('tenant_id', $ticketData->tenant_id)
                    ->where(function ($query) {
                        if (getOption('ZAIDESKTENANCY_build_version') != null && getOption('ZAIDESKTENANCY_build_version') > 0) {
                            $query->where('role', USER_ROLE_ADMIN);
                        } else {
                            $query->where('role', USER_ROLE_SUPER_ADMIN);
                        }
                    })
                    ->first();
                Mail::to($adminData->email)->send(new EmailNotify($ticketData, $adminData, $templeate));

                //send agent mail if exist
                $agentAssignee = getTicketAssignedAgent($ticket_id);
                if (count($agentAssignee) > 0) {
                    $templeate = 'ticket-create-notify-for-admin';
                    foreach ($agentAssignee as $agent) {
                        Mail::to($agent->email)->send(new EmailNotify($ticketData, $agent, $templeate));
                    }
                }
            }
        }

    } catch (\Exception $e) {

    }
}

function emailVerifyEmailNotify($userData)
{
    try {
        if (getOption('email_verification_status', 0) == 1) {
            $templeate = 'email-verification';
            Mail::to($userData->email)->send(new UserEmailVerification($userData, $templeate));
        }
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

function ticketStatusChangeEmailNotify($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                $userData = User::where('id', $ticketData->created_by)->first();
                //send customer mail
                $templeate = 'ticket-status-change-for-customer';
                Mail::to($userData->email)->send(new EmailNotify($ticketData, $userData, $templeate));
            }
        }
        return true;
    } catch (\Exception $e) {
        return false;
    }

}

function ticketConversationEmailNotifyToAdminAndAgent($conv_id)
{
    try {
        $conv = Conversation::find($conv_id);
        $ticket_id = $conv->ticket_id;
        $ticketData = Ticket::find($ticket_id);
        $ticketData->conv = $conv;
        if (getOption('app_mail_status') && !is_null($ticketData)) {
            //send admin mail
            $templeate = 'ticket-conversation-for-admin';

            $adminData = User::where('tenant_id', $ticketData->tenant_id)
                ->where(function ($query) {
                    if (getOption('ZAIDESKTENANCY_build_version') != null && getOption('ZAIDESKTENANCY_build_version') > 0) {
                        $query->where('role', USER_ROLE_ADMIN);
                    } else {
                        $query->where('role', USER_ROLE_SUPER_ADMIN);
                    }
                })
                ->first();
            Log::info("admin");
            Log::info($adminData->email);

            Mail::to($adminData->email)->send(new EmailNotify($ticketData, $adminData, $templeate));


            //send agent mail if exist
            $agentAssignee = getTicketAssignedAgent($ticket_id);
            $agentList = [];
            foreach ($agentAssignee as $agent) {
                array_push($agentList,$agent->id);
            }
            $replyUsers = Conversation::where('ticket_id', $ticket_id)->select('created_by')->distinct()->pluck('created_by')->toArray();
//            Log::info(json_encode(array_merge($agentList,$replyUsers)));
            $replyUsersData = User::whereIn('id', array_merge($agentList,$replyUsers))
                ->where('role', USER_ROLE_AGENT)
                ->get();
            foreach ($replyUsersData as $agent) {
                Log::info($agent['email']);
                Mail::to($agent['email'])->send(new EmailNotify($ticketData, $agent, 'ticket-conversation-for-agent'));
            }
        }
    } catch (\Exception $e) {
        Log::info($e->getMessage());
    }
}

function ticketConversationEmailNotifyForCustomer($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                $userData = User::where('id', $ticketData->created_by)->first();
                //send customer mail
                $templeate = 'ticket-conversation-for-customer';
                Mail::to($userData->email)->send(new EmailNotify($ticketData, $userData, $templeate));
            }
        }
    } catch (\Exception $e) {

    }
}

function ticketReviewEmailNotify($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                //send agent mail if exist
                $agentAssignee = getTicketAssignedAgent($ticket_id);
                if (count($agentAssignee) > 0) {
                    $templeate = 'ticket-review-for-customer';
                    foreach ($agentAssignee as $agent) {
                        Mail::to($agent->email)->send(new EmailNotify($ticketData, $agent, $templeate));
                    }
                }
            }
        }
    } catch (\Exception $e) {

    }
}


//email notification helper end
//notification helper start
function newTicketNotify($ticket_id)
{
    try {
        $ticketData = Ticket::find($ticket_id);

        if ($ticketData && $ticketData != null) {
            $userData = User::find(auth()->id());

            //send customer mail
            $templeate = 'ticket-create-notify-for-customer';
            setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $userData), getEmailTemplate($templeate, 'body', '', $ticketData, $userData), auth()->id());

            //send admin mail
            $templeate = 'ticket-create-notify-for-admin';
            $adminData = User::where('tenant_id', $ticketData->tenant_id)
                ->where(function ($query) {
                    if (getOption('ZAIDESKTENANCY_build_version') != null && getOption('ZAIDESKTENANCY_build_version') > 0) {
                        $query->where('role', USER_ROLE_ADMIN);
                    } else {
                        $query->where('role', USER_ROLE_SUPER_ADMIN);
                    }
                })
                ->first();
            setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $adminData), getEmailTemplate($templeate, 'body', '', $ticketData, $adminData), $adminData->id);


            //send agent mail if exist
            $agentAssignee = getTicketAssignedAgent($ticket_id);
            if (count($agentAssignee) > 0) {
                $templeate = 'ticket-create-notify-for-agent';
                foreach ($agentAssignee as $agent) {
                    setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $agent), getEmailTemplate($templeate, 'body', '', $ticketData, $agent), $agent->id);
                }
            }
        }


    } catch (\Exception $e) {

    }
}

function ticketStatusChangeNotify($ticket_id)
{

    $ticketData = Ticket::find($ticket_id);
    if ($ticketData && $ticketData != null) {
        $userData = User::where('id', $ticketData->created_by)->first();
        //send customer mail
        $templeate = 'ticket-status-change-for-customer';
        //dd(getEmailTemplate($templeate, 'body', '', $ticketData, $userData));
        setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $userData), getEmailTemplate($templeate, 'body', '', $ticketData, $userData), $userData->id);
    }

}

function ticketConversationNotifyToAdminAndAgent($ticket_id)
{
    $ticketData = Ticket::find($ticket_id);
    if ($ticketData && $ticketData != null) {

        //send admin mail
        $templeate = 'ticket-conversation-for-customer';
        $adminData = User::where('tenant_id', $ticketData->tenant_id)
            ->where('role', USER_ROLE_ADMIN)
            ->first();
        setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $adminData), getEmailTemplate($templeate, 'body', '', $ticketData, $adminData), $adminData->id);


        //send agent mail if exist
        $agentAssignee = getTicketAssignedAgent($ticket_id);
        if (count($agentAssignee) > 0) {
            $templeate = 'ticket-conversation-for-agent';
            foreach ($agentAssignee as $agent) {
                setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $agent), getEmailTemplate($templeate, 'body', '', $ticketData, $agent), $agent->id);
            }
        }

    }

}

function ticketConversationNotifyForCustomer($ticket_id)
{
    try {
        $ticketData = Ticket::find($ticket_id);
        if ($ticketData && $ticketData != null) {
            $userData = User::where('id', $ticketData->created_by)->first();
            //send customer mail
            $templeate = 'ticket-conversation-for-customer';
            setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $userData), getEmailTemplate($templeate, 'body', '', $ticketData, $userData), $userData->id);
        }

    } catch (\Exception $e) {
        Log::info($e->getMessage());
    }
}

function ticketReviewNotify($ticket_id)
{
    try {
        $ticketData = Ticket::find($ticket_id);
        if ($ticketData && $ticketData != null) {
            //send agent mail if exist
            $agentAssignee = getTicketAssignedAgent($ticket_id);
            if (count($agentAssignee) > 0) {
                $templeate = 'ticket-review-for-customer';
                foreach ($agentAssignee as $agent) {
                    setCommonNotification(getEmailTemplate($templeate, 'subject', $link = '', $ticketData, $agent), getEmailTemplate($templeate, 'body', '', $ticketData, $agent), $agent->id);
                }
            }
        }

    } catch (\Exception $e) {

    }
}


//notification helper end

function getTicketAssignedAgentArray($ticketId)
{
    try {
        $ticketActiveAssignee = [];
        $ticketsData = Ticket::find($ticketId);
        if ($ticketsData) {
            $ticketActiveAssignee = $ticketsData->users()->having('pivot_is_active', '=', '1')->get()->toArray();
        }
        return $ticketActiveAssignee;
    } catch (\Exception $e) {
        return [];
    }
}

function getTicketAssignedAgent($ticketId)
{
    try {
        $ticketActiveAssignee = [];
        $ticketsData = Ticket::find($ticketId);
        if ($ticketsData) {
            $ticketActiveAssignee = $ticketsData->users()->having('pivot_is_active', '=', '1')->get();
        }
        return $ticketActiveAssignee;
    } catch (\Exception $e) {
        return [];
    }
}


function getAgentRatingById($userId)
{
    try {
//        $agent_data = [
//            'total_ticket' => 0,
//            'rating_count' => 0,
//            'rating_avg' => 0
//        ];
//
//        $ratings = Ticket::join('ticket_ratings', 'tickets.id', '=', 'ticket_ratings.ticket_id')
//            ->join('ticket_assignee', function ($join) use ($userId) {
//                $join->on('tickets.id', '=', 'ticket_assignee.ticket_id');
//                $join->on('ticket_assignee.assigned_to', '=', DB::raw($userId));
//            })->get();
//
//        $agent_data['total_ticket'] = $ratings->count();
//        $agent_data['rating_count'] = $ratings->sum('rating');
//        if ($ratings->count() != 0 || $ratings->sum('rating')) {
//            $agent_data['rating_avg'] = $ratings->sum('rating') / $ratings->count();
            $data =  TicketRating::query()
                ->where(['ticket_ratings.agent_id' => $userId])
                ->selectRaw('AVG(ticket_ratings.rating) as total_rating_point')
                ->first();
            $agent_data['rating_avg'] = is_null($data->total_rating_point)?0: round($data->total_rating_point);
//        }

        return $agent_data;

    } catch (\Exception $e) {
        return $agent_data = [
            'rating_avg' => 0,
        ];
    }

}

function getLastConversationByTicketId($ticketId)
{
    try {
        $lastConversation = Ticket::find($ticketId)->lastConversation;
        if ($lastConversation && $lastConversation != null) {
            return $lastConversation;
        } else {
            return "Last Conversation Not Found";
        }
    } catch (\Exception $e) {
        return "Last Conversation Not Found";
    }
}


function getLastConversationUserByTicketId($ticketId)
{
    try {
        $lastConversationUser = Ticket::find($ticketId);
        if (!is_null($lastConversationUser)) {
            return $lastConversationUser->lastConversationUser;
        } else {
            return "Last Conversation User Not Found";
        }
    } catch (\Exception $e) {
        return "Last Conversation User Not Found";
    }
}

function getMyAssignedTicketIds()
{
    $myassigned = User::find(auth()->id());
    return $myassigned->myAssignedTickets->pluck('id');
}


function darkMoodCheck()
{
    return 'dark';
}

if (!function_exists('get_domain_name')) {
    function get_domain_name($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

function getRoute($data)
{
    $view_route = '';
    if (Auth::user()->role == USER_ROLE_SUPER_ADMIN) {
        $view_route = route('admin.tickets.ticket_view', $data->id);
    }else if (Auth::user()->role == USER_ROLE_ADMIN) {
        $view_route = route('admin.tickets.ticket_view', $data->id);
    } else if (Auth::user()->role == USER_ROLE_AGENT) {
        $view_route = route('agent.ticket.view-ticket', $data->id);
    } else if (Auth::user()->role == USER_ROLE_CUSTOMER) {
        $view_route = route('customer.ticket.ticket-view', $data->id);
    }
    return $view_route;
}

if (!function_exists('getTicketIdHtml')) {
    function getTicketIdHtml($data)
    {

        if ($data->last_reply_id == null && $data->status == STATUS_PENDING) {
            return '<a href="' . getRoute($data) . '" class="btn btn-outline-primary position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->tracking_no . '
                             <span class="badge bg-pink-500 position-absolute rounded-pill agent-msg-new start-100 top-0 translate-middle">
                                New
                             </span>
                        </a>';
        } else if ($data->is_seen == 0) {
            if (\auth()->user()->role == USER_ROLE_CUSTOMER) {
                return '<a href="' . getRoute($data) . '" class="btn btn-outline-primary position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->tracking_no . '
                              <span class="badge bg-pink-500 position-absolute agent-msg-no-message rounded-pill top-0 translate-middle">
                                <i class="fa-regular  fa-envelope mb-0"></i>
                             </span>
                        </a>';
            } else {
                if ($data->last_reply_by != null && getRoleByUserId($data->last_reply_by) == USER_ROLE_CUSTOMER) {
                    return '<a href="' . getRoute($data) . '" class="btn btn-outline-primary position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->tracking_no . '
                              <span class="badge bg-pink-500 position-absolute agent-msg-no-message rounded-pill top-0 translate-middle">
                                <i class="fa-regular  fa-envelope mb-0"></i>
                             </span>
                        </a>';
                } else {
                    return '<a href="' . getRoute($data) . '" class="btn btn-outline-primary position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->tracking_no . '
                            <span class="badge bg-green-500 position-absolute agent-msg-no-message rounded-pill top-0 translate-middle">
                                <i class="fa-regular  fa-envelope mb-0"></i>
                             </span>
                        </a>';
                }
            }
        } else {
            return '<a href="' . getRoute($data) . '" class="btn btn-outline-primary position-relative ticket-tracking-id agent-ticket-id" >
                            ' . $data->tracking_no . '
                        </a>';
        }
    }
}
if (!function_exists('getTicketStatusHtml')) {
    function getTicketStatusHtml($data)
    {
        if ($data->status == STATUS_OPEND) {
            return '<button class="small-btn pending-btn">New</button>';
        } else if ($data->status == STATUS_INPROGRESS) {
            return '<button class="small-btn processing-btn">In Progress</button>';
        } else if ($data->status == STATUS_CANCELED) {
            return '<button class="small-btn canceled-btn">Canceled</button>';
        } else if ($data->status == STATUS_ON_HOLD) {
            return '<button class="small-btn success-btn">On Hold</button>';
        } else if ($data->status == STATUS_CLOSED) {
            return '<button class="small-btn close-btn">Closed</button>';
        } else if ($data->status == STATUS_RESOLVED) {
            return '<button class="small-btn resolved-btn">Resolved</button>';
        } else if ($data->status == STATUS_REOPEN) {
            return '<button class="small-btn success-btn">Re Open</button>';
        } else if ($data->status == STATUS_SUSPENDED) {
            return '<button class="small-btn suspend-btn">Suspended</button>';
        } else if ($data->status == 'delete') {
            return '<button class="small-btn pending-btn">Deleted</button>';
        } else {

        }
    }
}

if (!function_exists('getTicketPriorityHtml')) {
    function getTicketPriorityHtml($data)
    {
        if ($data->priority == LOW) {
            return '<span class="low"><li>Low</li></span>';
        } else if ($data->priority == MEDIUM) {
            return '<span class="generally"><li>Medium</li></span>';
        } else if ($data->priority == HIGH) {
            return '<span class="high"><li>High</li></span>';
        } else if ($data->priority == CRITICAL) {
            return '<span class="critical"><li>Critical</li></span>';
        }
    }
}

if (!function_exists('getTicketTitleHtml')) {
    function getTicketTitleHtml($data, $envato)
    {
//        $envato = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
//        $licence = $envato?->enable_purchase_code == 1 ? '<div><span><li>' . htmlspecialchars($data->envato_licence) . ' </span></div></li>' : '';
        $ticketDetails = '<a href="' . getRoute($data) . '" >
                                        ' . Str::limit(htmlspecialchars($data->ticket_title), 40, '...') . '
                           </a>
                            <div>
                              <span>
                                <li class="table_date">' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y H:i:s') . '</li>
                              </span>
                            </div>
                            ' . getTicketPriorityHtml($data) . '
                                <span>
                                <li>
                                    ' . $data->category?->name . '
                                </li>
                                </span>
                              <li>' . getTicketStatusHtml($data) . '</li>';
        return $ticketDetails;


//        return '<a href="' . route('agent.ticket.view-ticket', $data->id) . '">' . Str::limit(htmlspecialchars($data->ticket_title), 40, '...') . '</a>
//                        <div>
//                          <span>
//                            <li> ' . getCategoryNameById($data->category_id) . '</li>
//                          </span>' . $ticketPriority . '
//                        </div>' . $licence;
    }
}
if (!function_exists('getTicketAssignToHtml')) {
    function getTicketAssignToHtml($data)
    {
        $assigned_name = "";
        if ($data->assignTo != null && count($data->assignTo) > 0) {
            $assigned_name .= '<div class="d-flex gap-1 pb-3">';
            foreach ($data->assignTo as $u) {
                $assigned_name .= '<div class="header-profile-user-img" >
                    <img title = "' . getUserInfoById($u->assigned_to, 'name') . '(' . getUserInfoById($u->assigned_to, 'email') . ')' . '" class="rounded-circle avatar-xs fit-image" src = "' . getFileUrl(getUserInfoById($u->assigned_to, 'image')) . '" alt = "img" >
                </div >';
            }
            $assigned_name .= '</div>';
        } else {
            $assigned_name = 'not assigned';
        }

        return $assigned_name;
//        $vassign = '<select name="assign_to" data-id=' . $data->id . ' id="assign_to" modal-url=' . route('admin.tickets.ticketAssignToUsers', $data->id) . ' required class="form-control"';
//        if ($data->status == STATUS_SUSPENDED || $data->status == STATUS_CLOSED || $data->status == STATUS_CANCELED) {
//            $vassign .= 'disabled ><option value="assing">';
//        }
//        $vassign .= __('Assign');
//        $vassign .= '</option>';
//        $vassign .= '<option>';
//        if ($data->status == STATUS_PENDING || $data->status == STATUS_SUSPENDED || $data->status == STATUS_CLOSED || $data->status == STATUS_CANCELED) {
//            $vassign .= __('Select to Assign');
//        } else {
//            $vassign .= __('Assigned');
//        }
//
//        $vassign .= '</option>';
//        $vassign .= '<option value="self">';
//        $vassign .= __('Self');
//        $vassign .= '</option><option value="others">';
//        $vassign .= __('Others');
//        $vassign .= '</option></select>';
//        return $vassign;
    }
}


function ticketAssignNotifyToAdminAndAgent($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                //send agent mail if exist
                $agentAssignee = getTicketAssignedAgent($ticket_id);
                if (count($agentAssignee) > 0) {
                    $templeate = 'ticket-assign-for-agent-admin';
                    foreach ($agentAssignee as $agent) {
                        Mail::to($agent->email)->send(new EmailNotify($ticketData, $agent, $templeate));
                    }
                }
            }
        }

    } catch (\Exception $e) {

    }
}

if (!function_exists('isAddonInstalled')) {
    function isAddonInstalled($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
//        $codeBuildVersion = config($code . '.build_version', 0);
//        if (is_null($buildVersion) || $codeBuildVersion == 0) {
//            return 0;
//        }
        return (int)$buildVersion;
    }
}

function announcement($tenant_id)
{
    return Announcement::where('tenant_id', $tenant_id)->first(['customer_announcement'])?->customer_announcement;
}

function copyFolder($source, $destination)
{
    if (is_dir($source)) {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true); // Create the destination directory if it doesn't exist
        }

        $dir = opendir($source);

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $src = $source . '/' . $file;
                $dest = $destination . '/' . $file;
                if (is_dir($src)) {
                    // If it's a directory, recursively call the function
                    copyFolder($src, $dest);
                } else {
                    // If it's a file, use copy() to copy it
                    copy($src, $dest);
                }
            }
        }

        closedir($dir);
    } else {
        // If the source is a file, use copy() to copy it
        copy($source, $destination);
    }
}

function isCustomDomainSupport()
{
    $data = UserPackage::where(['user_id' => auth()->id(), 'status' => PACKAGE_STATUS_ACTIVE, 'custom_domain_setup' => CUSTOM_DOMAIN_SETUP_YES])->first();
    if (!is_null($data)) {
        return true;
    } else {
        return false;
    }
}

if (!function_exists('getAddonCodeCurrentVersion')) {
    function getAddonCodeCurrentVersion($appCode)
    {
        Artisan::call("config:clear");
        if ($appCode == 'DESKSAAS') {
            return config('addon.DESKSAAS.current_version', 0);
        }
    }
}

if (!function_exists('getAddonCodeBuildVersion')) {
    function getAddonCodeBuildVersion($appCode)
    {
        if(!env('DESKSAAS',1)){
            return 0;
        }
        Artisan::call("config:clear");
        if ($appCode == 'DESKSAAS') {
            return config('addon.DESKSAAS.build_version', 0);
        }
    }
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int)$buildVersion;
    }
}

if (!function_exists('getCustomerAddonBuildVersion')) {
    function getCustomerAddonBuildVersion($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        if (is_null($buildVersion)) {
            return 0;
        }
        return (int)$buildVersion;
    }
}

if (!function_exists('setCustomerAddonBuildVersion')) {
    function setCustomerAddonBuildVersion($code, $version)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerAddonCurrentVersion')) {
    function setCustomerAddonCurrentVersion($code)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_current_version']);
        if (config('addon.' . $code . '.current_version', 0) > 0) {
            $option->option_value = config('addon.' . $code . '.current_version', 0);
            $option->save();
        }
    }
}

if (!function_exists('setDomainInfo')) {
    function setDomainInfo()
    {
        $data = Domain::find(1);
        if (!is_null($data)) {
            $data->domain = request()->getHost();;
            $data->save();
        }
    }
}

if (!function_exists('saasConfig')) {
    function saasConfig()
    {
//        DB::beginTransaction();
//        try {

        // convert super admin to admin start
        $admin = User::where('role', USER_ROLE_SUPER_ADMIN)->first();
        $admin->role = USER_ROLE_ADMIN;
        $admin->save();
//                ->update(['role' => USER_ROLE_ADMIN]);
        //domain update
        $random = generateRandomString();
        $central_domains = Config::get('tenancy.central_domains')[0];
        $central_domains = implode('.', array_slice(explode('.', parse_url($central_domains, PHP_URL_HOST)), -2));
        $domain = $random . '.' . $central_domains;
        $adminDomain = Domain::first();
        $adminDomain->domain =  $domain;
        $adminDomain->save();
//            Domain::where('id', 1)->update(['domain' => $domain]);
        //set trail package
        $duration = (int)getOption('trail_duration', 1);
        $defaultPackage = Package::where(['is_trail' => ACTIVE])->first();
        setUserPackage($admin->id, $defaultPackage, $duration);
        // convert super admin to admin end

        // make new super admin start
        $user = new User();
        $user->uuid = '123456';
        $user->name = 'Super Admin Doe';
        $user->role = USER_ROLE_SUPER_ADMIN;
        $user->email = 'sadmin@gmail.com';
        $user->password = Hash::make(123456);
        $user->status = USER_STATUS_ACTIVE;
        $user->google2fa_secret = '';
        $user->save();
        //create tenant
        $random = generateRandomString();
        $tenant = Tenant::create(['id' => $random]);
        //set domain
        $central_domains = request()->getHost();
        $tenant->domains()->create(['domain' => $central_domains, 'user_domain' => $central_domains]);
        //update tenent id
        User::where('id', $user->id)->update(['tenant_id' => $random]);
        //created setting data
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
        // make new super admin end



//            DB::commit();
//        } catch (Exception $exception) {
////            DB::rollBack();
//            Log::info($exception->getMessage());
//        }


    }
}

function gatewaySettings()
{
    return '{"paypal":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],"stripe":[{"label":"Url","name":"url","is_show":0},{"label":"Secret Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],"razorpay":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],"instamojo":[{"label":"Url","name":"url","is_show":0},{"label":"Api Key","name":"key","is_show":1},{"label":"Auth Token","name":"secret","is_show":1}],"mollie":[{"label":"Url","name":"url","is_show":0},{"label":"Mollie Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":0}],"paystack":[{"label":"Url","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],"mercadopago":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],"sslcommerz":[{"label":"Url","name":"url","is_show":0},{"label":"Store ID","name":"key","is_show":1},{"label":"Store Password","name":"secret","is_show":1}],"flutterwave":[{"label":"Hash","name":"url","is_show":1},{"label":"Public Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],"coinbase":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":0}],"bank":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":0},{"label":"Client Secret","name":"secret","is_show":0}],"cash":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":0},{"label":"Client Secret","name":"secret","is_show":0}]}';
}

function getHostFromURL($url) {
    $parsedUrl = parse_url($url);
    if (isset($parsedUrl['host'])) {
        return $parsedUrl['host'];
    } else {
        return null; // URL doesn't have a host
    }
}

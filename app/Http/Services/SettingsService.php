<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminSettingRepository;
use App\Http\Services\Sms\TwilioService;
use App\Models\Country;
use App\Models\Setting;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Arr;

class SettingsService extends CommonService
{
    use ResponseTrait;

    public $model = Setting::class;
    public $repository = AdminSettingRepository::class;

    public function __construct()
    {
        parent::__construct($this->model, $this->repository);
    }

    public function cookieSettingUpdated($request)
    {

        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {


            $option = Setting::firstOrCreate(['option_key' => $key]);

            if ($request->hasFile('cookie_image') && $key == 'cookie_image') {
                $upload = settingImageStoreUpdate($value, $request->cookie_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function commonSettingUpdate($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {


            $option = Setting::firstOrCreate(['option_key' => $key]);

            if ($request->hasFile('cookie_image') && $key == 'cookie_image') {
                $upload = settingImageStoreUpdate($value, $request->cookie_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }
    public function smsConfigurationStore($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }
    public function smsTest($request)
    {
        try {
            $phoneNumber = trim($request->get('to'));
            $smsText = trim($request->get('message'));

            $sendSmsStatus = TwilioService::sendSms($phoneNumber, '', $smsText);

            if ($sendSmsStatus == true) {

                return $this->success([], __("Test sms has been sent to your phone number"));
            } else {
                return $this->error([], __("Something went wrong,please check your phone number"));
            }
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function apiSettingUpdate($request)
    {
        try {
            for ($i = 0; $i < count($request->coin_id); $i++) {
                if ($request->api_service[$i] == 'CoinPaymentsApiService') {
                    ApiSetting::updateOrCreate(['coin_id' => $request->coin_id[$i]], ['coin_id' => $request->coin_id[$i], 'api_service' => $request->api_service[$i], 'withdrawal_fee_method' => $request->withdrawal_fee_method[$i], 'withdrawal_fee_percent' => $request->withdrawal_fee_percent[$i], 'withdrawal_fee_fixed' => $request->withdrawal_fee_fixed[$i], 'user' => null, 'password' => null, 'host' => null, 'port' => null, 'access_token' => null, 'express_url' => null, 'wallet_id' => null, 'wallet_password' => null, 'chain' => null, 'bitgo_mode' => null , 'public_key' => $request->public_key[$i], 'private_key' => $request->private_key[$i]]);
                } elseif ($request->api_service[$i] == 'BitGoPaymentApiService') {
                    ApiSetting::updateOrCreate(['coin_id' => $request->coin_id[$i]], ['coin_id' => $request->coin_id[$i], 'api_service' => $request->api_service[$i], 'withdrawal_fee_method' => $request->withdrawal_fee_method[$i], 'withdrawal_fee_percent' => $request->withdrawal_fee_percent[$i], 'withdrawal_fee_fixed' => $request->withdrawal_fee_fixed[$i], 'user' => null, 'password' => null, 'host' => null, 'port' => null, 'public_key' => null, 'private_key' =>null, 'access_token' => $request->access_token[$i], 'express_url' => $request->express_url[$i], 'wallet_id' => $request->wallet_id[$i], 'wallet_password' => $request->wallet_password[$i], 'chain' => $request->chain[$i], 'bitgo_mode' => $request->bitgo_mode[$i]]);
                } else {
                    ApiSetting::updateOrCreate(['coin_id' => $request->coin_id[$i]], ['coin_id' => $request->coin_id[$i], 'api_service' => $request->api_service[$i], 'withdrawal_fee_method' => $request->withdrawal_fee_method[$i], 'withdrawal_fee_percent' => $request->withdrawal_fee_percent[$i], 'withdrawal_fee_fixed' => $request->withdrawal_fee_fixed[$i], 'user' => $request->user[$i], 'password' => $request->password[$i], 'host' => $request->host[$i], 'port' => $request->port[$i], 'public_key' => null, 'private_key' => null, 'access_token' => null, 'express_url' => null, 'wallet_id' => null, 'wallet_password' => null, 'chain' => null, 'bitgo_mode' => null]);
                }
            }
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }


    public function kycGatewayUpdate($request)
    {
        try {
            $kycGatewayDataObj = KYCGateway::find($request->gateway_id);

            if ($kycGatewayDataObj && $kycGatewayDataObj != null) {
                $kycGatewayDataObj->name = $request->name;
                $kycGatewayDataObj->status = $request->status;
                $kycGatewayDataObj->save();
                return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
            }
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        } catch (Exception $e) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }





    public function getCountryList()
    {
        $currencies = Country::orderBy('short_name', 'ASC')->select('id', 'short_name', 'country_name', 'status');
        return datatables($currencies)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return '<div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" data-id="' . $data->id . '" id="countryCheckbox" ' . ($data->status == 1 ? "checked" : "") . '>
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function tradeSetting($data)
    {
        try {

            foreach ($data as $key => $val) {
                $labelName = str_replace('_', ' ', $key);
                $value = [
                    'value' => $val,
                    'label' => $labelName,
                    'type' => 'text'
                ];

                $this->object->updateOrCreateTrade($key, $value);
            }

            return ['success' => true, 'data' => $data, 'message' => __('Updated Successfully.')];
        } catch (\Exception $e) {

            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function customerAnnouncement(){

    }
}

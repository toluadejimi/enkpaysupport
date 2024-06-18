<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\EnvatoService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class EnvatoController extends Controller
{
    use ResponseTrait;

    public $envatoService;

    public function __construct()
    {
        $this->envatoService = new EnvatoService;
    }

    public function config()
    {
        $data['pageTitle'] = __('Envato Configuration');
        $data['navEnvatoParentActiveClass'] = 'mm-active';
        $data['navEnvatoSettingActiveClass'] = 'mm-active';
        $data['envatoConfigData'] = $this->envatoService->getEnvatoConfigData();
        return view('admin.envato.config', $data);
    }

    public function configStore(Request $request)
    {
        return $this->envatoService->sotre($request);
    }

    public function configModal(Request $request)
    {
        $data['envatoConfigData'] = $this->envatoService->getEnvatoConfigData();
        return view('admin.envato.configuration.form.api_key_configuration', $data);
    }

    public function configHelp()
    {
        return view('admin.envato.configuration.help.api_key');
    }

    public function configModalDataStore(Request $request)
    {
        return $this->envatoService->sotreConfigData($request);
    }

    public function licenseVerification()
    {
        $data['pageTitle'] = __('Envato License Verification');
        $data['navEnvatoParentActiveClass'] = 'mm-active';
        $data['navLicenseVerificationActiveClass'] = 'mm-active';
        return view('admin.envato.verification', $data);
    }

    public function licenseVerificationAction(Request $request)
    {
        return $this->envatoService->licenseVerification($request);
    }
}

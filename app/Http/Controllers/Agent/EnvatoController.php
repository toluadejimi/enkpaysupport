<?php

namespace App\Http\Controllers\Agent;

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

    public function licenseVerification()
    {
        $data['pageTitle'] = __('Envato License Verification');
        $data['navEnvatoParentActiveClass'] = 'mm-active';
        $data['navLicenseVerificationActiveClass'] = 'mm-active';
        return view('agent.envato.verification', $data);
    }

    public function licenseVerificationAction(Request $request)
    {
        return $this->envatoService->licenseVerification($request);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function termsConditions()
    {
        $data['pageTitle'] = 'Terms & Conditions';
        $data['subNavTermsConditionsActiveClass'] = 'active';
        $data['policy'] = Policy::whereType(1)->first();
        return view('admin.policy.terms-conditions', $data);
    }

    public function termsConditionsStore(Request $request)
    {
        $policy = Policy::whereType(1)->first();
        if (!$policy) {
            $policy = new Policy();
        }
        $policy->type = 1;
        $policy->description = $request->description;
        $policy->save();
        return redirect()->back()->with('success', __('Updated Successfully'));

    }

    public function privacyPolicy()
    {
        $data['pageTitle'] = 'Privacy Policy';
        $data['subNavPrivacyPolicyActiveClass'] = 'active';
        $data['policy'] = Policy::whereType(2)->first();
        return view('admin.policy.privacy-policy', $data);
    }

    public function privacyPolicyStore(Request $request)
    {
        $policy = Policy::whereType(2)->first();
        if (!$policy) {
            $policy = new Policy();
        }
        $policy->type = 2;
        $policy->description = $request->description;
        $policy->save();
        return redirect()->back()->with('success', __('Updated Successfully'));

    }

    public function cookiePolicy()
    {
        $data['title'] = 'Cookie Policy';
        $data['subNavCookiePolicyActiveClass'] = 'active';
        $data['policy'] = Policy::whereType(3)->first();
        return view('admin.policy.cookie-policy', $data);
    }

    public function cookiePolicyStore(Request $request)
    {
        $policy = Policy::whereType(3)->first();
        if (!$policy) {
            $policy = new Policy();
        }
        $policy->type = 3;
        $policy->description = $request->description;
        $policy->save();
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

}

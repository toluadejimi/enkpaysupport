<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Tools\Repositories\Crud;

class ContactUsController extends Controller
{
    protected $model;

    public function __construct(ContactUs $contactUs)
    {
        $this->model = new Crud($contactUs);
    }

    public function contactUsIndex()
    {
        $data['pageTitle'] = 'Contact Us List';
        $data['navContactUsParentActiveClass'] = 'mm-active';
        $data['navContactUsParentShowClass'] = 'mm-show';
        $data['subNavContactUsIndexActiveClass'] = 'mm-active';
        $data['contactUss'] = $this->model->getOrderById('DESC', 25);
        return view('admin.contact.index', $data);
    }

    public function contactUsDelete($id)
    {
        $contactUs = $this->model->getRecordById($id);
        $contactUs->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function contactUsCMS()
    {
        $data['pageTitle'] = 'Contact Us CMS';
        $data['navApplicationSettingParentActiveClass'] = 'mm-active';
        $data['subNavContactUsSettingsActiveClass'] = 'mm-active';
        $data['contactUsSettingsActiveClass'] = 'active';

        return view('admin.application_settings.contact_us.cms', $data);
    }
}

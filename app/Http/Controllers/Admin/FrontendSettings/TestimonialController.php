<?php

namespace App\Http\Controllers\Admin\FrontendSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Frontend\TestimonialRequest;
use App\Http\Services\FrontendService\TestimonialService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class TestimonialController extends Controller
{
    use ResponseTrait;

    public $testimonialService;

    public function __construct()
    {
        $this->testimonialService = new TestimonialService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Testimonial');
        $data['subNavFrontendSettingActiveClass'] = 'mm-active';
        $data['subTestimonialListActiveClass'] = 'active';
        if ($request->ajax()) {
            return $this->testimonialService->list();
        }
        return view('admin.setting.frontend_settings.testimonials.index', $data);
    }

    public function store(TestimonialRequest $request)
    {
        return $this->testimonialService->store($request);
    }

    public function info($id)
    {
        $data['testimonial'] = $this->testimonialService->getById($id);
        return view('admin.setting.frontend_settings.testimonials.edit-form', $data);
    }

    public function update(TestimonialRequest $request, $id)
    {
        return $this->testimonialService->update($id, $request);
    }

    public function delete(Request $request)
    {
        return $this->testimonialService->delete($request);
    }
}

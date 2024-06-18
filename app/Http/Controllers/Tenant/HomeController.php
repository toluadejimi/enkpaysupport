<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Http\Services\BlogService;
use App\Http\Services\ContactUsService;
use App\Http\Services\FrontendService;
use App\Http\Services\FrontendService\CounterAreaService;
use App\Http\Services\FrontendService\FaqCategoryService;
use App\Http\Services\FrontendService\FaqService;
use App\Http\Services\FrontendService\FeatureService;
use App\Http\Services\FrontendService\HowItWorkService;
use App\Http\Services\FrontendService\KnowledgeCategoryService;
use App\Http\Services\FrontendService\KnowledgeService;
use App\Http\Services\FrontendService\PageService;
use App\Http\Services\FrontendService\ServiceService;
use App\Http\Services\FrontendService\TestimonialService;
use App\Models\GeneralSettings;
use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $data['menuHomeActive'] = 'current-menu-items';
        $faqs = new FaqService();
        $faqCategory = new FaqCategoryService();
        $service = new ServiceService();
        $blogService = new BlogService();
        $howItWork = new HowItWorkService();
        $testimonial = new TestimonialService();
        $frontendSection = new FrontendService();
//        $getCounterAreaShow = new CounterAreaService();
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $featureObj = new FeatureService();
        $frontendSection = $frontendSection->getHomeFrontendSection(getUserIdByTenant());
//        $data['getCounterAreaShow'] = $getCounterAreaShow->getCounterAreaShow();
        $data['faqs'] = $faqs->getActiveFaq(5);
        $data['faqsUser'] = $faqs->getHomeActiveFaq();
//        $data['howItWork'] = $howItWork->getHowToWorkAll();
//        $data['service'] = $service->getActiveService();
//        $data['blogs'] = $blogService->getAllActive(3);
        $data['testimonial'] = $testimonial->getActiveTestimonial();
        $data['feature'] = $featureObj->getActiveFeature();
        $data['featureObj'] = $featureObj->getTenantShow();
        $data['testimonial'] = $testimonial->getTenantShow();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
//        $frontendSection = $frontendSection->getHomeFrontendSection();
        $data['faqCategory'] = $faqCategory->getHomeActiveFaqCategory();
//        $data['getCounterAreaShow'] = $getCounterAreaShow->getCounterAreaShow();
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();

        $data['section'] = [
            'hero_banner' => $frontendSection->where('slug', 'hero_banner')->first(),
            'service_area' => $frontendSection->where('slug', 'service_area')->first(),
            'about_us_area' => $frontendSection->where('slug', 'about_us_area')->first(),
            'how_it_work' => $frontendSection->where('slug', 'how_it_work')->first(),
            'growing_company' => $frontendSection->where('slug', 'growing_company')->first(),
            'features_area' => $frontendSection->where('slug', 'features_area')->where('created_by', getUserIdByTenant())->first(),
            'price_area' => $frontendSection->where('slug', 'price_area')->first(),
            'products_area' => $frontendSection->where('slug', 'products_area')->first(),
            'testimonial_area' => $frontendSection->where('slug', 'testimonial_area')->where('created_by', getUserIdByTenant())->first(),
            'faq_area' => $frontendSection->where('slug', 'faq_area')->where('created_by', getUserIdByTenant())->first(),
            'faq_mood_area' => $frontendSection->where('slug', 'faq_mood_area')->first(),
            'blog_area' => $frontendSection->where('slug', 'blog_area')->first(),
            'knowledge_area' => $frontendSection->where('slug', 'knowledge_area')->first(),
            'need_support_area' => $frontendSection->where('slug', 'need_support_area')->first(),
            'looking_support_area' => $frontendSection->where('slug', 'looking_support_area')->first(),
        ];

        $faqs = new FaqService();
        $data['faqCategory'] = $faqs->faqCategory();
        $data['faqs'] = $faqs->faq();

        return view('tenant.index', $data);
    }

    public function knowledge()
    {
        $frontendSection = new FrontendService();
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $frontendSection = $frontendSection->getHomeFrontendSection();
        $data['section'] = ['knowledge_area' => $frontendSection->where('slug', 'knowledge_area')->first()];
        $data['lookingSupport'] = ['looking_support_area' => $frontendSection->where('slug', 'looking_support_area')->first()];
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
        return view('tenant.knowledge.knowledge', $data);
    }

    public function knowledgeCategory($id)
    {
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $data['categoryDetails'] = KnowledgeCategory::findOrFail($id);
        $data['knowledgeByCategory'] = $data['categoryDetails']->knowledge;
        $data['knowledgeTitle'] = KnowledgeCategory::where('id', $id)->get();
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
        return view('tenant.knowledge.knowledge-category', $data);
    }

    public function knowledgeCategorySingle($id)
    {
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
        $data['knowledgeDetails'] = Knowledge::leftJoin('knowledge_categories', 'knowledge.knowledge_category_id', '=', 'knowledge_categories.id')
            ->where('knowledge.id', $id)
            ->first([
                'knowledge.*',
                'knowledge_categories.title as category_title',
            ]);
        Knowledge::where('id', $id)->increment('user_count', 1);
        $data['searchKnowledgeCheck'] = 0;
        return view('tenant.knowledge.knowledge-category-single', $data);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        Session::put('2fa_status', false);

        $field = 'email';

        $request->merge([$field => $request->input('email')]);

        $credentials = $request->only($field, 'password');

        $remember = request('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return redirect("login")->withInput()->with('error', __('Email or password is incorrect'));
        }

        $user = User::where('email', $request->email)->first();


        if ($user->status == STATUS_SUSPENDED) {
            Auth::logout();
            return redirect("login")->withInput()->with('error', __('Your account is suspended Please contact our support center'));
        } elseif ($user->deleted_at != null) {
            Auth::logout();
            return redirect("login")->withInput()->with('error', __('Your account has been deleted'));
        }

        if (isset($user) && ($user->status == USER_STATUS_INACTIVE)) {
            Auth::logout();
            return redirect("login")->withInput()->with('error', __('Your account is inactive. Please contact with admin'));
        } else {
            addUserActivityLog('Sign In', $user->id);
            return redirect('login');
        }
    }


    public function contactUs()
    {
        $data['menuContactUsActive'] = 'current-menu-items';
        $data['contactUs'] = GeneralSettings::where('tenant_id', 'zainiklab')->orderBy('created_at', 'desc')->first();
        return view('tenant.contact-us', $data);
    }

    public function contactSMStore(ContactMessageRequest $request)
    {
        $contactUsService = new ContactUsService();
        $message = $contactUsService->store($request);
        return redirect()->back()->with('message', $message);
    }


    public function faqs()
    {
        $faqs = new FaqService();
        $data['section'] = $faqs->getFaqTitle();
        $data['faqCategory'] = $faqs->faqCategory();
        $data['faqs'] = $faqs->faq();
        return view('tenant.faqs', $data);
    }

    public function termsOfUse()
    {
        $pageService = new PageService();
        $data['page'] = $pageService->getPageByType(PAGE_TERMS_OF_SERVICE);
        return view('tenant.policy.terms-of-use', $data);
    }

}

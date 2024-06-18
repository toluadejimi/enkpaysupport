<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Http\Services\BlogService;
use App\Http\Services\CmsSettingService;
use App\Http\Services\ContactUsService;
use App\Http\Services\FrontendService;
use App\Http\Services\FrontendService\CounterAreaService;
use App\Http\Services\FrontendService\FaqCategoryService;
use App\Http\Services\FrontendService\FaqService;
use App\Http\Services\FrontendService\FeatureService;
use App\Http\Services\FrontendService\HowItWorkService;
use App\Http\Services\FrontendService\KnowledgeCategoryService;
use App\Http\Services\FrontendService\KnowledgeService;
use App\Http\Services\FrontendService\OurMissionService;
use App\Http\Services\FrontendService\PageService;
use App\Http\Services\FrontendService\ServiceService;
use App\Http\Services\FrontendService\TeamService;
use App\Http\Services\FrontendService\TestimonialService;
use App\Http\Services\Saas\SubscriptionService;
use App\Models\CustomPage;
use App\Models\GeneralSettings;
use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $subscriptionService;

    public function __construct()
    {
        if(isAddonInstalled('DESKSAAS') > 0){
            $this->subscriptionService = new SubscriptionService();
        }
    }

    public function customPage($slug){
        $data['pageData'] = CustomPage::where(['slug'=> $slug, 'status'=> 1])->first();
        return view('frontend.blank', $data);
    }

    public function index()
    {
        if(isAddonInstalled('DESKSAAS') > 0){
        $data['menuHomeActive'] = 'current-menu-items';
        $faqsService = new FaqService();
        $faqCategoryService = new FaqCategoryService();
        $featureObj = new FeatureService();
        $service = new ServiceService();
        $blogService = new BlogService();
        $howItWork = new HowItWorkService();
        $testimonial = new TestimonialService();
        $frontendSection = new FrontendService();
        $getCounterAreaShow = new CounterAreaService();
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $frontendSection = $frontendSection->getHomeFrontendSection();
        $data['getCounterAreaShow'] = $getCounterAreaShow->getCounterAreaShow();

        $data['faqs'] = $faqsService->getActiveFaq();
        $data['faqsUser'] = $faqsService->getUserActiveFaq();
        $data['faqCategories'] = $faqCategoryService->getCategorySuperAdmin();
        $data['howItWork'] = $howItWork->getHowToWorkAll();
        $data['service'] = $service->getActiveService();
        $data['feature'] = $featureObj->getActiveFeature();
        $data['featureObj'] = $featureObj->getHomeFeature();
        $data['blogs'] = $blogService->getAllActive(3);
        $data['testimonial'] = $testimonial->getHomeFrontendSection();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();

        $data['section'] = [
            'hero_banner' => $frontendSection->where('slug', 'hero_banner')->first(),
            'logical_reason' => $frontendSection->where('slug', 'logical_reason')->first(),
            'about_us_area' => $frontendSection->where('slug', 'about_us_area')->first(),
            'how_it_work' => $frontendSection->where('slug', 'how_it_work')->first(),
            'growing_company' => $frontendSection->where('slug', 'growing_company')->first(),
            'features_area' => $frontendSection->where('slug', 'features_area')->first(),
            'price_area' => $frontendSection->where('slug', 'price_area')->first(),
            'products_area' => $frontendSection->where('slug', 'products_area')->first(),
            'testimonial_area' => $frontendSection->where('slug', 'testimonial_area')->first(),
            'faq_area' => $frontendSection->where('slug', 'faq_area')->first(),
            'faq_mood_area' => $frontendSection->where('slug', 'faq_mood_area')->first(),
            'blog_area' => $frontendSection->where('slug', 'blog_area')->first(),
            'knowledge_area' => $frontendSection->where('slug', 'knowledge_area')->where('created_by', 2)->first(),
        ];

        return view('frontend.index', $data);

        }else{
            $data['menuHomeActive'] = 'current-menu-items';
            $faqs = new FaqService();
            $faqCategory = new FaqCategoryService();
            $service = new ServiceService();
            $blogService = new BlogService();
            $howItWork = new HowItWorkService();
            $testimonial = new TestimonialService();
            $frontendSection = new FrontendService();
            $getCounterAreaShow = new CounterAreaService();
            $knowledgeCategory = new KnowledgeCategoryService();
            $knowledge = new KnowledgeService();
            $featureObj = new FeatureService();
            $frontendSection = $frontendSection->getHomeFrontendSection(getUserIdByTenant());
            $data['getCounterAreaShow'] = $getCounterAreaShow->getCounterAreaShow();
            $data['faqs'] = $faqs->getActiveFaq(5);
            $data['faqsUser'] = $faqs->getHomeActiveFaq();
            $data['howItWork'] = $howItWork->getHowToWorkAll();
            $data['service'] = $service->getActiveService();
            $data['blogs'] = $blogService->getAllActive(3);
            $data['testimonial'] = $testimonial->getActiveTestimonial();
            $data['feature'] = $featureObj->getActiveFeature();
            $data['featureObj'] = $featureObj->getTenantShow();
            $data['testimonial'] = $testimonial->getTenantShow();
            $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
            $data['faqCategory'] = $faqCategory->getHomeActiveFaqCategory();
            $data['getCounterAreaShow'] = $getCounterAreaShow->getCounterAreaShow();
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

    }

    public function knowledge()
    {
        $frontendSection = new FrontendService();
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $frontendSection = $frontendSection->getHomeFrontendSection();
        $data['section'] = ['knowledge_area' => $frontendSection->where('slug', 'knowledge_area')->first(),
        ];
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();
        return view('tenant.knowledge.knowledge', $data);
    }



    public function knowledgeCategory($id)
    {
        $knowledgeCategory = new KnowledgeCategoryService();
        $knowledge = new KnowledgeService();
        $data['categoryDetails'] = KnowledgeCategory::find($id);
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
        $data['knowledgeDetails'] = Knowledge::where('id', $id)->first();
        return view('tenant.knowledge.knowledge-category-single', $data);
    }


    public function aboutUs()
    {
        $data['menuAboutUsActive'] = 'current-menu-items';
        $team = new TeamService();
        $features = new FeatureService();
        $ourMission = new OurMissionService();
        $getHomeFeature = new FeatureService();
        $getHomeAboutUs = new PageService();
        $testimonial = new TestimonialService();
        $getCounterArea = new CounterAreaService();
        $data['team'] = $team->getActiveTeam();
        $data['logical_reason'] = $features->getActiveFeature();
        $data['ourMission'] = $ourMission->getActiveOurMission();
        $data['getHomeFeature'] = $getHomeFeature->getHomeFeature();
        $data['testimonial'] = $testimonial->getActiveTestimonial();
        $data['getCounterArea'] = $getCounterArea->getCounterAreaShow();
        $data['getHomeAboutUs'] = $getHomeAboutUs->getPageByType(PAGE_ABOUT_US);
        $data['aboutUs'] = Setting::where('option_key', 'about_us')->value('option_value');
        return view('frontend.about-us', $data);
    }

    /**
     * contact us sms area start
     */

    public function contactUs()
    {
        $data['menuContactUsActive'] = 'current-menu-items';
        $data['contactUs'] = GeneralSettings::where('created_by', 1)->orderBy('created_at', 'desc')->first();
        return view('frontend.contact-us', $data);
    }

    public function contactSMStore(ContactMessageRequest $request)
    {
        $contactUsService = new ContactUsService();
        $message = $contactUsService->store($request);
        return redirect()->back()->with('message', $message);
    }

    public function showContactSMS(Request $request)
    {
        $data['pageTitle'] = __('Contact Messages');
        $data['navContactMessageListActiveClass'] = 'mm-active';
        if ($request->ajax()) {
            $contactUsService = new ContactUsService();
            return $contactUsService->contactSMSList();
        }
        return view('admin.setting.contact-message', $data);
    }

    public function contactSMSDelete(Request $request)
    {
        $contactUsService = new ContactUsService();
        return $contactUsService->deleteContactSMS($request);
    }

    /**
     * contact us sms area end
     */

    public function faqs()
    {
        $faqsService = new FaqService();
        $frontendSection = new FrontendService();
        $faqCategoryService = new FaqCategoryService();
        $data['faqs'] = $faqsService->getActiveFaq();
        $data['faqsUser'] = $faqsService->getUserActiveFaq();
        $data['faqCategories'] = $faqCategoryService->getCategorySuperAdmin();
        $data['section'] = $frontendSection->getFaqActive();
        return view('frontend.faqs', $data);
    }

    public function termsOfUse()
    {
        $pageService = new PageService();
        $data['page'] = $pageService->getPageByType(PAGE_TERMS_OF_SERVICE);
        return view('frontend.policy.terms-of-use', $data);
    }

    public function privacyPolicy()
    {
        $pageService = new PageService();
        $data['page'] = $pageService->getPageByType(PAGE_PRIVACY_POLICY);
        return view('frontend.policy.privacy-policy', $data);
    }

    public function refundPolicy()
    {
        $pageService = new PageService();
        $data['page'] = $pageService->getPageByType(PAGE_REFUND_POLICY);
        return view('frontend.policy.refund-policy', $data);
    }

    public function cookiePolicy()
    {
        $pageService = new PageService();
        $data['page'] = $pageService->getPageByType(PAGE_COOKIE_POLICY);
        return view('frontend.policy.cookie-policy', $data);
    }




    public function socialLink()
    {
        $socialLink = new CmsSettingService();
        $data['socialLink'] = $socialLink->cmsSocialLink(1);
    }

    public function pricing()
    {
        $frontendSection = new FrontendService();
        $frontendSection = $frontendSection->getHomeFrontendSection();
        $data['section'] = ['price_area' => $frontendSection->where('slug', 'price_area')->first(),];
        $data['plans'] = $this->subscriptionService->getAll();
        $data['userPlan'] = $this->subscriptionService->getCurrentPlan();
        $data['currentPlansDuration'] = $this->subscriptionService->getCurrentPlanDuration();
        return view('saas.frontend.pricing.pricing', $data);
    }

}

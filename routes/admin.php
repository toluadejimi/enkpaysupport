<?php

use App\Http\Controllers\AddonUpdateController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\CmsSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DatabaseBackupSettingController;
use App\Http\Controllers\Admin\DynamicFieldController;
use App\Http\Controllers\Admin\EnvatoController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\FrontendSettings\CounterAreaController;
use App\Http\Controllers\Admin\FrontendSettings\FaqCategoryController;
use App\Http\Controllers\Admin\FrontendSettings\FaqController;
use App\Http\Controllers\Admin\FrontendSettings\FeatureController;
use App\Http\Controllers\Admin\FrontendSettings\HowItWorkController;
use App\Http\Controllers\Admin\FrontendSettings\KnowledgeCategoryController;
use App\Http\Controllers\Admin\FrontendSettings\KnowledgeController;
use App\Http\Controllers\Admin\FrontendSettings\NewsArticleController;
use App\Http\Controllers\Admin\FrontendSettings\OurMissionController;
use App\Http\Controllers\Admin\FrontendSettings\PageController;
use App\Http\Controllers\Admin\FrontendSettings\ServiceController;
use App\Http\Controllers\Admin\FrontendSettings\TeamController;
use App\Http\Controllers\Admin\FrontendSettings\TestimonialController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MetaManagementController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SelfTicketController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TicketCategoryController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketTagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\ChatConfigurationController;
use App\Http\Controllers\CollisionDetector;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstantMessageController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\Saas\Admin\CurrencyController;
use App\Http\Controllers\Saas\Admin\GatewayController;
use App\Http\Controllers\Saas\Admin\MySubscriptionController;
use App\Http\Controllers\Saas\Admin\PackageController;
use App\Http\Controllers\Saas\Admin\SubscriptionController;
use App\Http\Controllers\Saas\DomainController;
use App\Http\Controllers\TicketRatingController;
use App\Http\Controllers\VersionUpdateController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard-chart', [DashboardController::class, 'dashboardChartQuery'])->name('dashboardChartQuery');


Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
    Route::group(['middleware' => []], function () {

        Route::post('chat-configur', [ChatConfigurationController::class, 'chatConfigur'])->name('chat.configur');
        Route::get('domain-setup', [DomainController::class, 'domainSetup'])->name('domain-setup');
        Route::post('domain-store', [DomainController::class, 'domainStore'])->name('domain-store');

        Route::get('application-settings', [GeneralSettingController::class, 'applicationSettingsIndex'])->name('application-settings');
        Route::post('application-settings-update', [GeneralSettingController::class, 'applicationSettingsStore'])->name('application-settings.update')->middleware('isDemo');;
        Route::get('configuration-settings', [SettingController::class, 'configurationSetting'])->name('configuration-settings');
        Route::get('configuration-settings/configure', [SettingController::class, 'configurationSettingConfigure'])->name('configuration-settings.configure')->middleware('isDemo');;
        Route::get('configuration-settings/help', [SettingController::class, 'configurationSettingHelp'])->name('configuration-settings.help');
        Route::post('configuration-settings-update', [SettingController::class, 'configurationSettingUpdate'])->name('configuration-settings.update')->middleware('isDemo');;
        Route::post('application-env-update', [SettingController::class, 'saveSetting'])->name('settings_env.update')->middleware('isDemo');;

        Route::post('application-settings-store', [CmsSettingController::class, 'index'])->name('application-settings.store');

        Route::get('color-settings', [GeneralSettingController::class, 'logoSettingsIndex'])->name('color-settings');
        Route::post('color-settings-update', [GeneralSettingController::class, 'logoSettingsStore'])->name('color-settings.update');
        Route::group(['prefix' => 'currency', 'as' => 'currencies.'], function () {
            Route::get('', [CurrencyController::class, 'index'])->name('index');
            Route::post('currency', [CurrencyController::class, 'store'])->name('store');
            Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('edit');
            Route::patch('update/{id}', [CurrencyController::class, 'update'])->name('update');
            Route::get('delete/{id}', [CurrencyController::class, 'delete'])->name('delete');
        });
        Route::group(['prefix' => 'language', 'as' => 'languages.'], function () {
            Route::get('/', [LanguageController::class, 'index'])->name('index');
            Route::post('store', [LanguageController::class, 'store'])->name('store');
            Route::get('edit/{id}/{iso_code?}', [LanguageController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [LanguageController::class, 'update'])->name('update');
            Route::get('translate/{id}', [LanguageController::class, 'translateLanguage'])->name('translate');
            Route::post('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate');
            Route::get('delete/{id}', [LanguageController::class, 'delete'])->name('delete');
            Route::post('update-language/{id}', [LanguageController::class, 'updateLanguage'])->name('update-language');


            Route::get('translate/{id}/{iso_code?}', [LanguageController::class, 'translateLanguage'])->name('translate');
            Route::get('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate');
            Route::post('import', [LanguageController::class, 'import'])->name('import')->middleware('isDemo');
        });
        Route::group(['prefix' => 'meta', 'as' => 'meta.'], function () {
            Route::get('/', [MetaManagementController::class, 'metaIndex'])->name('index');
            Route::get('edit/{uuid}', [MetaManagementController::class, 'editMeta'])->name('edit');
            Route::put('update/{uuid}', [MetaManagementController::class, 'updateMeta'])->name('update');
        });


        Route::group(['prefix' => 'faq', 'as' => 'faq.', 'middleware' => 'permission:faq_setting'], function () {
            Route::get('faq-settings', [SettingController::class, 'faq'])->name('index');
            Route::post('faq-settings', [SettingController::class, 'faqUpdate'])->name('update');
        });

        Route::get('storage-settings', [SettingController::class, 'storageSetting'])->name('storage.index');
        Route::post('storage-settings', [SettingController::class, 'storageSettingsUpdate'])->name('storage.update')->middleware('isDemo');;
        Route::get('social-login-settings', [SettingController::class, 'socialLoginSetting'])->name('social-login');
        Route::post('chat-settings-update', [SettingController::class, 'chatGtpApiSettingUpdate'])->name('chat.gtp.update')->middleware('isDemo');;
        Route::post('google-analytics-update', [SettingController::class, 'googleAnalyticsSetting'])->name('google.analytics.update')->middleware('isDemo');;

        Route::get('google-recaptcha-settings', [SettingController::class, 'googleRecaptchaSetting'])->name('google-recaptcha')->middleware('isDemo');;
        Route::get('google-analytics-settings', [SettingController::class, 'googleAnalyticsSetting'])->name('google.analytics')->middleware('isDemo');;

    });

    Route::get('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration')->middleware('isDemo');;
    Route::post('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration')->middleware('isDemo');;
    Route::post('mail-test', [SettingController::class, 'mailTest'])->name('mail.test');

    Route::get('sms-configuration', [SettingController::class, 'smsConfiguration'])->name('sms-configuration')->middleware('isDemo');;
    Route::post('sms-configuration', [SettingController::class, 'smsConfigurationStore'])->name('sms-configuration')->middleware('isDemo');;
    Route::post('sms-test', [SettingController::class, 'smsTest'])->name('sms.test')->middleware('isDemo');;
    //Pusher Settings
    Route::get('pusher-configuration', [SettingController::class, 'pusherConfiguration'])->name('pusher-configuration')->middleware('isDemo');;
    Route::post('pusher-configuration', [SettingController::class, 'pusherConfigurationStore'])->name('pusher-configuration')->middleware('isDemo');;


    //contact -messages
    Route::get('contact-messages', [HomeController::class, 'showContactSMS'])->name('contact.sms.index');
    Route::get('contact-message-delete/{id}', [HomeController::class, 'contactSMSDelete'])->name('contact.sms.delete');

    //announcement
    Route::get('announcement', [AnnouncementController::class, 'announcement'])->name('announcement.index');
    Route::post('announcement-store', [AnnouncementController::class, 'announcementStore'])->name('announcement-store');

    //Start:: Maintenance Mode
    Route::get('maintenance-mode-changes', [SettingController::class, 'maintenanceMode'])->name('maintenance');
    Route::post('maintenance-mode-changes', [SettingController::class, 'maintenanceModeChange'])->name('maintenance.change')->middleware('isDemo');;
    //End:: Maintenance Mode


    Route::get('database-backup-settings', [DatabaseBackupSettingController::class, 'index'])->name('db-settings');
    Route::get('database-backup-settings/create-backup/{id}', [DatabaseBackupSettingController::class, 'createBackup'])->name('db-settings.create_backup');
    Route::get('database-backup-settings/download/{file_name}', [DatabaseBackupSettingController::class, 'download'])->name('db-settings.download');
    Route::get('database-backup-settings/delete/{file_name}', [DatabaseBackupSettingController::class, 'delete'])->name('db-settings.delete');

    Route::get('cache-settings', [SettingController::class, 'cacheSettings'])->name('cache-settings');
    Route::get('cache-update/{id}', [SettingController::class, 'cacheUpdate'])->name('cache-update');
    Route::get('migrate-settings', [SettingController::class, 'migrateSettings'])->name('migrate-settings')->middleware('isDemo');;
    Route::get('migrate-update', [SettingController::class, 'migrateUpdate'])->name('migrate-update');

    Route::get('storage-link', [SettingController::class, 'storageLink'])->name('storage.link')->middleware('isDemo');;

    Route::get('security-settings', [SettingController::class, 'securitySettings'])->name('security.settings')->middleware('isDemo');;

    Route::group(['prefix' => 'gateway', 'as' => 'gateway.'], function () {
        Route::get('/', [GatewayController::class, 'index'])->name('index');
        Route::post('store', [GatewayController::class, 'store'])->name('store')->middleware('isDemo');
        Route::get('get-info', [GatewayController::class, 'getInfo'])->name('get.info');
        Route::get('get-currency-by-gateway', [GatewayController::class, 'getCurrencyByGateway'])->name('get.currency');
    });


    //Features Settings
    Route::get('cookie-settings', [SettingController::class, 'cookieSetting'])->name('cookie-settings');
    Route::post('cookie-settings-update', [SettingController::class, 'cookieSettingUpdated'])->name('cookie.settings.update');
    Route::get('live-chat-settings', [SettingController::class, 'liveChatSettings'])->name('live.chat.settings');
    Route::get('faq-settings', [SettingController::class, 'faqSettings'])->name('faq.settings');
    Route::get('custom-css', [SettingController::class, 'customCSS'])->name('custom-css');
    Route::post('custom-css-update', [SettingController::class, 'customCssUpdated'])->name('custom-css.update');

    //Role Settings
    Route::get('/role-settings', [RoleController::class, 'index'])->name('role.settings');
    Route::get('role-create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role-store', [RoleController::class, 'store'])->name('role.store');
    Route::get('role-edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('role-update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::get('role-delete/{id}', [RoleController::class, 'delete'])->name('role.delete');

    //comon setting update
    Route::post('common-settings-update', [SettingController::class, 'commonSettingUpdate'])->name('common.settings.update')->middleware('isDemo');

    //Country Settings
    Route::get('country-list', [SettingController::class, 'countrySettings'])->name('country.list');
    Route::get('country-update', [SettingController::class, 'countrySettingsUpdate'])->name('country.update')->middleware('isDemo');

    // news
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::post('news-store', [NewsController::class, 'newsStore'])->name('news.store');
    Route::get('news-info/{id}', [NewsController::class, 'newsInfo'])->name('news.info');
    Route::post('news-update', [NewsController::class, 'newsUpdate'])->name('news.update');
    Route::post('news-delete/{id}', [NewsController::class, 'newsDelete'])->name('news.delete');
    // Database Backup Settings

    //frontend
    Route::group(['prefix' => 'frontend', 'as' => 'frontend.'], function () {

        Route::get('/', [FrontendController::class, 'index'])->name('index');
        // feature
        Route::get('feature', [FeatureController::class, 'index'])->name('feature.index');
        Route::post('feature-store', [FeatureController::class, 'store'])->name('feature.store');
        Route::get('feature-info/{id}', [FeatureController::class, 'info'])->name('feature.info');
        Route::post('feature-update/{id}', [FeatureController::class, 'update'])->name('feature.update');
        Route::post('feature-delete/{id}', [FeatureController::class, 'delete'])->name('feature.delete');
        // services
        Route::get('service', [ServiceController::class, 'index'])->name('service.index');
        Route::post('service-store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('service-info/{id}', [ServiceController::class, 'info'])->name('service.info');
        Route::post('service-update/{id}', [ServiceController::class, 'update'])->name('service.update');
        // faq
        Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
        Route::post('faq/store', [FaqController::class, 'store'])->name('faq.store');
        Route::get('faq-info/{id}', [FaqController::class, 'info'])->name('faq.info');
        Route::post('faq-update/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::get('faq-delete/{id}', [FaqController::class, 'faqDelete'])->name('faq.delete');
        // faq category
        Route::get('faq-category', [FaqCategoryController::class, 'index'])->name('faq-category.index');
        Route::post('faq-category/store', [FaqCategoryController::class, 'store'])->name('faq-category.store');
        Route::get('faq-category-info/{id}', [FaqCategoryController::class, 'info'])->name('faq-category.info');
        Route::post('faq-category-update/{id}', [FaqCategoryController::class, 'update'])->name('faq-category.update');
        Route::get('faq-category-delete/{id}', [FaqCategoryController::class, 'faqCategoryDelete'])->name('delete');

        // Testimonial
        Route::get('testimonial', [TestimonialController::class, 'index'])->name('testimonial.index');
        Route::post('testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('testimonial-info/{id}', [TestimonialController::class, 'info'])->name('testimonial.info');
        Route::post('testimonial-update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
        Route::get('testimonial-delete/{id}', [TestimonialController::class, 'delete'])->name('testimonial.delete');
        //teams
        Route::get('team', [TeamController::class, 'index'])->name('team.index');
        Route::post('team/store', [TeamController::class, 'store'])->name('team.store');
        Route::get('team-info/{id}', [TeamController::class, 'info'])->name('team.info');
        Route::post('team-update/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::get('team-delete/{id}', [TeamController::class, 'delete'])->name('team.delete');
        //how-it-work
        Route::get('how-it-work', [HowItWorkController::class, 'index'])->name('how_it_work.index');
        Route::get('how_it_work-info/{id}', [HowItWorkController::class, 'info'])->name('how_it_work.info');
        Route::post('how_it_work-update/{id}', [HowItWorkController::class, 'update'])->name('how_it_work.update');
        //About-us
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('pages-info/{id}', [PageController::class, 'info'])->name('pages.info');
        Route::post('pages-update/{id}', [PageController::class, 'update'])->name('pages.update');
        //counter area
        Route::get('counter-area', [CounterAreaController::class, 'index'])->name('counter_area.index');
        Route::get('counter-area-info/{id}', [CounterAreaController::class, 'info'])->name('counter_area.info');
        Route::post('counter-area-update/{id}', [CounterAreaController::class, 'update'])->name('counter_area.update');
        //Our mission
        Route::get('our-mission', [OurMissionController::class, 'index'])->name('our_mission.index');
        Route::get('our-mission-info/{id}', [OurMissionController::class, 'info'])->name('our_mission.info');
        Route::post('our-mission-update/{id}', [OurMissionController::class, 'update'])->name('our_mission.update');

        Route::get('section', [FrontendController::class, 'section'])->name('section');
        Route::get('section-info/{id}', [FrontendController::class, 'frontendSectionInfo'])->name('section.info');
        Route::post('section-update', [FrontendController::class, 'frontendSectionUpdate'])->name('section.update');

        // knowledge
        Route::get('knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
        Route::post('knowledge/store', [KnowledgeController::class, 'store'])->name('knowledge.store');
        Route::get('knowledge-info/{id}', [KnowledgeController::class, 'info'])->name('knowledge.info');
        Route::post('knowledge-update/{id}', [KnowledgeController::class, 'update'])->name('knowledge.update');
        Route::get('knowledge-delete/{id}', [KnowledgeController::class, 'knowledgeDelete'])->name('knowledge.delete');
        // knowledge category
        Route::get('knowledge-category', [KnowledgeCategoryController::class, 'index'])->name('knowledge-category.index');
        Route::post('knowledge-category/store', [KnowledgeCategoryController::class, 'store'])->name('knowledge-category.store');
        Route::get('knowledge-category-info/{id}', [KnowledgeCategoryController::class, 'info'])->name('knowledge-category.info');
        Route::post('knowledge-category-update/{id}', [KnowledgeCategoryController::class, 'update'])->name('knowledge_category.update');
        Route::get('knowledge-category-delete/{id}', [KnowledgeCategoryController::class, 'knowledgeCategoryDelete'])->name('knowledge.category.delete');


        Route::group(['prefix' => 'news-articles', 'as' => 'news-articles.'], function () {
            Route::get('/', [NewsArticleController::class, 'newsArticlesList'])->name('index');
            Route::get('news-articles-add', [NewsArticleController::class, 'newsArticlesAdd'])->name('add');
            Route::post('news-articles-store', [NewsArticleController::class, 'newsArticlesStore'])->name('store');
            Route::get('news-articles-edit-{id}', [NewsArticleController::class, 'newsArticlesEdit'])->name('edit');
            Route::post('news-articles-update', [NewsArticleController::class, 'newsArticlesUpdate'])->name('update');
            Route::post('news-articles-delete-{id}', [NewsArticleController::class, 'newsArticlesDelete'])->name('delete');
            Route::get('news-articles-details-{id}', [NewsArticleController::class, 'newsArticlesDetails'])->name('details');
        });
    });

    Route::get('tracking-no-pre-fixed', [SettingController::class, 'trackingNoPreFixed'])->name('tracking-no-pre-fixed');
    Route::post('tracking-no-pre-fixed-store', [SettingController::class, 'trackingNoPreFixedDataStore'])->name('tracking-no-pre-fixed-store');


    Route::get('business-hours', [BusinessHoursController::class, 'businessHours'])->name('business-hours');
    Route::post('business-hours-store', [BusinessHoursController::class, 'businessHourStore'])->name('business-hours-store');
    Route::post('business-hours-section-data-store', [BusinessHoursController::class, 'businessHoursSectionDataStore'])->name('business-hours-section-data-store');

    Route::get('email-template', [EmailTemplateController::class, 'emailTemplate'])->name('email-template');
    Route::get('email-edit', [EmailTemplateController::class, 'emailTempEdit'])->name('email-edit');
    Route::get('email-edit/{id}', [EmailTemplateController::class, 'emailTempEdit'])->name('email-edit');
    Route::post('email-temp-update/{id}', [EmailTemplateController::class, 'emailTempUpdate'])->name('email-temp-update')->middleware('isDemo');;

});

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
    Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
});

//blog setting
Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function () {
    Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
        Route::get('list', [BlogTagController::class, 'index'])->name('index');
        Route::post('store', [BlogTagController::class, 'store'])->name('store');
        Route::get('info/{id}', [BlogTagController::class, 'info'])->name('info');
        Route::post('update/{id}', [BlogTagController::class, 'update'])->name('update');
        Route::post('delete/{id}', [BlogTagController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('list', [BlogCategoryController::class, 'index'])->name('index');
        Route::post('store', [BlogCategoryController::class, 'store'])->name('store');
        Route::get('info/{id}', [BlogCategoryController::class, 'info'])->name('info');
        Route::post('update/{id}', [BlogCategoryController::class, 'update'])->name('update');
        Route::post('delete/{id}', [BlogCategoryController::class, 'delete'])->name('delete');
    });

    Route::get('list', [BlogController::class, 'index'])->name('index');
    Route::post('store', [BlogController::class, 'store'])->name('store');
    Route::get('info/{id}', [BlogController::class, 'info'])->name('info');
    Route::post('update/{id}', [BlogController::class, 'update'])->name('update');
    Route::post('delete/{id}', [BlogController::class, 'delete'])->name('delete');
});

//users
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('list', [UserController::class, 'userList'])->name('list');
    Route::get('customer-list', [UserController::class, 'customerList'])->name('customer.list');
    Route::get('add-new', [UserController::class, 'userAdd'])->name('add-new');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('details-{id}', [UserController::class, 'userDetails'])->name('details');
    Route::get('edit-{id}', [UserController::class, 'userEdit'])->name('edit');
    Route::post('update', [UserController::class, 'userUpdate'])->name('update')->middleware('isDemo');
    Route::get('suspend-{id}', [UserController::class, 'userSuspend'])->name('suspend');
    Route::get('delete-{id}', [UserController::class, 'userDelete'])->name('delete');
    Route::get('activity-{id}', [UserController::class, 'userActivity'])->name('activity');
});

Route::get('custom-pages', [CustomPageController::class, 'customPages'])->name('custom-pages');
Route::post('custom-pages-store', [CustomPageController::class, 'customPagesStore'])->name('custom-pages-store');
Route::get('custom-pages-edit/{id}', [CustomPageController::class, 'customPagesEdit'])->name('custom-pages-edit');
Route::post('custom-pages-update/{id}', [CustomPageController::class, 'customPagesUpdate'])->name('custom-pages-update');
Route::get('custom-pages-delete/{id}', [CustomPageController::class, 'customPagesDelete'])->name('custom-pages-delete');

Route::get('custom-error-pages', [CustomPageController::class, 'customErrorPages'])->name('custom-error-pages');
Route::get('custom-maintenance-pages', [CustomPageController::class, 'customMaintenancePages'])->name('custom-maintenance-pages');

Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
    Route::get('category', [TicketCategoryController::class, 'category'])->name('category');
    Route::post('category-store', [TicketCategoryController::class, 'categoryStore'])->name('category-store');
    Route::get('category-edit/{id?}', [TicketCategoryController::class, 'categoryEdit'])->name('category-edit');
    Route::get('category-delete/{id?}', [TicketCategoryController::class, 'categoryDelete'])->name('category-delete');

    Route::get('tag', [TicketTagController::class, 'tag'])->name('tag');
    Route::post('tag-store', [TicketTagController::class, 'tagStore'])->name('tag-store');
    Route::get('tag-edit/{id?}', [TicketTagController::class, 'tagEdit'])->name('tag-edit');
    Route::get('tag-delete/{id?}', [TicketTagController::class, 'tagDelete'])->name('tag-delete');

    Route::get('all-tickets', [TicketController::class, 'ticketList'])->name('ticketList');
    Route::get('view-ticket/{id?}/{user_id?}', [TicketController::class, 'ticketView'])->name('ticket_view');
    Route::get('ticket-delete/{id?}', [TicketController::class, 'ticketDelete'])->name('ticket-delete');
    Route::get('my-ticket-history/{id}', [TicketController::class, 'myTicketHistory'])->name('my-ticket-history');
    Route::get('ticket-assign-to/{id?}', [TicketController::class, 'ticketAssignTo'])->name('ticketAssignTo');
    Route::get('ticket-assign-to-users/{id?}', [TicketController::class, 'ticketAssignToUsers'])->name('ticketAssignToUsers');
    Route::post('ticket-assign-data-save', [TicketController::class, 'assignTicketsDataStore'])->name('assignTicketsDataStore');
    Route::get('recent-tickets', [TicketController::class, 'recentTicketList'])->name('recentTicketList');
    Route::get('active-tickets', [TicketController::class, 'activeTicketList'])->name('activeTicketList');
    Route::get('closed-tickets-global', [TicketController::class, 'closedTicketList'])->name('closedTicketList');
    Route::get('on-hold-tickets', [TicketController::class, 'onHoldTicketList'])->name('onHoldTicketList');
    Route::get('assigned-tickets', [TicketController::class, 'assignedTicketList'])->name('assignedTicketList');
    Route::get('suspended-tickets', [TicketController::class, 'suspendedTicketList'])->name('suspendedTicketList');
    Route::get('resolved-tickets', [TicketController::class, 'resolvedTicketList'])->name('resolvedTicketList');
    Route::get('deleted-tickets', [TicketController::class, 'deleteTicketList'])->name('deleted-tickets');

    Route::get('self-assigned-tickets', [SelfTicketController::class, 'selfAssignedTickets'])->name('self-assigned-tickets');
    Route::get('my-assigned-tickets', [SelfTicketController::class, 'myAssignedTickets'])->name('my-assigned-tickets');
    Route::get('closed-tickets', [SelfTicketController::class, 'closedTickets'])->name('closed-tickets');
    Route::get('suspend-tickets', [SelfTicketController::class, 'suspendTickets'])->name('suspend-tickets');
    Route::get('flying', [TicketController::class, 'flyingTicket'])->name('flying');
    /*Ticket Details Start*/
    Route::post('ticket-tag-assign', [TicketController::class, 'addTicketTags'])->name('addTicketTags');
    Route::post('category-update', [TicketController::class, 'categoryUpdate'])->name('categoryUpdate');
    Route::post('priority-update', [TicketController::class, 'priorityUpdate'])->name('priorityUpdate');
    Route::post('ticket-assignment', [TicketController::class, 'assignTicketUser'])->name('assignTicketUser');
    Route::post('ticket-status-change', [TicketController::class, 'ticketStatusUpdate'])->name('ticketStatusUpdate');
    /*Ticket Details End*/

    Route::post('ticket-multi-delete', [TicketController::class, 'ticketMultiDelete'])->name('ticket-multi-delete');
//    Route::get('ticket-ratings', [TicketRatingController::class, 'manageTicketRatings'])->name('manageTicketRatings');
//    Route::get('ticket-rating-edit/{id}', [TicketRatingController::class, 'ticketRatingEdit'])->name('ticket-rating-edit');
//    Route::post('ticket-rating-status-update', [TicketRatingController::class, 'ticketRatingUpdate'])->name('ticketRatingUpdate');
//    Route::get('ticket-rating-delete/{id?}', [TicketRatingController::class, 'ticketRatingDelete'])->name('ticket-rating-delete');

    Route::post('license-data-update', [TicketController::class, 'licenseDataUpdate'])->name('license-data-update');


});
Route::get('all-notification', [NotificationController::class, 'allNotification'])->name('all-notification');
Route::get('notification-mark-as-read', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
Route::get('notification-view/{id}', [NotificationController::class, 'notificationView'])->name('notification-view');
Route::get('notification-delete/{id}', [NotificationController::class, 'notificationDelete'])->name('notification-delete');
Route::group(['prefix' => 'conversations', 'as' => 'conversations.'], function () {
//    Route::post('conversation-store', [ConversationController::class, 'conversationStore'])->name('conversationStore');
    Route::post('conversation-store/{id}', [ConversationController::class, 'conversationStore'])->name('conversationStore');
//    Route::post('conversation-edit/{id?}', [ConversationController::class, 'conversationEdit'])->name('conversation-edit');
    Route::post('conversation-update', [ConversationController::class, 'conversationUpdate'])->name('conversation-update');
    Route::get('conversation-delete', [ConversationController::class, 'conversationDelete'])->name('conversation-delete');
    Route::post('instant-message-store', [InstantMessageController::class, 'instantMessage'])->name('instantMessage');
    Route::get('instant-message.delete/{id}', [InstantMessageController::class, 'instantmessageDelete'])->name('instant.message.delete');
});
Route::group(['prefix' => 'notes', 'as' => 'notes.'], function () {
    Route::post('note-store', [NoteController::class, 'noteStore'])->name('noteStore');
    Route::get('note-delete/{id?}', [NoteController::class, 'noteDelete'])->name('note-delete');
});
Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
    Route::get('list', [GroupController::class, 'list'])->name('list');
    Route::post('store', [GroupController::class, 'store'])->name('store');
    Route::get('edit/{id?}', [GroupController::class, 'edit'])->name('edit');
    Route::get('delete/{id?}', [GroupController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'envato', 'as' => 'envato.'], function () {
    Route::get('config', [EnvatoController::class, 'config'])->name('config');
    Route::post('config-store', [EnvatoController::class, 'configStore'])->name('config-store')->middleware('check_user_has_tenant_id')->middleware('isDemo');;
    Route::get('config-modal', [EnvatoController::class, 'configModal'])->name('config-modal')->middleware('isDemo');
    Route::post('config-modal-data-store', [EnvatoController::class, 'configModalDataStore'])->name('config-modal-data-store')->middleware('isDemo');
    Route::get('config-help', [EnvatoController::class, 'configHelp'])->name('config-help');
    Route::get('license-verification', [EnvatoController::class, 'licenseVerification'])->name('license-verification');
    Route::post('license-verification-action', [EnvatoController::class, 'licenseVerificationAction'])->name('license-verification-action');
});


Route::get('ai-replay-generate', [App\Http\Controllers\AIController::class, 'aiReplayGenerate'])->name('ai-replay-generate');
Route::get('ai-replay-delete', [App\Http\Controllers\AIController::class, 'aiReplayDelete'])->name('ai-replay-delete');

Route::get('dynamic-fields', [DynamicFieldController::class, 'dynamicFields'])->name('dynamic-fields');
Route::post('dynamic-fields-store', [DynamicFieldController::class, 'dynamicFieldsStore'])->name('dynamic-fields-store');
Route::post('dynamic-fields-data-update', [DynamicFieldController::class, 'dynamicFieldsDataUpdate'])->name('dynamic-fields-data-update');


//Route::get('check-collision-detector', [CollisionDetector::class, 'collisionDetector'])->name('check-collision-detector');

Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
    Route::get('orders', [SubscriptionController::class, 'orders'])->name('orders');
    Route::get('orders/get-info', [SubscriptionController::class, 'orderGetInfo'])->name('orders.get.info'); // ajax
    Route::post('orders/payment-status-change', [SubscriptionController::class, 'orderPaymentStatusChange'])->name('order.payment.status.change');
    Route::get('orders-payment-status', [SubscriptionController::class, 'ordersStatus'])->name('orders.payment.status'); // ajax
});

Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
    Route::get('/', [PackageController::class, 'index'])->name('index');
    Route::get('get-info', [PackageController::class, 'getInfo'])->name('get.info'); // ajax
    Route::post('store', [PackageController::class, 'store'])->name('store');
    Route::get('destroy/{id}', [PackageController::class, 'destroy'])->name('destroy');
    Route::get('pay/{id}', [PackageController::class, 'pay'])->name('pay');
    Route::get('user', [PackageController::class, 'userPackage'])->name('user');
    Route::post('assign', [PackageController::class, 'assignPackage'])->name('assign');
});

Route::get('subscription/index/{package_id?}/{type?}', [MySubscriptionController::class, 'index'])->name('subscription.index');
Route::get('get-plan', [MySubscriptionController::class, 'getPlan'])->name('get_plan_modal_data');
Route::post('subscription/order', [MySubscriptionController::class, 'subscriptionOrder'])->name('subscription.order');
Route::get('subscription/order', [MySubscriptionController::class, 'subscriptionOrder'])->name('subscription.order');
Route::get('get-currency-by-gateway', [MySubscriptionController::class, 'getCurrencyByGateway'])->name('get.currency');
Route::post('subscription/cancel', [MySubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel')->middleware('isDemo');
Route::get('get-invoice/{id}', [MySubscriptionController::class, 'invoicePrint'])->name('subscription.invoice.print');
Route::post('set-user-package/{id}', [MySubscriptionController::class, 'userPackage'])->name('user_packages.update');


Route::group(['prefix' => 'custom/domain', 'as' => 'custom.domain.'], function () {
    Route::get('request-list', [DomainController::class, 'requestList'])->name('request-list');
    Route::get('status-change-modal-info', [DomainController::class, 'statusChangemodal'])->name('status-change-modal-info');
    Route::post('status-change', [DomainController::class, 'statusChange'])->name('status-change');
    Route::get('instruction', [DomainController::class, 'instruction'])->name('instruction');
});


// version update
Route::get('version-update', [VersionUpdateController::class, 'versionFileUpdate'])->name('file-version-update');
Route::post('version-update', [VersionUpdateController::class, 'versionFileUpdateStore'])->name('file-version-update-store');
Route::get('version-update-execute', [VersionUpdateController::class, 'versionUpdateExecute'])->name('file-version-update-execute');
Route::get('version-delete', [VersionUpdateController::class, 'versionFileUpdateDelete'])->name('file-version-delete');

Route::group(['prefix' => 'addon', 'as' => 'addon.'], function () {
    Route::get('details/{code}', [AddonUpdateController::class, 'addonSaasDetails'])->name('details')->withoutMiddleware(['addon.update']);
    Route::post('store', [AddonUpdateController::class, 'addonSaasFileStore'])->name('store')->withoutMiddleware(['addon.update']);
    Route::post('execute', [AddonUpdateController::class, 'addonSaasFileExecute'])->name('execute')->withoutMiddleware(['addon.update']);
    Route::get('delete/{code}', [AddonUpdateController::class, 'addonSaasFileDelete'])->name('delete')->withoutMiddleware(['addon.update']);
});

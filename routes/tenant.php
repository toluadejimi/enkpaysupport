<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\Customer\TicketsController;
use App\Http\Controllers\Tenant\SearchController;
use App\Http\Controllers\Tenant\HomeController;
use App\Http\Controllers\TicketRatingController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware(['web','tenant'])->group(function () {
    Route::get('/local/{ln}',[LanguageController::class,'langForTenancy'])->name('local');

    Route::get('/', [HomeController::class, 'index'])->name('frontend')->middleware('installed','2fa_verify');
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('tenant.login')->middleware('2fa_verify');
    Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('2fa_verify');
    Route::get('register', [RegisterController::class, 'signup'])->name('tenant.register')->middleware('2fa_verify');
    Route::post('register', [RegisterController::class, 'register'])->name('register')->middleware('2fa_verify');
    Route::get('terms-of-use', [HomeController::class, 'termsOfUse'])->name('terms.of.use.index');

    Route::get('faqs', [HomeController::class, 'faqs'])->name('tenant.faqs');
    Route::get('knowledge', [HomeController::class, 'knowledge'])->name('tenant.knowledge');
    Route::get('knowledge/category/{id?}', [HomeController::class, 'knowledgeCategory'])->name('tenant.knowledge-category');
    Route::get('knowledge/category/details/{id?}', [HomeController::class, 'knowledgeCategorySingle'])->name('tenant.knowledge-category-single');

    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('tenant.contact.us.index');
    Route::post('contact-us', [HomeController::class, 'contactSMStore'])->name('tenant.contact.us.store');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('faqs', [HomeController::class, 'faqs'])->name('tenant.faqs');

    Route::get('search', [SearchController::class,'search'])->name('tenant.search');
    Route::post('knowledge-search', [SearchController::class,'knowledgeSearch'])->name('tenant.knowledge-search');
    Route::get('search-knowledge', [SearchController::class,'searchKnowledge'])->name('tenant.searchKnowledge');
    Route::get('search-knowledge-details/{id?}', [SearchController::class,'searchKnowledgeDetails'])->name('tenant.searchKnowledge.details');

    Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
        Route::get('create-ticket', [TicketsController::class, 'guestCreateTicket'])->name('guest-create-ticket');
        Route::post('guest-ticket-submit', [TicketsController::class, 'guestTicketStore'])->name('guest-ticket-submit');
        Route::get('ticket-view/{id}', [TicketsController::class, 'guestTicketDetails'])->name('guest-ticket-view');
        Route::post('conversation-store/{id}', [ConversationController::class, 'guestConversationStore'])->name('conversationStore');
        Route::post('ticket-status-change', [TicketsController::class, 'guestTicketStatusUpdate'])->name('ticketStatusUpdate');
        Route::post('ticket-ratings/{ratingId?}', [TicketRatingController::class, 'guestTicketRatingStore'])->name('ticketRatingStore');
    });

});


    Route::middleware((isAddonInstalled('DESKSAAS') > 0)?['web', 'auth', 'agent', 'is_email_verify', 'version.update', '2fa_verify', 'common',
        PreventAccessFromCentralDomains::class]:
        ['web', 'auth', 'agent', 'is_email_verify', 'version.update', '2fa_verify', 'common'])
        ->prefix('agent')
        ->as('agent.')
        ->group(base_path('routes/agent.php'));

    Route::middleware((isAddonInstalled('DESKSAAS') > 0)?['web', 'auth', 'customer', 'is_email_verify', 'version.update', '2fa_verify', 'common',
        PreventAccessFromCentralDomains::class]:
        ['web', 'auth', 'customer', 'is_email_verify', 'version.update', '2fa_verify', 'common'])
        ->prefix('customer')
        ->as('customer.')
        ->group(base_path('routes/customer.php'));


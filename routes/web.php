<?php

use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Saas\PaymentController;
use App\Http\Controllers\UserEmailVerifyController;
use App\Http\Controllers\VersionUpdateController;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => 'version.update'], function () {

    Route::get('/register/{ref_code?}', [RegisterController::class, 'signup'])->name('register');

    Route::get('/local/{ln}', function ($ln) {
        $language = Language::where('iso_code', $ln)->first();
        if (!$language) {
            $language = Language::where('default', 1)->first();
            if ($language) {
                $ln = $language->iso_code;
            }
        }

        session()->put('local', $ln);
        return redirect()->back();
    })->name('local');

    Auth::routes(['verify' => false]);

    Route::get('/', [HomeController::class, 'index'])->name('frontend')->middleware('installed', '2fa_verify');
    Route::get('/custom-page/{slug}', [HomeController::class, 'customPage']);
    Route::get('pricing', [HomeController::class, 'pricing'])->name('pricing');
    Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');
    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact.us.index');
    Route::post('contact-us', [HomeController::class, 'contactSMStore'])->name('contact.us.store');

    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

    Route::get('/test', function () {
        //notify
        $title = __("Verification Reject");
        $details = __("Your Document Verification Rejected! Upload valid document.");
        setCommonNotification($title, $details, 1);
        //notify
    });

});


Route::post('email/verified/{token}', [UserEmailVerifyController::class, 'emailVerified'])->name('email.verified');
Route::get('email/verify/{token}', [UserEmailVerifyController::class, 'emailVerify'])->name('email.verify');
Route::post('email/verify/resend/{token}', [UserEmailVerifyController::class, 'emailVerifyResend'])->name('email.verify.resend');


Route::get('version-update', [VersionUpdateController::class, 'versionUpdate'])->name('version-update');
Route::post('process-update', [VersionUpdateController::class, 'processUpdate'])->name('process-update');
Route::get('version-check', [VersionUpdateController::class, 'versionCheck'])->name('versionCheck');


Route::group(['prefix' => 'payment'], function () {
    Route::post('/', [PaymentController::class, 'checkout'])->name('payment.checkout')->middleware('isDemo')->withoutMiddleware('version.update');
    Route::match(array('GET', 'POST'), 'verify', [PaymentController::class, 'verify'])->name('payment.verify')->middleware('isDemo')->withoutMiddleware('version.update');
});

Route::get('terms-of-use', [HomeController::class, 'termsOfUse'])->name('terms.of.use.index');

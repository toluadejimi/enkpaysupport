<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\UserController;
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
Route::get('dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard_chart_data');

Route::get('make-favorite-or-not', [DashboardController::class, 'makeFavorite'])->name('make.favorite.or.not');

Route::get('get-currency-price', [DashboardController::class, 'getCurrencyPrice'])->name('get.currency.price');

// news
Route::get('news/{id}', [NewsController::class, 'newsDetails'])->name('news.details');

// profile
Route::get('settings', [ProfileController::class, 'settings'])->name('settings');
Route::post('profile-update', [ProfileController::class, 'userProfileUpdate'])->name('profile.update');
Route::get('security', [ProfileController::class, 'security'])->name('security');
Route::post('phone-verification-sms-send', [ProfileController::class, 'smsSend'])->name('phone.verification.sms.send');
Route::get('phone-verification-sms-resend', [ProfileController::class, 'smsReSend'])->name('phone.verification.sms.resend');
Route::post('phone-verification-sms-verify', [ProfileController::class, 'smsVerify'])->name('phone.verification.sms.verify');

Route::post('kyc-verification-store', [ProfileController::class, 'kycVerificationStore'])->name('kyc.verification.store');
Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change.password');
Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
Route::get('announcement', [UserController::class, 'announcementSeen'])->name('announcement.seen.update');


//notification
Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    Route::get('details-{id}', [NotificationController::class, 'details'])->name('details');
    Route::get('mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark_all_read');
});


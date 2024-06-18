<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\TicketsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\InstantMessageController;
use App\Http\Controllers\TicketRatingController;

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
Route::get('set-session-data', [DashboardController::class, 'setSessionData'])->name('set-session-data');
Route::get('announcement', [DashboardController::class, 'announcementSeen'])->name('announcement.seen.update');
Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
    Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
});

Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
    Route::get('create-ticket', [TicketsController::class, 'createTicket'])->name('create-ticket');
    Route::post('submit', [TicketsController::class, 'store'])->name('submit');

    Route::get('active-ticket', [TicketsController::class, 'activeTicket'])->name('active-ticket');
    Route::get('on-hold-tickets', [TicketsController::class, 'onHoldTickets'])->name('on-hold-tickets');
    Route::get('closed-tickets', [TicketsController::class, 'closedTickets'])->name('closed-tickets');
    Route::get('resolved-tickets', [TicketsController::class, 'resolvedTicketList'])->name('resolved-tickets');
    Route::get('ticket-view-{id?}', [TicketsController::class, 'ticketView'])->name('ticket-view');
//    Route::get('ticket-edit-{id?}', [TicketsController::class, 'ticketEdit'])->name('ticket-edit');
    Route::get('ticket-delete/{id?}', [TicketsController::class, 'ticketDelete'])->name('ticket-delete');

    Route::post('ticket-multi-delete', [TicketsController::class, 'ticketMultiDelete'])->name('ticket-multi-delete');

    Route::post('ticket-status-change', [TicketsController::class, 'ticketStatusUpdate'])->name('ticketStatusUpdate');
    Route::post('ticket-ratings/{ratingId?}', [TicketRatingController::class, 'ticketRatingStore'])->name('ticketRatingStore');
});

Route::group(['prefix' => 'conversations', 'as' => 'conversations.'], function () {
//    Route::post('conversation-store', [ConversationController::class, 'conversationStore'])->name('conversationStore');
    Route::post('conversation-store/{id}', [ConversationController::class, 'conversationStore'])->name('conversationStore');
    Route::post('instant-message-store', [InstantMessageController::class, 'instantMessage'])->name('instantMessage');
});
Route::get('all-notification', [NotificationController::class, 'allNotification'])->name('all-notification');
Route::get('notification-mark-as-read', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
Route::get('notification-view/{id}', [NotificationController::class, 'notificationView'])->name('notification-view');
Route::get('notification-delete/{id}', [NotificationController::class, 'notificationDelete'])->name('notification-delete');


Route::group(['prefix' => 'live-chat', 'as' => 'live-chat.'], function () {
    Route::get('fetch-msg', [App\Http\Controllers\ChatController::class, 'fetchMessages'])->name('fetch-msg');
    Route::post('send-msg', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('send-msg');
    Route::get('session-status-change', [App\Http\Controllers\ChatController::class, 'sessionStatusChange'])->name('session-status-change');
    Route::get('chat-history', [App\Http\Controllers\ChatController::class, 'chathistory'])->name('chat-history');
    Route::get('fetch-history-msg', [App\Http\Controllers\ChatController::class, 'getSingleHistoryData'])->name('fetch-history-msg');
});


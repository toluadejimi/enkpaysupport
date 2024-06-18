<?php


use App\Http\Controllers\Admin\DynamicFieldController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\EnvatoController;
use App\Http\Controllers\Agent\NotificationController;
use App\Http\Controllers\Agent\ProfileController;
use App\Http\Controllers\Agent\TicketsController;
use App\Http\Controllers\CollisionDetector;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\InstantMessageController;


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
Route::get('dashboard-daily-ticket-chart', [DashboardController::class, 'dashboardDailyTicketChart'])->name('dashboard-daily-ticket-chart');
Route::get('dashboard-category-chart', [DashboardController::class, 'dashboardCategoryChart'])->name('dashboard-category-chart');
Route::get('set-session-data', [DashboardController::class, 'setSessionData'])->name('set-session-data');
Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
    Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
});

Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
    Route::get('create-ticket', [TicketsController::class, 'createTicket'])->name('create-ticket');
    Route::post('submit', [TicketsController::class, 'store'])->name('submit');

    Route::get('all-ticket', [TicketsController::class, 'allTicket'])->name('all-ticket');
    Route::get('recent-ticket', [TicketsController::class, 'recentTicket'])->name('recent-ticket');
    Route::get('active-ticket', [TicketsController::class, 'activeTicket'])->name('active-ticket');
    Route::get('my-ticket-history/{id}', [TicketsController::class, 'myTicketHistory'])->name('my-ticket-history');

    Route::get('self-assigned-ticket', [TicketsController::class, 'selfAssignedTicket'])->name('self-assigned-ticket');
    Route::get('my-assigned-ticket', [TicketsController::class, 'myAssignedTicket'])->name('my-assigned-ticket');
    Route::get('resolved-tickets', [TicketsController::class, 'resolvedTicketList'])->name('resolvedTicketList');
    Route::get('suspend-ticket', [TicketsController::class, 'suspendTicket'])->name('suspend-ticket');
    Route::get('deleted-tickets', [TicketsController::class, 'deleteTicketList'])->name('deleted-tickets');

    Route::get('on-hold-tickets', [TicketsController::class, 'onHoldTickets'])->name('on-hold-tickets');
    Route::get('closed-tickets', [TicketsController::class, 'closedTickets'])->name('closed-tickets');
    Route::get('view-ticket/{id?}/{user_id?}', [TicketsController::class, 'ticketView'])->name('view-ticket');
    Route::get('ticket-delete/{id?}', [TicketController::class, 'ticketDelete'])->name('ticket-delete');

    Route::post('ticket-multi-delete', [TicketsController::class, 'ticketMultiDelete'])->name('ticket-multi-delete');
    /*Ticket Details Start*/
    Route::post('ticket-tag-assign', [TicketController::class, 'addTicketTags'])->name('addTicketTags');
    Route::post('category-update', [TicketsController::class, 'categoryUpdate'])->name('categoryUpdate');
    Route::post('priority-update', [TicketsController::class, 'priorityUpdate'])->name('priorityUpdate');
    Route::post('ticket-assignment', [TicketsController::class, 'assignTicketUser'])->name('assignTicketUser');
    Route::post('ticket-status-change', [TicketsController::class, 'ticketStatusUpdate'])->name('ticketStatusUpdate');
    /*Ticket Details End*/
    Route::post('license-data-update', [TicketsController::class, 'licenseDataUpdate'])->name('license-data-update');

});

Route::get('all-notification', [NotificationController::class, 'allNotification'])->name('all-notification');
Route::get('notification-mark-as-read', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
Route::get('notification-view/{id}', [NotificationController::class, 'notificationView'])->name('notification-view');
Route::get('notification-delete/{id}', [NotificationController::class, 'notificationDelete'])->name('notification-delete');
Route::group(['prefix' => 'conversations', 'as' => 'conversations.'], function () {
//    Route::post('conversation-store', [ConversationController::class, 'conversationStore'])->name('conversationStore');
    Route::post('conversation-store/{id}', [ConversationController::class, 'conversationStore'])->name('conversationStore');
    Route::post('conversation-update', [ConversationController::class, 'conversationUpdate'])->name('conversation-update');
    Route::get('conversation-delete', [ConversationController::class, 'conversationDelete'])->name('conversation-delete');
    Route::post('instant-message-store', [InstantMessageController::class, 'instantMessage'])->name('instantMessage');
    Route::get('instant-message.delete/{id}', [InstantMessageController::class, 'instantmessageDelete'])->name('instant.message.delete');
    Route::get('instant-message.search', [InstantMessageController::class, 'instantmessageSearch'])->name('instant.message.search');
});
Route::group(['prefix' => 'notes', 'as' => 'notes.'], function () {
    Route::post('note-store', [NoteController::class, 'noteStore'])->name('noteStore');
    Route::get('note-delete/{id?}', [NoteController::class, 'noteDelete'])->name('note-delete');
});


Route::get('ai-replay-generate', [App\Http\Controllers\AIController::class, 'aiReplayGenerate'])->name('ai-replay-generate');
Route::get('ai-replay-delete', [App\Http\Controllers\AIController::class, 'aiReplayDelete'])->name('ai-replay-delete');

Route::group(['prefix' => 'live-chat', 'as' => 'live-chat.'], function () {
    Route::get('inbox', [App\Http\Controllers\ChatController::class, 'chatInbox'])->name('inbox');
    Route::get('fetch-msg', [App\Http\Controllers\ChatController::class, 'fetchMessagesAgent'])->name('fetch-msg');
    Route::post('send-msg', [App\Http\Controllers\ChatController::class, 'sendMessageAgent'])->name('send-msg');
    Route::get('unseen-msg', [App\Http\Controllers\ChatController::class, 'unseenMsg'])->name('unseen-msg');
});

//Route::get('check-collision-detector', [CollisionDetector::class, 'collisionDetector'])->name('check-collision-detector');
Route::post('dynamic-fields-data-update', [DynamicFieldController::class, 'dynamicFieldsDataUpdate'])->name('dynamic-fields-data-update');


Route::group(['prefix' => 'envato', 'as' => 'envato.'], function () {
    Route::get('license-verification', [EnvatoController::class, 'licenseVerification'])->name('license-verification');
    Route::post('license-verification-action', [EnvatoController::class, 'licenseVerificationAction'])->name('license-verification-action');
});

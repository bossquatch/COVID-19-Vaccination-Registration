<?php

use App\Http\Controllers\WebhookController;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

Auth::routes([
    'register' => config('app.allow_self_service'),
    'verify' => true,
]);

Route::get('/not-supported', function() {
    return view('home.noie');
});

Route::group(["middleware" => "check.reset"], function() {
    Route::get('/', [App\Http\Controllers\AnalyticsController::class,'publicAnalytics']);

    Route::get('/faqs' , function() {
        return view('home.faqs');
    });

    Route::get('/privacy' , function() {
        return view('home.privacy');
    });

    Route::get('/terms' , function() {
        return view('home.terms');
    });

    Route::get('/doug', function () {
        return view('doug.notification');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home/register', [App\Http\Controllers\RegistrationController::class, 'submitRegistration']);
    Route::get('/edit', [App\Http\Controllers\RegistrationController::class, 'edit']);
    Route::post('/edit', [App\Http\Controllers\RegistrationController::class, 'update']);
    Route::delete('/home/delete', [App\Http\Controllers\RegistrationController::class, 'deleteRegistration']);

    Route::post('/home/invitation/accept', [App\Http\Controllers\InvitationController::class, 'accept'])->middleware('can:create_registration');
    Route::post('/home/invitation/decline', [App\Http\Controllers\InvitationController::class, 'decline'])->middleware('can:create_registration');
    Route::post('/home/invitation/postpone', [App\Http\Controllers\InvitationController::class, 'postpone'])->middleware('can:create_registration');

    Route::get('/address/validate', [App\Http\Controllers\UspsController::class, 'validateInlineAddress']);

    Route::get('/manage', [App\Http\Controllers\ManageController::class, 'index']);
    Route::get('/manage/register', [App\Http\Controllers\ManageController::class, 'register']);
    Route::post('/manage/register', [App\Http\Controllers\ManageController::class, 'submitRegistration']);
    Route::get('/manage/searchName', [App\Http\Controllers\ManageController::class, 'searchName']);
    Route::get('/manage/searchAddr', [App\Http\Controllers\ManageController::class, 'searchAddr']);
    Route::get('/manage/searchRegis', [App\Http\Controllers\ManageController::class, 'searchRegis']);
    Route::get('/manage/searchCode', [App\Http\Controllers\ManageController::class, 'searchCode']);
    Route::get('/manage/qr', [App\Http\Controllers\ManageController::class, 'qrRead'])->middleware('can:read_vaccine');
    Route::get('/manage/edit/{regis_id}', [App\Http\Controllers\ManageController::class, 'edit'])->middleware('can:update_registration');
    Route::post('/manage/edit/{regis_id}', [App\Http\Controllers\ManageController::class, 'updateRegistration'])->middleware('can:update_registration');
    Route::post('/manage/forcereset', [App\Http\Controllers\ManageController::class, 'forceResetPassword'])->middleware('can:update_registration');
    Route::delete('/manage/user/{id}', [App\Http\Controllers\ManageController::class, 'userDelete'])->middleware('can:update_registration');
    Route::delete('/manage/delete/{regis_id}', [App\Http\Controllers\ManageController::class, 'delete'])->middleware('can:update_registration');
    Route::post('/manage/{id}/invitation/accept', [App\Http\Controllers\InvitationController::class, 'acceptCallback'])->middleware('can:update_invite');
    Route::post('/manage/{id}/invitation/decline', [App\Http\Controllers\InvitationController::class, 'declineCallback'])->middleware('can:update_invite');
    Route::post('/manage/{id}/invitation/postpone', [App\Http\Controllers\InvitationController::class, 'postponeCallback'])->middleware('can:update_invite');
    Route::post('/manage/{id}/invitation/checkin', [App\Http\Controllers\InvitationController::class, 'checkIn'])->middleware('can:create_vaccine');
    Route::post('/manage/{id}/invitation/complete', [App\Http\Controllers\InvitationController::class, 'complete'])->middleware('can:create_vaccine');
    Route::post('/manage/{id}/invitation/turndown', [App\Http\Controllers\InvitationController::class, 'turnDown'])->middleware('can:create_vaccine');

    Route::get('/locations', [App\Http\Controllers\LocationController::class, 'index']);
    Route::post('/locations', [App\Http\Controllers\LocationController::class, 'store'])->middleware('can:create_location');
    Route::delete('/locations/{id}', [App\Http\Controllers\LocationController::class, 'delete'])->middleware('can:delete_location');

    Route::get('/events', [App\Http\Controllers\EventController::class, 'index']);
    Route::get('/events-history', [App\Http\Controllers\EventController::class, 'history']);
    Route::post('/events', [App\Http\Controllers\EventController::class, 'store'])->middleware('can:create_event');
    Route::get('/events/{id}', [App\Http\Controllers\EventController::class, 'read']);
    Route::get('/events/{id}/pending', [App\Http\Controllers\EventController::class, 'pendingInvites'])->middleware('can:update_invite');
    Route::get('/events/{event_id}/slots/{slot_id}', [App\Http\Controllers\EventController::class, 'slotInvites']);
    Route::put('/events/{event_id}/slots/{slot_id}/reserve', [App\Http\Controllers\EventController::class, 'reserve'])->middleware('can:create_invite');
    //Route::delete('/events/{id}', [App\Http\Controllers\EventController::class, 'delete'])->middleware('can:delete_event');
    Route::put('/events/{id}/open', [App\Http\Controllers\EventController::class, 'open']);
    Route::post('/events/{id}/lots', [App\Http\Controllers\EventController::class, 'addLot']);

    Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store']);
    Route::delete('/comments/{comment_id}', [App\Http\Controllers\CommentController::class, 'delete'])->middleware('can:update_registration');

    Route::post('/vaccine/add', [App\Http\Controllers\VaccineController::class, 'store']);

    Route::get('/sms/verify', [App\Http\Controllers\SmsVerificationController::class, 'show']);
    Route::post('/sms/verify', [App\Http\Controllers\SmsVerificationController::class, 'verify']);
    Route::post('/sms/resend', [App\Http\Controllers\SmsVerificationController::class, 'resend']);

    Route::get('/analytics', [App\Http\Controllers\AnalyticsController::class, 'index']);

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
    Route::get('/admin/reports', [App\Http\Controllers\AdminController::class, 'report']);
    Route::get('/admin/new', [App\Http\Controllers\AdminController::class, 'create'])->middleware('can:create_user');
    Route::get('/admin/tags', [App\Http\Controllers\TagController::class, 'index']);
    Route::get('/admin/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->middleware('can:update_user');

    Route::post('/admin', [App\Http\Controllers\AdminController::class, 'store'])->middleware('can:create_user');
    Route::post('/admin/reset', [App\Http\Controllers\AdminController::class, 'resetPassword'])->middleware('can:update_user');
    Route::put('/admin/{id}', [App\Http\Controllers\AdminController::class, 'update'])->middleware('can:update_user');
    Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'delete'])->middleware('can:delete_user');

    Route::get('/admin/tags/{id}/edit', [App\Http\Controllers\TagController::class, 'edit']);
    Route::post('/admin/tags', [App\Http\Controllers\TagController::class, 'new']);
    Route::post('/admin/tags/sync', [App\Http\Controllers\TagController::class, 'sync']);
    Route::post('/admin/tags/{id}', [App\Http\Controllers\TagController::class, 'update']);
    Route::delete('/admin/tags/{id}', [App\Http\Controllers\TagController::class, 'delete']);

    Route::post('/slots/force-invite/{regis_id}', [App\Http\Controllers\SlotController::class, 'forceInvite'])->middleware('can:create_invite');
    Route::get('/slots/{event_id}', [App\Http\Controllers\SlotController::class, 'options'])->middleware('can:create_invite');

    Route::get('/my-events', [App\Http\Controllers\PartnerController::class, 'index']);
    Route::get('/my-events-history', [App\Http\Controllers\PartnerController::class, 'history']);

    Route::get('/{user_id}/{app_id}/{code}', [App\Http\Controllers\ManageController::class, 'view_registration'])->middleware('can:read_registration');

    Route::post('/webhooks/email_delivered',[WebhookController::class, 'emailDelivered']);
    Route::post('/webhooks/email_failed', [WebhookController::class,'emailFailed']);
});

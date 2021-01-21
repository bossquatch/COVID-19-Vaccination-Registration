<?php

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

Auth::routes([
    'register' => config('app.allow_self_service'),
    'verify' => true,
]);

Route::get('/not-supported', function() {
    return view('home.noie');
});

Route::group(["middleware" => "check.reset"], function() {
    Route::get('/', function () {
        return view('home.index');
    });

    Route::get('/faqs' , function() {
        return view('home.faqs');
    });

    Route::get('/privacy' , function() {
        return view('home.privacy');
    });

    Route::get('/terms' , function() {
        return view('home.terms');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home/register', [App\Http\Controllers\RegistrationController::class, 'submitRegistration']);
    Route::get('/edit', [App\Http\Controllers\RegistrationController::class, 'edit']);
    Route::post('/edit', [App\Http\Controllers\RegistrationController::class, 'update']);
    Route::delete('/home/delete', [App\Http\Controllers\RegistrationController::class, 'deleteRegistration']);

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
    Route::delete('/manage/delete/{regis_id}', [App\Http\Controllers\ManageController::class, 'delete'])->middleware('can:update_registration');

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

    Route::get('/admin/tags/{id}/edit', [App\Http\Controllers\TagController::class, 'edit']);
    Route::post('/admin/tags', [App\Http\Controllers\TagController::class, 'new']);
    Route::post('/admin/tags/sync', [App\Http\Controllers\TagController::class, 'sync']);
    Route::post('/admin/tags/{id}', [App\Http\Controllers\TagController::class, 'update']);
    Route::delete('/admin/tags/{id}', [App\Http\Controllers\TagController::class, 'delete']);

    Route::get('/{user_id}/{app_id}/{code}', [App\Http\Controllers\ManageController::class, 'view_registration'])->middleware('can:read_vaccine');
});

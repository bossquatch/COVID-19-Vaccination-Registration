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

    Route::get('/address/validate', [App\Http\Controllers\UspsController::class, 'validateInlineAddress']);

    Route::get('/manage', [App\Http\Controllers\ManageController::class, 'index']);
    Route::get('/manage/register', [App\Http\Controllers\ManageController::class, 'register']);
    Route::post('/manage/register', [App\Http\Controllers\ManageController::class, 'submitRegistration']);
    Route::get('/manage/searchName', [App\Http\Controllers\ManageController::class, 'searchName']);
    Route::get('/manage/searchAddr', [App\Http\Controllers\ManageController::class, 'searchAddr']);
    Route::get('/manage/searchRegis', [App\Http\Controllers\ManageController::class, 'searchRegis']);
    Route::get('/manage/searchCode', [App\Http\Controllers\ManageController::class, 'searchCode']);
    Route::get('/manage/qr', [App\Http\Controllers\ManageController::class, 'qrRead']);
    Route::get('/manage/edit/{regis_id}', [App\Http\Controllers\ManageController::class, 'edit']);
    Route::post('/manage/edit/{regis_id}', [App\Http\Controllers\ManageController::class, 'updateRegistration']);
    Route::post('/manage/forcereset', [App\Http\Controllers\ManageController::class, 'forceResetPassword']);

    Route::get('/sms/verify', [App\Http\Controllers\SmsVerificationController::class, 'show']);
    Route::post('/sms/verify', [App\Http\Controllers\SmsVerificationController::class, 'verify']);
    Route::post('/sms/resend', [App\Http\Controllers\SmsVerificationController::class, 'resend']);

    Route::get('/{user_id}/{app_id}/{code}', [App\Http\Controllers\ManageController::class, 'view_registration']);
});

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

Route::get('/', function () {
    return view('home.index');
});

Auth::routes([
    'verify' => true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/register', [App\Http\Controllers\RegistrationController::class, 'submitRegistration']);

Route::get('/address/validate', [App\Http\Controllers\UspsController::class, 'validateInlineAddress']);

Route::get('/manage', [App\Http\Controllers\ManageController::class, 'index']);
Route::get('/manage/searchName', [App\Http\Controllers\ManageController::class, 'searchName']);
Route::get('/manage/searchAddr', [App\Http\Controllers\ManageController::class, 'searchAddr']);
Route::get('/manage/searchRegis', [App\Http\Controllers\ManageController::class, 'searchRegis']);
Route::get('/manage/searchCode', [App\Http\Controllers\ManageController::class, 'searchCode']);

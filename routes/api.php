<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PayPalPaymentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

Route::get('tools',[HomeController::class,'tools']);
Route::get('partners',[HomeController::class,'partners']);
Route::get('single_partner/{id}',[HomeController::class,'single_partner']);
Route::get('single_tool/{id}',[HomeController::class,'sinlge_tool']);
Route::get('books',[HomeController::class,'books']);
Route::get('single_book/{id}',[HomeController::class,'single_book']);
Route::get('packages',[HomeController::class,'packages']);
Route::get('single_package/{id}',[HomeController::class,'single_package']);
Route::get('videos',[HomeController::class,'videos']);
Route::get('home_videos',[HomeController::class,'home_videos']);
Route::get('single_video/{id}',[HomeController::class,'single_video']);
Route::get('users',[HomeController::class,'users']);
Route::get('questions',[HomeController::class,'questions']);
Route::get('faqs', [HomeController::class, 'faqs']);
Route::post('mail_subscription',[HomeController::class,'mail_sub']);
Route::group(['middleware' => 'is_login'], function () {
    Route::get('logout',[UserController::class,'logout']);
    Route::get('profile',[UserController::class,'profile']);
    Route::post('update_profile',[UserController::class,'update_profile']);
    Route::post('update_password',[UserController::class,'update_password']);
});



Route::get('handle-payment', [PayPalPaymentController::class,'handlePayment'])->name('make.payment');
// 'PayPalPaymentController@handlePayment')->name('make.payment');

Route::get('cancel-payment', [PayPalPaymentController::class,'paymentCancel'])->name('cancel.payment');
Route::get('payment-success/{id}', [PayPalPaymentController::class,'paymentSuccess'])->name('success.payment');





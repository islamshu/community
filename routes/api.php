<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PayPalPaymentController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('add_pa',[HomeController::class,'testpc']);
Route::get('success_paid_url/{sub_id}',[UserController::class,'success_paid_url'])->name('success_paid_url');


Route::get('partners', [HomeController::class, 'partners']);
Route::get('single_partner/{id}', [HomeController::class, 'single_partner']);

Route::get('packages', [HomeController::class, 'packages']);
Route::get('single_package/{id}', [HomeController::class, 'single_package']);
Route::get('home_videos', [HomeController::class, 'home_videos']);
Route::get('users', [HomeController::class, 'users']);
Route::get('members', [HomeController::class, 'members']);
Route::get('questions', [HomeController::class, 'questions']);
Route::get('faqs', [HomeController::class, 'faqs']);
Route::post('mail_subscription', [HomeController::class, 'mail_sub']);
Route::get('/show_notification/{id}', [UserController::class, 'show_notification'])->name('show_notification');
Route::get('add_socail', [HomeController::class, 'add_socail']);
Route::get('avaliable_tabs', [HomeController::class, 'avaliable_tabs']);


Route::group(['middleware' => 'is_login'], function () {
    Route::post('checkout',[UserController::class,'pay_user']);
    Route::post('edit_soical',[UserController::class,'edit_soical']);

    
    Route::get('/my_notification', [UserController::class, 'my_notification'])->name('my_notification');
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('update_profile', [UserController::class, 'update_profile']);
    Route::post('update_password', [UserController::class, 'update_password']);
    Route::post('pay_user', [UserController::class, 'pay']);
    Route::post('pay_service', [UserController::class, 'pay_service']);

    Route::group(['middleware' => 'is_paid'], function () {


        Route::get('tools', [HomeController::class, 'tools']);
        
        Route::get('videos', [HomeController::class, 'videos']);
        Route::get('books', [HomeController::class, 'books']);
        Route::get('services', [HomeController::class, 'services']);
        Route::get('learning', [HomeController::class, 'learning']);
        Route::get('single_learning/{slug}', [HomeController::class, 'single_learning']);
        Route::get('single_service/{slug}', [HomeController::class, 'single_service']);
        Route::get('single_tool/{id}', [HomeController::class, 'sinlge_tool']);
        Route::get('single_book/{id}', [HomeController::class, 'single_book']);
        Route::get('single_video/{id}', [HomeController::class, 'single_video']);
    });
});



Route::get('handle-payment', [PayPalPaymentController::class, 'handlePayment'])->name('make.payment');
// 'PayPalPaymentController@handlePayment')->name('make.payment');

Route::get('cancel-payment', [PayPalPaymentController::class, 'paymentCancel'])->name('cancel.payment');
Route::get('payment-success/{id}', [PayPalPaymentController::class, 'paymentSuccess'])->name('success.payment');
Route::get('payment_success_service/{id}', [PayPalPaymentController::class, 'payment_success_service'])->name('success.payment_service');
Route::get('cancel_payment_service', [PayPalPaymentController::class, 'cancel_payment_service'])->name('cancel.payment_servicet');

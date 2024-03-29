<?php

use App\Http\Controllers\Api\BalanceUserController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PayPalPaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\StripeController;
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
Route::get('communityee', [HomeController::class, 'testapi']);
Route::get('edit_dsicount', [HomeController::class, 'edit_dsicount']);
Route::get('socail',[HomeController::class,'socail']);
Route::post('forget_email', [ForgotPasswordController::class, 'forgot']);
Route::post('reset_my_password', [ForgotPasswordController::class, 'reset'])->name('api_reset');
Route::post('register', [UserController::class, 'register']);
Route::post('check_user_register', [UserController::class, 'check_user_register']);
Route::post('login', [UserController::class, 'login']);
Route::get('add_pa',[HomeController::class,'testpc']);
Route::get('success_paid_url/{sub_id}',[UserController::class,'success_paid_url'])->name('success_paid_url');
Route::get('meeting_setting',[HomeController::class,'meeting_setting']);
Route::get('promocods',[UserController::class,'promocods']);
Route::get('currencies',[HomeController::class,'currencies']);
Route::get('payments',[HomeController::class,'payments']);
Route::get('payments_by_currencies/{id}',[HomeController::class,'payments_by_currencies']);


Route::get('visa_image',[HomeController::class,'visea_image']);
Route::get('bank_info_images',[HomeController::class,'bank_info_images']);

Route::get('my_affilite/{code}',[UserController::class, 'my_affilite'])->name('my_affilite');
Route::get('main_socail',[HomeController::class,'main_socail']);


Route::get('/profile-image/{name}',[UserController::class, 'user_profile'])->name('user_profile');
Route::get('/social-profile',[UserController::class, 'social_profile'])->name('social_profile');
Route::get('/social-profile/{id}',[UserController::class, 'social_profile_id'])->name('social_profile_id');

Route::get('partners', [HomeController::class, 'partners']);
Route::get('single_partner/{id}', [HomeController::class, 'single_partner']);

Route::get('packages', [HomeController::class, 'packages']);
Route::get('single_package/{id}', [HomeController::class, 'single_package']);
Route::get('home_videos', [HomeController::class, 'home_videos']);
Route::get('users', [HomeController::class, 'users']);
Route::get('users_home', [HomeController::class, 'users_home']);
Route::get('members', [HomeController::class, 'members']);
Route::get('questions', [HomeController::class, 'questions']);
Route::get('faqs', [HomeController::class, 'faqs']);
Route::get('setting', [HomeController::class, 'setting']);
Route::get('domains', [HomeController::class, 'domains']);

Route::post('mail_subscription', [HomeController::class, 'mail_sub']);
Route::get('/show_notification/{id}', [UserController::class, 'show_notification'])->name('show_notification');
Route::get('add_socail', [HomeController::class, 'add_socail']);
Route::get('avaliable_tabs', [HomeController::class, 'avaliable_tabs']);
Route::get('get_user/{id}', [HomeController::class, 'get_user']);
Route::post('payment-strip', [StripeController::class, 'processPayment']);

Route::get('get_statistic_for_balance',[UserController::class,'get_statistic_for_balance']);
Route::get('get_all_videos_from_community/{id}', [HomeController::class, 'get_all_videos_from_community']);
Route::get('all_message_between_user/{id}/{id2}', [MessageController::class, 'message_betwwen_2'])->name('message_two');
Route::get('blogs',[HomeController::class,'blogs']);
Route::get('single_blog/{slug}', [HomeController::class, 'single_blog']);
Route::group(['middleware' => 'is_login'], function () {
    
    Route::post('renow_sub', [UserController::class, 'renow_sub']);
    Route::post('applay_promocode', [UserController::class, 'applay_promocode']);
    Route::get('chack_if_able_to_renew', [UserController::class, 'chack_if_able_to_renew']);

    
    Route::get('chat_count',[MessageController::class,'get_count']);
    Route::post('/send_messsage', [MessageController::class, 'store']);
    Route::get('/all_message', [MessageController::class, 'index']);
    Route::get('statistic', [UserController::class, 'statistic']);
    Route::post('store_new_socail', [UserController::class, 'store_new_socail']);
    Route::post('edit_new_social/{id}', [UserController::class, 'edit_new_social']);
    Route::post('delete_soical/{id}', [UserController::class, 'delete_soical']);
    Route::get('main_info_for_user', [UserController::class, 'main_info_for_user']);
    Route::get('main_statisctic',[UserController::class,'user_staticsta']);
    Route::post('payment_request', [BalanceUserController::class, 'payment_request']);
    Route::get('all_payment_request', [BalanceUserController::class, 'all_payment_request']);
    Route::get('single_payment_request/{id}', [BalanceUserController::class, 'single_payment_request']);
    Route::post('notify_me/{id}', [HomeController::class, 'notify_me']);
    Route::get('avaliable_tabs', [HomeController::class, 'avaliable_tabs']);
    Route::get('subscription', [UserController::class, 'subscription'])->name('subscription');
    Route::get('get_subscription_by_id/{id}', [UserController::class, 'get_subscription_by_id'])->name('get_subscription_by_id');
    Route::post('set_bank_info',[UserController::class,'set_bank_info']);
    Route::get('afflite_info',[UserController::class,'afflite_info']);
    Route::post('checkout',[UserController::class,'pay_user']);
    Route::post('edit_soical',[UserController::class,'edit_soical']);
    Route::get('/my_notification', [UserController::class, 'my_notification'])->name('my_notification');
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('update_profile', [UserController::class, 'update_profile']);
    Route::post('update_image', [UserController::class, 'update_image']);
    Route::post('update_password', [UserController::class, 'update_password']);
    Route::post('pay_user', [UserController::class, 'pay']);
    Route::post('pay_service', [UserController::class, 'pay_service']);
    Route::post('add_email_to_data', [HomeController::class, 'add_email_to_data']);
    Route::get('get_all_invoice', [UserController::class, 'get_all_invoice']);

    Route::group(['middleware' => 'is_paid'], function () {
        Route::get('tools', [HomeController::class, 'tools']);
        Route::get('videos', [HomeController::class, 'videos']);
        Route::get('books', [HomeController::class, 'books']);
        Route::get('services', [HomeController::class, 'services']);
        Route::get('learning', [HomeController::class, 'learning']);

        Route::get('single_service/{slug}', [HomeController::class, 'single_service']);
        Route::get('single_tool/{id}', [HomeController::class, 'sinlge_tool']);
        Route::get('single_book/{id}', [HomeController::class, 'single_book']);
        Route::get('single_video/{id}', [HomeController::class, 'single_video']);
        Route::get('community', [HomeController::class, 'community']);
        Route::get('single_community/{id}', [HomeController::class, 'single_community']);

        
    });
});
Route::get('handle-payment', [PayPalPaymentController::class, 'handlePayment'])->name('make.payment');
// 'PayPalPaymentController@handlePayment')->name('make.payment');
Route::get('cancel-payment', [PayPalPaymentController::class, 'paymentCancel'])->name('cancel.payment');
Route::get('payment-success/{id}', [PayPalPaymentController::class, 'paymentSuccess'])->name('success.payment');
Route::get('payment_success_service/{id}', [PayPalPaymentController::class, 'payment_success_service'])->name('success.payment_service');
Route::get('cancel_payment_service', [PayPalPaymentController::class, 'cancel_payment_service'])->name('cancel.payment_servicet');


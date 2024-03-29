<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BalaceRequestController;
use App\Http\Controllers\BankInfoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CurrencieController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\DiscountPackageController;
use App\Http\Controllers\DomiansController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuastionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserVideosController;
use App\Http\Controllers\VideoController;
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
    return view('layouts.subscribe');
});


Route::get('viewPdf/{code}',[UserController::class,'viewPdf'])->name('viewPdf');
Route::get('viewPdf_claim/{code}',[ClaimController::class,'preview_pdf'])->name('viewPdf_claim');
Route::get('viewmail_claim/{code}',[ClaimController::class,'viewmail_claim'])->name('viewmail_claim');


Route::get('invoideviewPdf/{code}',[UserController::class,'invoideviewPdf'])->name('invoideviewPdf');
Route::get('get_payment/{ID}',[PaymentController::class,'get_payment'])->name('get_payment');




Route::post('register_email',[HomeController::class,'register_email'])->name('register_email')->middleware('crs_chek');
Route::get('return_users',[HomeController::class,'get_users']);
Route::get('login',[HomeController::class,'login_admin'])->name('login');
Route::post('login',[HomeController::class,'post_login_admin'])->name('post_login_admin');
Route::get('ref_code',[HomeController::class,'ref_code'])->name('ref_code');
Route::get('verify_email/{id}',[UserController::class,'verfty_email'])->name('send_email.verfy');
Route::get('get-interested-modal',[ReportController::class,'get_interested_modal'])->name('get_interested_modal');
Route::post('updated_status_call_center',[ReportController::class,'updated_status'])->name('updated_status_call_center');
Route::get('get-negotiated-modal',[ReportController::class,'get_negotiated_modal'])->name('get_negotiated_modal');
Route::get('send_data_not_answer',[ReportController::class,'send_data_not_answer'])->name('send_data_not_answer');
Route::get('get_info_modal',[ReportController::class,'get_info_modal'])->name('get_info_modal');



Route::group(['middleware' => ['auth:admin'], 'prefix' => 'dashboard'], function () {
    Route::get('notifications', 'NotificationController@index')->name('admin.notifications');
    Route::post('notifications/mark-as-read', 'NotificationController@markAsRead')->name('admin.notifications.mark-as-read');

    Route::get('/',[HomeController::class,'index'] )->name('dashboard');
    Route::resource('packages', PackageController::class);
    Route::resource('domians', DomiansController::class);
    Route::resource('members', MemberController::class);
    Route::resource('roles', RoleController::class);
    Route::get('reports/unpaid', [ReportController::class,'unpaid'])->name('unpaid_reports');
    Route::get('reports/paid', [ReportController::class,'paid'])->name('paid_reports');
    Route::get('currencies.update.status', [CurrencieController::class,'updated_status'])->name('currencies.update.status');
    Route::get('payments.update.status', [PaymentController::class,'updated_status'])->name('payments.update.status');
    Route::get('packge.update.status', [PackageController::class,'updated_status'])->name('packge.update.status');

    
    Route::resource('currencies',CurrencieController::class);
    Route::resource('payments',PaymentController::class);

    

    Route::get('show_bank_info/{id}', [UserController::class,'show_bank_info'])->name('show_bank_info');
    Route::get('withdrow_request/{id}', [BalaceRequestController::class,'withdrow_request'])->name('withdrow_request');
    Route::get('all_withdrow_request', [BalaceRequestController::class,'index'])->name('all_withdrow_request');
    Route::get('get_price_for_packge', [HomeController::class,'get_price_for_packge'])->name('get_price_for_packge');
    Route::get('get_discount_code', [HomeController::class,'get_discount_code'])->name('get_discount_code');

    

    
    Route::get('show_noti/{id}', [UserController::class,'show_noti'])->name('show_noti');

    Route::post('change_status/{id}', [UserController::class,'change_status'])->name('change_status');
    Route::post('change_status_payment/{id}', [UserController::class,'change_status_payment'])->name('change_status_payment');

    
    Route::resource('communites', CommunityController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('books', BookController::class);
    Route::resource('videos', VideoController::class);
    Route::get('BaksInfo', [BankInfoController::class,'all'])->name('bank_info');

    Route::get('videos_update_status', [VideoController::class,'videos_update_status'])->name('video.update.status');
    Route::get('user_update_status', [UserController::class,'user_update_status'])->name('user.update.status');
    Route::resource('tools', ToolController::class);
    Route::get('logout',[HomeController::class,'logout'])->name('logout');
    Route::get('profile',[HomeController::class,'profile'])->name('profile');
    Route::post('update_profile',[HomeController::class,'update_profile'])->name('update_profile');
    Route::resource('quastions', QuastionController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('faqs', FaqsController::class);
    Route::resource('usersVideo', UserVideosController::class);
    Route::resource('packageDiscount', DiscountPackageController::class);
    Route::post('update_sort_faqs', [FaqsController::class, 'update_sort_faqs'])->name('update_sort_faqs');
    Route::resource('users',UserController::class);
    Route::resource('invoices',InvoiceController::class);
    Route::resource('invoices',InvoiceController::class);
    Route::delete('delete-multiple-invoice',[InvoiceController::class,'deleteMultiple'])->name('delete-multiple-invoice');
    Route::get('get_image/{id}',[BlogController::class,'get_image'])->name("get_image");
    Route::post('update_data_image',[BlogController::class,'update_data_image'])->name("update_data_image");
    Route::post('upload_image',[BlogController::class,'upload'])->name("upload_image");
    // Route::resource('blogs',BlogController::class);
    Route::get('blogs',[BlogController::class,'get_blogs'])->name("get_blogs");
    Route::get('show_blog/{slug}',[BlogController::class,'show_blog'])->name("show_blog");

    
    

    Route::resource('claims',ClaimController::class);
    Route::get('payment_with_curreany',[ClaimController::class,'payment_with_curreany'])->name('payment_with_curreany');

    Route::get('resend_email/{id}',[ClaimController::class,'resend_mail'])->name('resend_mail');

    
    Route::resource('discountcode',DiscountCodeController::class);
    Route::get('show_message_from_user/{id}/{id2}',[UserController::class,'show_message_from_user'])->name('show_message_from_user');

    
    Route::get('paid_users', [UserController::class, 'paid_user'])->name('users_paid.index');
    Route::get('video_setting', [HomeController::class, 'video_setting'])->name('video_setting');
    Route::get('meeting_setting', [HomeController::class, 'meeting_setting'])->name('meeting_setting');
    Route::get('member_setting', [HomeController::class, 'member_setting'])->name('member_setting');

    Route::get('setting', [HomeController::class, 'setting'])->name('setting');
    Route::get('social', [HomeController::class, 'social'])->name('social');

    
    Route::post('get_user_video', [VideoController::class, 'get_user_video'])->name('get_user_video');
    Route::post('add_general', [UserController::class, 'add_general'])->name('add_general');
    Route::post('add_general_meeting', [UserController::class, 'add_general_meeting'])->name('add_general_meeting');

    Route::get('tabs', function(){
        return view('dashboard.tabs');
    })->name('tabs');

    Route::get('unpaid_users', [UserController::class, 'un_paid_user'])->name('un_paid_user.index');
    Route::get('free_users', [UserController::class, 'free_users'])->name('free_users.index');
});



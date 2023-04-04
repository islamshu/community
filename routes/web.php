<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\QuastionController;
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
Route::post('register_email',[HomeController::class,'register_email'])->name('register_email');



Route::get('/dashboard', function () {
    return view('layouts.backend');
})->name('dashboard');
Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('packages', PackageController::class);
    Route::resource('members', MemberController::class);
    Route::resource('books', BookController::class);
    Route::resource('videos', VideoController::class);
    Route::get('videos_update_status', [VideoController::class,'videos_update_status'])->name('video.update.status');
    Route::get('user_update_status', [UserController::class,'user_update_status'])->name('user.update.status');
    Route::resource('tools', ToolController::class);
    Route::resource('quastions', QuastionController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('faqs', FaqsController::class);
    Route::resource('usersVideo', UserVideosController::class);

    
    Route::post('update_sort_faqs', [FaqsController::class, 'update_sort_faqs'])->name('update_sort_faqs');
    Route::resource('users',UserController::class);
    Route::get('paid_users', [UserController::class, 'paid_user'])->name('users_paid.index');
    Route::get('video_setting', [HomeController::class, 'video_setting'])->name('video_setting');

    Route::post('get_user_video', [VideoController::class, 'get_user_video'])->name('get_user_video');
    Route::post('add_general', [UserController::class, 'add_general'])->name('add_general');
    
    Route::get('tabs', function(){
        return view('dashboard.tabs');
    })->name('tabs');

    Route::get('unpaid_users', [UserController::class, 'un_paid_user'])->name('un_paid_user.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

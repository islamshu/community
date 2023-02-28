<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\QuastionController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('layouts.backend');
})->name('dashboard');
Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('packages', PackageController::class);
    Route::resource('books', BookController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('tools', ToolController::class);
    Route::resource('quastions', QuastionController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('faqs', FaqsController::class);
    Route::post('update_sort_faqs', [FaqsController::class, 'update_sort_faqs'])->name('update_sort_faqs');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('paid_users', [UserController::class, 'paid_user'])->name('users_paid.index');
    Route::get('unpaid_users', [UserController::class, 'un_paid_user'])->name('un_paid_user.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

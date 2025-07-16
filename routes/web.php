<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\Admin\AdminLoginController;
Use App\Http\Controllers\Admin\AdminUserController;
Use App\Http\Controllers\Admin\NewsController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin url
Route::group(["prefix" =>"admin", "middleware" => ["isClientUserLogin"]], function () {
    Route::get('/login', [AdminLoginController::class, 'Login'])->name('admin_login');
    Route::post('/login-success', [AdminLoginController::class, 'LoginSuccess'])->name('admin_login_success');
    Route::get('/logout', [AdminLoginController::class, 'Logout'])->name('admin_logout');
    Route::get('/admin-forgot-password', [AdminUserController::class, 'forgotPassword'])->name('admin_forgot_password');
    Route::post('/admin-forgot-password-success', [AdminUserController::class, 'forgotPasswordSuccess'])->name('admin_forgot_password_success');



    /**
     *  category crud
     */
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news_create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news_store');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news_edit');
    Route::post('/news/update', [NewsController::class, 'update'])->name('news_update');
    Route::get('/news/{id}/delete', [NewsController::class, 'destroy'])->name('news_delete');
    Route::get('/news/import', [NewsController::class, 'import'])->name('news_import');
    Route::post('/news/import_success', [NewsController::class, 'importSuccess'])->name('news_import_success');

    /**
     *  admin user crud
     */
    Route::get('/admin-user', [AdminUserController::class, 'index'])->name('admin');
    Route::get('/admin-user/create', [AdminUserController::class, 'create'])->name('admin_create');
    Route::post('/admin-user/store', [AdminUserController::class, 'store'])->name('admin_store');
    Route::get('/admin-user/{id}', [AdminUserController::class, 'show'])->name('admin_show');
    Route::get('/admin-user/{id}/edit', [AdminUserController::class, 'edit'])->name('admin_edit');
    Route::post('/admin-user/update', [AdminUserController::class, 'update'])->name('admin_update');
    Route::get('/admin-user/{id}/delete', [AdminUserController::class, 'destroy'])->name('admin_delete');

    Route::get('/admin-reset-password', [AdminUserController::class, 'resetPassword'])->name('admin_reset_password');
    Route::post('/admin-reset-password-success', [AdminUserController::class, 'resetPasswordSuccess'])->name('admin_reset_password_success');


});
URL::forceScheme('https');
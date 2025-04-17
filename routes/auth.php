<?php

use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Authentication related routes.
|
*/

// Public User authentication routes.
Auth::routes();

// User authentication routes.
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'guest'], function () {
    // Login Routes.
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

    // Forget Password Routes.
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset/submit', [ForgotPasswordController::class, 'reset'])->name('password.update');

});

// Authenticated routes.
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Logout Routes.
    Route::post('/logout/submit', [LoginController::class, 'logout'])->name('logout.submit');
});
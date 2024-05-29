<?php

use App\Http\Controllers\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::middleware('auth:admin')->group(function(){
        Route::post('logout','logout');
        Route::get('refresh','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
        Route::get('/notifications','getAllNotificaitons');
        Route::get('/notifications-unread','getAllNotificaitonsUnread');
        Route::get('/notifications-mark','markNotificationsAsRead');
    });
});

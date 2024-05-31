<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\NotesController;
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


Route::middleware('auth:admin')->group(function(){
    Route::controller(NotesController::class)->prefix('notes')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{adminNoteId}','show');
        Route::post('/{adminNoteId}','update');
        Route::delete('/{adminNoteId}','destory');
    });


});

Route::middleware(['auth:admin','role:owner'])->group(function(){
    Route::controller(ManagerController::class)->prefix('managers')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{managerId}','show');
        Route::post('/{managerId}','update');
        Route::delete('/{managerId}','destory');
    });
});

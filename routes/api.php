<?php

use App\Http\Controllers\Website\AuthStudentController;
use App\Http\Controllers\Website\AuthTeacherController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\Student\StudentNoteController;
use App\Http\Controllers\Website\Teacher\TeacherNoteController;
use App\Models\TeacherNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthStudentController::class)->prefix('students')->group(function(){
    Route::post('/register','register');
    Route::get('/verify/{token}','verifyAccount');
    Route::post('/login','login');

    Route::post('/sendmail','sendEmail');
    Route::post('/verify-token','verifyToken');
    Route::post('/reset-password','resetPassword');

    Route::middleware('auth:api')->group(function(){
        Route::post('/logout','logout');
    });
});

Route::controller(AuthTeacherController::class)->prefix('teachers')->group(function(){
    Route::post('/register','register');
    Route::get('/verify/{token}','verifyAccount');
    Route::post('/login','login');

    Route::post('/sendmail','sendEmail');
    Route::post('/verify-token','verifyToken');
    Route::post('/reset-password','resetPassword');

    Route::middleware('auth:teacher')->group(function(){
        Route::post('/logout','logout');
    });
});


Route::controller(HomeController::class)->group(function(){
    Route::get('/student-plan','getStudentPlans');
    Route::get('/teacher-plan','getTeacherPlans');
});


Route::middleware('auth:teacher')->prefix('teachers')->group(function(){
    Route::controller(TeacherNoteController::class)->prefix('notes')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{teacherNoteId}','show');
        Route::post('/{teacherNoteId}','update');
        Route::delete('/{teacherNoteId}','destory');
    });
});

Route::middleware('auth:api')->prefix('students')->group(function(){
    //
    Route::controller(StudentNoteController::class)->prefix('notes')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{noteId}','show');
        Route::post('/{noteId}','update');
        Route::delete('/{noteId}','destory');
    });
});

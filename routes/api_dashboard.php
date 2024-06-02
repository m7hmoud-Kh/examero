<?php

use App\Http\Controllers\Dashboard\AdminPointController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\NotesController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SupervisorController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\TeacherPointController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
});

Route::controller(ProfileController::class)->group(function(){
    Route::middleware('auth:admin')->group(function(){
        Route::post('logout','logout');
        Route::get('refresh','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
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

    Route::controller(TeacherController::class)->prefix('teachers')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{teacherId}','show');
        Route::post('/{teacherId}','update');
        Route::delete('/{teacherId}','destory');
    });

    Route::controller(StudentController::class)->prefix('students')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{studentId}','show');
        Route::post('/{studentId}','update');
        Route::delete('/{studentId}','destory');

    });

});



Route::middleware(['auth:admin','role:owner|manager'])->group(function(){
    Route::controller(SupervisorController::class)->prefix('supervisors')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{supervisorId}','show');
        Route::post('/{supervisorId}','update');
        Route::delete('/{supervisorId}','destory');
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

    Route::controller(AdminPointController::class)->prefix('points')->group(function(){
        Route::get('/{role}','index');
        Route::post('/','store');
        Route::put('/','destory');
    });

    Route::controller(TeacherPointController::class)->prefix('teacher/points')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::put('/','destory');
    });

    Route::controller(PlanController::class)->prefix('plans')->group(function(){
        Route::get('/student','getStudentPlans');
        Route::get('/teacher','getTeacherPlans');

        Route::post('/','store');
        Route::get('/{planId}','show');
        Route::post('/{planId}','update');
        Route::delete('/{planId}','destory');
    });

});





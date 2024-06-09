<?php

use App\Http\Controllers\Dashboard\Exam\GroupController;
use App\Http\Controllers\Dashboard\Exam\LessonController;
use App\Http\Controllers\Dashboard\Exam\SubjectController;
use App\Http\Controllers\Dashboard\Exam\UnitController;
use App\Http\Controllers\Website\AuthStudentController;
use App\Http\Controllers\Website\AuthTeacherController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\Student\ExamController;
use App\Http\Controllers\Website\Student\PlanController;
use App\Http\Controllers\Website\Student\StudentNoteController;
use App\Http\Controllers\Website\Student\StudentProfileController;
use App\Http\Controllers\Website\Teacher\ExamController as TeacherExamController;
use App\Http\Controllers\Website\Teacher\OpenEmisController;
use App\Http\Controllers\Website\Teacher\QuestionController;
use App\Http\Controllers\Website\Teacher\TeacherNoteController;
use App\Http\Controllers\Website\Teacher\TeacherProfileController;
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
    Route::controller(TeacherNoteController::class)->prefix('notes')
    ->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{teacherNoteId}','show');
        Route::post('/{teacherNoteId}','update');
        Route::delete('/{teacherNoteId}','destory');
    });

    Route::controller(TeacherProfileController::class)
    ->group(function(){
        Route::get('refresh','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
    });

    Route::controller(OpenEmisController::class)->prefix('open-emis')
    ->group(function(){
        Route::get('/','index');
        Route::get('/{openEmisId}','show');
        Route::post('/','store');
        Route::post('/{openEmisId}','update');
        Route::delete('/{openEmisId}','destory');
    });

    Route::controller(QuestionController::class)->prefix('questions')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{questionId}','show');
        Route::post('/{questionId}','update');
        Route::delete('/{questionId}','destory');
    });

    Route::controller(TeacherExamController::class)->group(function(){
        Route::post('genrate-exam','generateExam')->middleware('ExamBlanacePointCheck');
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

    Route::controller(StudentProfileController::class)->group(function(){
        Route::get('refresh','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
    });

    Route::controller(ExamController::class)->group(function(){
        Route::post('/genrate-exam','generateExam')->middleware('StudentSubscribe');
        Route::post('/submit-exam','submitExam');
        Route::get('/exams','getAllExams');
        Route::get('/exams-info','getSomeInfo');
    });

    Route::controller(PlanController::class)->prefix('plans')->group(function(){
        Route::get('/','getAllSubscribePlan');
    });
    Route::get('groups/selection',[GroupController::class,'showGroupInSelection']);
    Route::get('subjects/selection/{groupId}',[SubjectController::class,'showSubjectInSelection']);
    Route::get('units/selection/{subjectId}',[UnitController::class,'showUnitInSelection']);
    Route::get('lessons/selection/{unitId}',[LessonController::class,'showLessonInSelection']);


});

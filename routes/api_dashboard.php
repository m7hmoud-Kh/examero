<?php

use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\AdminPointController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CertificateController;
use App\Http\Controllers\Dashboard\Exam\GroupController;
use App\Http\Controllers\Dashboard\Exam\LessonController;
use App\Http\Controllers\Dashboard\Exam\QuestionController;
use App\Http\Controllers\Dashboard\Exam\QuestionTypeController;
use App\Http\Controllers\Dashboard\Exam\SubjectController;
use App\Http\Controllers\Dashboard\Exam\UnitController;
use App\Http\Controllers\Dashboard\ExamServiceController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\NotesController;
use App\Http\Controllers\Dashboard\OpenEmisController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SpecificationController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SupervisorController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\TeacherPointController;
use App\Http\Controllers\Website\Student\ExamController;
use App\Http\Controllers\Website\Teacher\ExamController as TeacherExamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('/sendmail','sendEmail');
    Route::post('/verify-token','verifyToken');
    Route::post('/reset-password','resetPassword');

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

    Route::controller(HomeController::class)->group(function(){
        Route::get('/show-info','showInfo');
    });
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
        Route::get('/selection','showTeacherInSelection');
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

    Route::controller(GroupController::class)->prefix('groups')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/selection','showGroupInSelection');
        Route::get('/{groupId}','show');
        Route::post('/{groupId}','update');
        Route::delete('/{groupId}','destory');
    });


    Route::controller(SubjectController::class)->prefix('subjects')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/selection/{groupId}','showSubjectInSelection');
        Route::get('/{subjectId}','show');
        Route::post('/{subjectId}','update');
        Route::delete('/{subjectId}','destory');
    });

    Route::controller(UnitController::class)->prefix('units')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/selection/{subjectId}','showUnitInSelection');
        Route::get('/{unitId}','show');
        Route::post('/{unitId}','update');
        Route::delete('/{unitId}','destory');
    });

    Route::controller(LessonController::class)->prefix('lessons')->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/selection/{unitId}','showLessonInSelection');
        Route::get('/{lessonId}','show');
        Route::post('/{lessonId}','update');
        Route::delete('/{lessonId}','destory');
    });


    Route::controller(QuestionTypeController::class)->prefix('questions-type')
    ->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/selection','showQuestionsTypeInSelection');
        Route::get('/{questionTypeId}','show');
        Route::post('/{questionTypeId}','update');
        Route::delete('/{questionTypeId}','destory');
    });

    Route::controller(QuestionController::class)->prefix('questions')
    ->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{questionId}','show');
        Route::post('/{questionId}','update');
        Route::delete('/{questionId}','destory');
    });


    Route::controller(OpenEmisController::class)->prefix('open-emis')
    ->group(function(){
        Route::get('/','index');
        Route::get('/{openEmisId}','show');
        Route::post('/{openEmisId}','update');
        Route::put('/','destory');
    });


    Route::post('questions-by-main-question',[TeacherExamController::class,'getAllQuestionsById']);


    Route::controller(CertificateController::class)->group(function(){
        Route::post('/certificate','makeCertificate')->middleware('CheckPointInCertificate',);
    });

    Route::controller(OpenEmisController::class)->prefix('open-emis')
    ->group(function(){
        Route::post('/','store')->middleware('CheckPointInOpenEmis');
    });

    Route::controller(SpecificationController::class)->group(function(){
        Route::post('/specification','makeSpecification')->middleware('CheckPointInSpecification',);
    });


});



Route::middleware(['auth:admin','role:owner|manager'])->group(function(){
    Route::controller(SupervisorController::class)->prefix('supervisors')
    ->group(function(){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{supervisorId}','show');
        Route::post('/{supervisorId}','update');
        Route::delete('/{supervisorId}','destory');
    });

    Route::controller(ActivityLogController::class)->prefix('activity')
    ->group(function(){
        Route::get('/supervisor','getActivitySupervisor');
        Route::put('/','destory');
    });

});

Route::middleware(['auth:admin','role:supervisor|manager'])->group(function(){
    Route::controller(AdminPointController::class)->prefix('points')->group(function(){
        Route::get('/my-point','myPoints');
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
        Route::get('/{teacherId}/teacher','getAllPlanSubscribeByTeacherId');
        Route::post('/','store');
        Route::get('/{planId}','show');
        Route::post('/{planId}','update');
        Route::delete('/{planId}','destory');
    });

    Route::controller(ExamServiceController::class)->group(function(){
        Route::post('genrate-exam','generateExam')
        ->middleware('ExamBlanacePointCheck');
        Route::post('save-exam','saveExam')
        ->middleware(['ExamBlanacePointCheck','CheckAboutMaximumQuestion']);
        Route::post('store-exam-info','saveInfoExam');
    });

    Route::controller(ActivityLogController::class)->prefix('activity')
    ->group(function(){
        Route::get('/','index');
        Route::get('/manager','getActivityManager');
    });

});






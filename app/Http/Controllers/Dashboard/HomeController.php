<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Question\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Exam;
use App\Models\OpenEmis;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function showInfo()
    {
        $exams = Exam::count();
        $acceptQuestions = Question::where('status',QuestionStatus::ACCPTED->value)->count();
        $rejectQuestions = Question::where('status',QuestionStatus::REJECTED->value)->count();
        $openEmis = OpenEmis::count();
        $totalManager = Admin::role('manager')->count();
        $totalSupervisor = Admin::role('supervisor')->count();
        $totalTeacher = Teacher::count();
        $totalStudent = User::count();

        return response()->json([
            'data' => [
                'exams' => $exams,
                'acceptQuestion' => $acceptQuestions,
                'rejectQuestion' => $rejectQuestions,
                'openEmis' => $openEmis,
                'manager' => $totalManager,
                'supervisor' => $totalSupervisor,
                'teacher' => $totalTeacher,
                'student' => $totalStudent
            ]
        ]);

    }
}

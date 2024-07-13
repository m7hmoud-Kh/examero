<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\Question\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TeacherPlan;
use App\Models\TeacherPlanDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function getSomeInfoStat()
    {
        $allPoint = TeacherPlan::where('teacher_id',Auth::user('teacher')->id)->sum('points');
        $allTeacherPlanIds= TeacherPlan::where('teacher_id',Auth::user('teacher')->id)->get()->pluck('id');
        $allPointUsed = TeacherPlanDetails::whereIn('teacher_plans_id',$allTeacherPlanIds)->sum('point');
        $allPointReminder =  $allPoint - $allPointUsed;
        $acceptQuestions = Question::where('status',QuestionStatus::ACCPTED->value)->whereHas('teacherQuestion',function($q){
            return $q->where('teacher_id',Auth::user('teacher')->id);
        })->count();
        $rejectQuestions = Question::where('status',QuestionStatus::REJECTED->value)->whereHas('teacherQuestion',function($q){
            return $q->where('teacher_id',Auth::user('teacher')->id);
        })->count();
        return response()->json([
            'message' => 'OK',
            'data' => [
                'allPoint' => $allPoint,
                'allPointUsed' => $allPointUsed,
                'allPointReminder' => $allPointReminder,
                'acceptedQuestion' => $acceptQuestions,
                'rejectQuestion' => $rejectQuestions
            ]
        ]);
    }
}

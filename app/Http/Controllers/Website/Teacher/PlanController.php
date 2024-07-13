<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\TeacherPoint;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Teacher\Plan\StorePlanSubscribeRequest;
use App\Http\Resources\TeacherPlanResource;
use App\Models\Plan;
use App\Models\TeacherPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /***
     * get all plan teacher auth subscribe in it
     */
    public function index()
    {
        $allTeacherPlans = TeacherPlan::where('teacher_id',Auth::guard('teacher')->user()->id)->with('plan')->Status()->get();
        return response()->json([
            'message' => "Ok",
            'data' => TeacherPlanResource::collection($allTeacherPlans)
        ]);
    }

    public function getAllPlansSubscibewithDetailsPoints()
    {
        $allTeacherPlans = TeacherPlan::where('teacher_id',Auth::guard('teacher')->user()->id)->with(['plan','details'])->get();
        $allTeacherPlans->each(function ($teacherPlan) {
            $teacherPlan->point_used = $teacherPlan->details->sum('point');
        });
        return response()->json([
            'message' => "Ok",
            'data' => TeacherPlanResource::collection($allTeacherPlans)
        ]);
    }

    //todo must be paid with payment method with price in plan
    //todo must be assign number of question with point in plan
    public function subscribeWithTeacher(StorePlanSubscribeRequest $request)
    {
        $plan = Plan::whereId($request->plan_id)
                ->where('for_student',false)
                ->first();
        if($plan){
            $teacherPlan = TeacherPlan::create([
                'plan_id' =>  $request->plan_id,
                'teacher_id' => Auth::guard('teacher')->user()->id,
                'points' => $plan->allow_exam * TeacherPoint::EXAM->value
            ]);

            return response()->json([
                'message' => 'Created',
                'teacherPlan' => new TeacherPlanResource($teacherPlan)
            ],Response::HTTP_CREATED);
        }

        return response()->json([
            'message' => 'Not Found'
        ],Response::HTTP_NOT_FOUND);
    }
}

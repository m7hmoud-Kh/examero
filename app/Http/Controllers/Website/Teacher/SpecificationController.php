<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\TeacherPoint;
use App\Enums\TeacherServicesType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Teacher\PlanServiceRequest;
use App\Models\Teacher;
use App\Models\TeacherPlanDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SpecificationController extends Controller
{

    public function makeSpecification(PlanServiceRequest $request)
    {
        if($request->plan_id){
            TeacherPlanDetails::create([
                'teacher_plans_id' => $request->teacher_plans_id,
                'type' => TeacherServicesType::SPECIFICATION->value,
                'point' =>  TeacherPoint::SPECIFICATION->value
            ]);
        }else{
            $teacher = Teacher::find(Auth::guard('teacher')->user()->id);
            $teacher->update([
                'rewarded_point' => $teacher->rewarded_point - TeacherPoint::SPECIFICATION->value
            ]);
        }

        return response()->json([
            'message' => 'Specification Created Successfully'
        ],Response::HTTP_CREATED);
    }
}

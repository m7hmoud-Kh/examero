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

class CertificateController extends Controller
{
    
    public function makeCertificate(PlanServiceRequest $request)
    {
        if($request->plan_id){
            TeacherPlanDetails::create([
                'teacher_plans_id' => $request->teacher_plans_id,
                'type' => TeacherServicesType::CERTIFICATE->value,
                'point' =>  TeacherPoint::CERTIFICATE->value
            ]);
        }else{
            $teacher = Teacher::find(Auth::guard('teacher')->user()->id);
            $teacher->update([
                'rewarded_point' => $teacher->rewarded_point - TeacherPoint::CERTIFICATE->value
            ]);
        }

        return response()->json([
            'message' => 'Certificate Created Successfully'
        ],Response::HTTP_CREATED);
    }
}

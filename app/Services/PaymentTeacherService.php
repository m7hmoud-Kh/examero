<?php

namespace App\Services;

use App\Enums\PaymentType;
use App\Enums\TeacherPoint;
use App\Models\Admin;
use App\Models\Plan;
use App\Models\TeacherPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;

class PaymentTeacherService
{
    public function storeTeacherPlan($planId, $paymentId, $type)
    {
        $plan = Plan::whereId($planId)
        ->where('for_student',false)
        ->first();

        TeacherPlan::create([
            'plan_id' =>  $planId,
            'teacher_id' => Auth::guard('teacher')->user()->id,
            'points' => $plan->allow_exam * TeacherPoint::EXAM->value,
            'payment_id' => $paymentId,
            'type' => $type,
        ]);

    }

  
}

<?php

namespace App\Services;

use App\Enums\PaymentType;
use App\Models\Admin;
use App\Models\Plan;
use App\Models\TeacherPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;

class PaymentStudentService
{
    public function storeStudentPlan($planId, $paymentId, $type)
    {
        $plan = Plan::whereId($planId)->first();
        $plan->users()->attach(Auth::user()->id,[
            'type' => $type,
            'payment_id' => $paymentId,
        ]);
    }

    public function verifyStudentPlan($paymentId)
    {
        DB::table('students_plans')
        ->where('user_id', Auth::user()->id)
        ->where('payment_id',$paymentId)
        ->update(['status' => true]);
    }

    public function verifyTeacherPlan($paymentId)
    {
        $teacherPlan = TeacherPlan::where('payment_id',$paymentId)->first();
        $teacherPlan->update([
            'status' => true
        ]);
    }
}

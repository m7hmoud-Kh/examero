<?php

namespace App\Http\Controllers\Website\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function getAllSubscribePlan()
    {
        $user = User::whereId(Auth::user()->id)->with('plans')->first();
        $plans = $user
        ->plans()
        ->where('students_plans.status',true)
        ->withPivot('exam_used')->get();

        return response()->json([
            'plans' => $plans
        ],Response::HTTP_OK);
    }

}

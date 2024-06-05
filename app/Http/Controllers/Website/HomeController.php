<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function getStudentPlans()
    {
        $plans = Plan::latest()
        ->where('for_student',true)
        ->Status()
        ->get();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => PlanResource::collection($plans),
        ]);

    }

    public function getTeacherPlans()
    {
        $plans = Plan::latest()->where('for_student',false)
        ->Status()
        ->get();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => PlanResource::collection($plans),
        ]);
    }

}

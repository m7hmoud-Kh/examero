<?php

namespace App\Http\Middleware;

use App\Enums\TeacherPoint;
use App\Models\Plan;
use App\Models\Teacher;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAboutMaximumQuestion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('teacher')->user()){
            $request->merge(['teacher_id' => Auth::guard('teacher')->user()->id]);
            $request->merge(['rewarded_point' => Auth::guard('teacher')->user()->rewarded_point]);
        }else{
            $teacher = Teacher::find($request->teacher_id);
            $request->merge(['rewarded_point' => $teacher->rewarded_point]);
        }

        if($request->plan_id)
        {
            $plan = Plan::whereId($request->plan_id)->Status()->where('for_student',false)->first();

            if($plan->allow_question >= count($request->questionIds)){
                return $next($request);
            }
        }elseif(
            $request->rewarded_point >= TeacherPoint::EXAM->value
            &&
            TeacherPoint::BASIC_QUESTION->value >= count($request->questionIds)
        ){
            return $next($request);
        }
        return response()->json([
            'message' => __('middleware.limitation_question')
        ],Response::HTTP_BAD_REQUEST);

    }
}

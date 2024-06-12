<?php

namespace App\Http\Middleware;

use App\Enums\TeacherPoint;
use App\Models\Plan;
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
        if($request->plan_id)
        {
            $plan = Plan::whereId($request->plan_id)->Status()->where('for_student',false)->first();

            if($plan->allow_question >= count($request->questionIds)){
                return $next($request);
            }
        }elseif(
            Auth::guard('teacher')->user()->rewarded_point >= TeacherPoint::EXAM->value
            &&
            TeacherPoint::BASIC_QUESTION->value >= count($request->questionIds)
        ){
            return $next($request);
        }
        return response()->json([
            'message' => 'You exceed limitation in questions'
        ],Response::HTTP_UNAUTHORIZED);

    }
}

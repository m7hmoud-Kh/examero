<?php

namespace App\Http\Middleware;

use App\Enums\TeacherPoint;
use App\Models\TeacherPlan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPointInOpenEmis
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->plan_id){
            $teacher = TeacherPlan::
            where('teacher_id',Auth::guard('teacher')->user()->id)
            ->where('plan_id',$request->plan_id)
            ->Status()
            ->withSum('details','point')
            ->first();

            if($teacher && $teacher->points == $teacher->details_sum_point){
                $teacher->update([
                    'status' => false,
                ]);
            }

            if($teacher && $teacher->points - $teacher->details_sum_point
            >= TeacherPoint::OPENEMIS->value)
            {
                $request->merge(['teacher_plans_id'=>$teacher->id]);
                return $next($request);
            }
        }elseif(Auth::guard('teacher')->user()->rewarded_point >= TeacherPoint::OPENEMIS->value){
            return $next($request);
        }
        return response()->json([
            'message' => "Your Balance Points is less than " . TeacherPoint::OPENEMIS->value,
        ],Response::HTTP_UNAUTHORIZED);
    }
}

<?php

namespace App\Http\Middleware;

use App\Enums\TeacherPoint;
use App\Models\Teacher;
use App\Models\TeacherPlan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPointInSpecification
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
        if($request->plan_id){
            $teacher = TeacherPlan::
            where('teacher_id',$request->teacher_id)
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
            >= TeacherPoint::SPECIFICATION->value)
            {
                $request->merge(['teacher_plans_id'=>$teacher->id]);
                return $next($request);
            }
        }elseif($request->rewarded_point >= TeacherPoint::SPECIFICATION->value){
            return $next($request);
        }
        return response()->json([
            'message' => "Your Balance Points is less than " . TeacherPoint::SPECIFICATION->value,
        ],Response::HTTP_BAD_REQUEST);
    }
}

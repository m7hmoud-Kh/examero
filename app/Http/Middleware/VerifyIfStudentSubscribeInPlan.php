<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyIfStudentSubscribeInPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::whereId(Auth::user()->id)->with('plans')->first();

        $planFound = $user
        ->plans()
        ->where('students_plans.status',true)
        ->where('students_plans.plan_id',$request->plan_id)
        ->withPivot('exam_used')->first();

        if($planFound && $planFound->allow_exam > $planFound->pivot->exam_used){
            return $next($request);
        }
        if($planFound){
            $planFound->pivot->update([
                'status' => false
            ]);
        }

        return response()->json([
            'message' => 'May be you finish all Exam in this plan'
        ],Response::HTTP_BAD_REQUEST);

    }
}

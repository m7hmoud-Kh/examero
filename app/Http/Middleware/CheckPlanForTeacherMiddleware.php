<?php

namespace App\Http\Middleware;

use App\Models\Plan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanForTeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $plan = Plan::whereId($request->plan_id)->Status()->where('for_student',false)->first();
        if($plan){
            $request->merge(['amount' => $plan->price]);
            return $next($request);
        }
        return response()->json([
            'message' => 'This is wrong with this plan maybe Not allowed to subscribe it'
        ],Response::HTTP_BAD_REQUEST);
    }
}

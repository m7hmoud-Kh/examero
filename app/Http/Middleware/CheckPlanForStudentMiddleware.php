<?php

namespace App\Http\Middleware;

use App\Models\Plan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanForStudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $plan = Plan::whereId($request->plan_id)->Status()->where('for_student',true)->first();
        if($plan){
            $request->merge(['amount' => $plan->price]);
            return $next($request);
        }
        return response()->json([
            'message' => __('middleware.forbidden_subscribe')
        ],Response::HTTP_BAD_REQUEST);
    }
}

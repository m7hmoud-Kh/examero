<?php

namespace App\Http\Middleware;

use App\Enums\TeacherPoint;
use App\Models\Teacher;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPointInExam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $teacher = Teacher::whereId(Auth::guard('teacher')->user()->id)->first();
        if($teacher->balance_points >= TeacherPoint::EXAM->value){
            return $next($request);
        }
        return response()->json([
            'message' => "Your Balance Points is less than " . TeacherPoint::EXAM->value,
        ],Response::HTTP_UNAUTHORIZED);
    }
}

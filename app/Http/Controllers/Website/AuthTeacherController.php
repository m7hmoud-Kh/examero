<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\ResetPasswordRequest;
use App\Http\Requests\Dashboard\Auth\VerfiyTokenRequest;
use App\Http\Requests\Dashboard\Teacher\StoreTeacherRequest;
use App\Http\Requests\Website\TeacherLoginRequest;
use App\Http\Requests\Website\TeacherRegisterRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Services\AuthService;
use App\Services\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthTeacherController extends Controller
{

    public $authService;
    public $forgetPassword;
    public function __construct(
        AuthService $authService,
        ForgetPassword $forgetPassword
    )
    {
        $this->authService = $authService;
        $this->forgetPassword = $forgetPassword;
    }
    public function login(TeacherLoginRequest $request)
    {
        $data = $this->authService->login($request,new Teacher(),'teacher');
        if(isset($data['token'])){
            return response()->json([
                'access_token' => $data['token'],
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 1000,
                'user' => new TeacherResource($data['instance'])
            ]);
        }else{
            return response()->json([
                'error' => $data['error'],
            ],$data['status']);
        }
    }

    public function register(TeacherRegisterRequest $request)
    {
        $this->authService->register($request->validated(),new Teacher());
        return response()->json([
            'message' => 'Teacher Register Successfully, please Check Your Email For Verification',
        ], Response::HTTP_CREATED);
    }

    public function verifyAccount($token)
    {
        if($this->authService->verifyAccount(new Teacher(),$token)){
            return response()->json([
                "message" => "Congrats You account is Verified 😎"
            ]);
        }
        return response()->json([
            "message" => "Token is Invalid",
        ],Response::HTTP_BAD_REQUEST);
    }


    public function sendEmail(Request $request)
    {
        return $this->forgetPassword->sendEmail($request,new Teacher());
    }

    public function verifyToken(VerfiyTokenRequest $request)
    {
        return $this->forgetPassword->verifyToken($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->forgetPassword->resetPassword($request, new Teacher());
    }

    public function logout()
    {
        $this->authService->logout('teacher');
        return response()->json([
            'message' => 'Teacher Successfully Logout'
        ]);
    }
}

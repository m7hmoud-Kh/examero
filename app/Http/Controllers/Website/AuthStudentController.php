<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\ResetPasswordRequest;
use App\Http\Requests\Dashboard\Auth\VerfiyTokenRequest;
use App\Http\Requests\Dashboard\Student\StoreStudentRequest;
use App\Http\Requests\Website\StudentLoginRequest;
use App\Http\Requests\Website\StudentRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthStudentController extends Controller
{
    public $authService;
    public $forgetPassword;
    public const STUDENTURL = 'verify-account-student';
    public function __construct(AuthService $authService, ForgetPassword $forgetPassword)
    {
        $this->authService =  $authService;
        $this->forgetPassword = $forgetPassword;
    }

    public function login(StudentLoginRequest $request)
    {
        $data = $this->authService->login($request,new User());
        if(isset($data['token'])){
            return response()->json([
                'access_token' => $data['token'],
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 1000,
                'user' => new UserResource($data['instance'])
            ]);
        }else{
            return response()->json([
                'error' => $data['error'],
            ],$data['status']);
        }
    }

    public function register(StudentRegisterRequest $request)
    {
        $this->authService->register($request->validated(), new User(),$this::STUDENTURL);
        return response()->json([
            'message' => 'Student Register Successfully, please Check Your Email For Verification',
        ], Response::HTTP_CREATED);
    }

    public function verifyAccount($token)
    {
        if($this->authService->verifyAccount(new User(),$token)){
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
        return $this->forgetPassword->sendEmail($request,new User());
    }

    public function verifyToken(VerfiyTokenRequest $request)
    {
        return $this->forgetPassword->verifyToken($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->forgetPassword->resetPassword($request, new User());
    }



    public function logout()
    {
        $this->authService->logout('api');
        return response()->json([
            'message' => 'Student Successfully Logout'
        ]);
    }

}

<?php

namespace App\Services;

use App\Http\Requests\Dashboard\Auth\ResetPasswordRequest;
use App\Http\Requests\Dashboard\Auth\VerfiyTokenRequest;
use App\Mail\ResetPasswordEmail;
use App\Models\ResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgetPassword
{
    public function sendEmail($request,Model $model)
    {
        $emailFound = $model::whereEmail($request->email)->first();
        if($emailFound){
            //get old token if found
            $oldToken = ResetPassword::whereEmail($request->email)->first();
            if($oldToken){
                $token = $oldToken->token;
            }else{
                $token = Str::random(8);
                ResetPassword::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);
            }

            Mail::to($request->email)->send(new ResetPasswordEmail([
                'email' => $request->email,
                'token' => $token,
            ]));
            return response()->json([
                'message' =>  __('services.mail_send')
            ]);
        }
        return response()->json([
            'error' => __('services.email_not_found')
        ], Response::HTTP_BAD_REQUEST);
    }

    public function verifyToken($request)
    {
        $passwordReset = ResetPassword::where('token',$request->token)->first();
        if($passwordReset){
            return response()->json([
                'message' => $passwordReset
            ]);
        }else{
            return response()->json([
                'message' => __('services.code_invalid')
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function resetPassword($request,Model $model)
    {
        $emailFound = $model::where('email',$request->email)->first();
        $passwordReset = ResetPassword::where('token',$request->token)->where('email',$request->email)->first();
        if($passwordReset && $emailFound){
            $emailFound->update([
                'password' => $request->password
            ]);
            $passwordReset->delete();
            return response()->json([
                'message' => __('services.password_updated')
            ]);
        }else{
            return response()->json([
                'message' => __('services.invalid_data'),
            ]);
        }
    }
}

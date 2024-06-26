<?php

namespace App\Services;

use App\Mail\MailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    public function register($request,Model $model, $url)
    {
        $token = $this->generateToken();
        $instance =  $model::create(array_merge($request,['remember_token'=>$token]));
        $this->sendMail($instance->email,$instance, $url);
    }

    public function verifyAccount(Model $model,$token)
    {
        $instance = $model::where('remember_token',$token)->whereNULL('email_verified_at')->first();
        if($instance){
            $instance->update([
                'remember_token' => null,
                'email_verified_at' => Carbon::now()
            ]);
            return true;
        }
        return false;
    }


    public function login($request, Model $model, $guard = 'api')
    {
        if (!$token = auth($guard)->attempt($request->validated())) {
            return [
                'error' => __('services.unauth'),
                'status' => 400,
            ];
        }
        if(Auth::guard($guard)->user()->email_verified_at && !(Auth::guard($guard)->user()->is_block)){
            return $this->createNewToken($token,$guard,$model);
        }else{
            return [
                'error' => __('services.not_verified'),
                'status' => 400,
            ];
        }
    }

    public function logout($guard)
    {
        Auth::guard($guard)->logout();
    }

    protected function createNewToken($token,$guard,$model)
    {
        $instance = $model::where('id', Auth::guard($guard)->user()->id)->first();
        if($instance){
            return [
                'token' => $token,
                'instance' => $instance
            ];
        }
        return [
            'error' => 'Unauthorized',
            'status' => 400,
        ];
    }

    private function generateToken()
    {
        return Str::random(60);
    }

    private function sendMail($email,$instance, $url)
    {
        Mail::to($email)->send(new MailVerification($instance, $url));
    }
}

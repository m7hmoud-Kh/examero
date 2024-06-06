<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileAuthService
{
    public function userProfile($guard)
    {
        return response()->json([
            'user' =>  Auth::guard($guard)->user()
        ]);
    }

    public function update($request, Model $model, $guard)
    {
        $instance = $model::whereId(auth($guard)->user()->id)->first();
        $instance->update($request->validated());
        return response()->json([
            'message' => 'Info Updated Data Successfully..',
            'status' => Response::HTTP_ACCEPTED
        ],Response::HTTP_ACCEPTED);
    }


    public function changePassword($request, Model $model, $guard)
    {
        $instance = $model::find(Auth::guard($guard)->user()->id);
        $instance->update([
            'password' => $request->password
        ]);
        return response()->json([
            'message' => 'Password Change Successfully',
            'status' => Response::HTTP_OK
        ]);
    }
}

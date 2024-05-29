<?php

namespace App\Http\Controllers\Dashboard;

use Validator;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminResource;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => ['required',Password::min(8)->letters()->numbers()],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        if (!$token = auth('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }
        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth('admin')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }


    protected function createNewToken($token)
    {
        $user = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 1000,
            'user' => new AdminResource($user)
        ]);
    }

}

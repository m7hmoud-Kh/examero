<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\ChangePasswordAdminRequest;
use App\Http\Requests\Dashboard\Profile\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function userProfile()
    {
        return response()->json([
            'User' => new AdminResource(auth('admin')->user())
        ]);
    }

    public function logout()
    {
        auth('admin')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }


    public function update(UpdateAdminRequest $request)
    {
        $admin = Admin::whereId(auth('admin')->user()->id)->first();
        $admin->update($request->validated());
        return response()->json([
            'message' => 'Admin Updated Data Successfully..',
            'status' => Response::HTTP_ACCEPTED
        ],Response::HTTP_ACCEPTED);
    }


    public function changePassword(ChangePasswordAdminRequest $request)
    {
        $user = Admin::find(Auth::user('admin')->id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Password Change Successfully',
            'status' => Response::HTTP_OK
        ]);
    }
}

<?php

namespace App\Http\Controllers\Website\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Student\UpdateStudentRequest;
use App\Http\Requests\Website\Student\ChangePasswordRequest;
use App\Http\Requests\Website\Student\UpdateProfileStudentRequest;
use App\Models\User;
use App\Services\ProfileAuthService;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    //
    public $profileAuthService;
    public function __construct(ProfileAuthService $profileAuthService)
    {
        $this->profileAuthService = $profileAuthService;
    }

    public function userProfile()
    {
        return $this->profileAuthService->userProfile('api');
    }

    public function update(UpdateProfileStudentRequest $request)
    {
        return $this->profileAuthService->update($request,new User(),'api',User::DISK_NAME,User::PATH_IMAGE);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->profileAuthService->changePassword($request,new User(),'api');
    }


}

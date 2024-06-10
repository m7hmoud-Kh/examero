<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Teacher\UpdateTeacherRequest;
use App\Http\Requests\Website\Teacher\ChangePasswordRequest;
use App\Http\Requests\Website\Teacher\UpdateProfileTeacherRequest;
use App\Models\Teacher;
use App\Services\ProfileAuthService;
use Illuminate\Http\Request;

class TeacherProfileController extends Controller
{
    public $profileAuthService;
    public function __construct(ProfileAuthService $profileAuthService)
    {
        $this->profileAuthService = $profileAuthService;
    }

    public function userProfile()
    {
        return $this->profileAuthService->userProfile('teacher');
    }

    public function update(UpdateProfileTeacherRequest $request)
    {
        return $this->profileAuthService->update($request,new Teacher(),'teacher',Teacher::DISK_NAME,Teacher::PATH_IMAGE);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->profileAuthService->changePassword($request,new Teacher(),'teacher');
    }

}

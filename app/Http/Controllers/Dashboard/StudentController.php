<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Student\StoreStudentRequest;
use App\Http\Requests\Dashboard\Student\UpdateStudentRequest;
use App\Http\Resources\UserResource;
use App\Http\Trait\Paginatable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class StudentController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allStudents = User::latest()
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => UserResource::collection($allStudents),
            'meta' => $this->getPaginatable($allStudents)
        ]);
    }

    public function show($studentId)
    {
        $student = User::whereId($studentId)->first();
        if($student){
            return response()->json([
                'Message' => "Ok",
                'data' => new UserResource($student)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }


    public function store(StoreStudentRequest $request)
    {
        $student = User::create(
            array_merge($request->validated(),[
                'email_verified_at' => Carbon::now()
            ])
        );
        return response()->json([
            'Message' => "Ok",
            'data' => new UserResource($student)
        ],Response::HTTP_CREATED);
    }

    public function update(UpdateStudentRequest $request, $studentId)
    {
        $user = User::whereId($studentId)->first();

        if($user){
            $user->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new UserResource($user)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($studentId)
    {
        $user = User::whereId($studentId)->first();
        if($user){
            $user->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

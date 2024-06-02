<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Teacher\StoreTeacherRequest;
use App\Http\Requests\Dashboard\Teacher\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Http\Trait\Paginatable;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class TeacherController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allTeacher = Teacher::latest()
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => TeacherResource::collection($allTeacher),
            'meta' => $this->getPaginatable($allTeacher)
        ]);
    }

    public function show($teacherId)
    {
        $teacher = Teacher::whereId($teacherId)->first();
        if($teacher){
            return response()->json([
                'Message' => "Ok",
                'data' => new TeacherResource($teacher)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }


    public function store(StoreTeacherRequest $request)
    {
        $teacher = Teacher::create(
            array_merge($request->validated(),[
                'email_verified_at' => Carbon::now()
            ])
        );
        return response()->json([
            'Message' => "Ok",
            'data' => new TeacherResource($teacher)
        ],Response::HTTP_CREATED);
    }

    public function update(UpdateTeacherRequest $request, $teacherId)
    {
        $user = Teacher::whereId($teacherId)->first();

        if($user){
            $user->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new TeacherResource($user)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($teacherId)
    {
        $user = Teacher::whereId($teacherId)->first();
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

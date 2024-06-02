<?php

namespace App\Http\Controllers\Dashboard\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Lesson\StoreLessonRequest;
use App\Http\Requests\Dashboard\Lesson\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Http\Trait\Paginatable;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class LessonController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allLessons = Lesson::latest()
        ->with(['unit'=>function($q){
            return $q->with('subject','group');
        }])
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => LessonResource::collection($allLessons),
            'meta' => $this->getPaginatable($allLessons)
        ]);
    }

    public function store(StoreLessonRequest $request)
    {
        //store
        $lesson = Lesson::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new LessonResource($lesson)
        ],Response::HTTP_CREATED);
    }

    public function show($lessonId)
    {
        //show
        $lesson = Lesson::with(['unit'=>function($q){
            return $q->with('subject','group');
        }])->whereId($lessonId)->first();

        if($lesson){
            return response()->json([
                'Message' => "Ok",
                'data' => new LessonResource($lesson)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function showLessonInSelection($unitId)
    {
        $allLesson = Lesson::where('unit_id',$unitId)
        ->Status()
        ->latest()
        ->get(['id','name']);
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $allLesson
        ]);
    }
    public function update(UpdateLessonRequest $request, $lessonId)
    {
        //update
        $lesson = Lesson::whereId($lessonId)->first();
        if($lesson){
            $lesson->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new LessonResource($lesson)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($lessonId)
    {
        //delete
        $lesson = Lesson::whereId($lessonId)->first();
        if($lesson){
            $lesson->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

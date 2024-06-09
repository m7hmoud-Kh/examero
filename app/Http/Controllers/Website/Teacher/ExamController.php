<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\Question\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Teacher\Exam\GenerateQuestionExamRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function generateExam(GenerateQuestionExamRequest $request)
    {
        $allQuestion = Question::with(['media'])
        ->where('status',QuestionStatus::ACCPTED->value)
        ->where('group_id',$request->group_id)
        ->where('subject_id',$request->subject_id)
        ->where('semster',$request->semster)
        ->where('question_type_id',$request->question_type_id)
        ->where('for',$request->for)
        ->where('level',$request->level);

        if($request->unit_id){
            $allQuestion = $allQuestion->where('unit_id',$request->unit_id);
            if($request->lesson_id){
                $allQuestion = $allQuestion->where('lesson_id',$request->lesson_id);
            }
        }
        if($request->count){
            $allQuestion = $allQuestion
            ->inRandomOrder()
            ->take($request->count)
            ->get();
        }else{
            $allQuestion = $allQuestion->get();
        }

        return response()->json([
            'message' => 'Ok',
            'data' => [
                'count' => $allQuestion->count(),
                'allQuestion' => QuestionResource::collection($allQuestion)
            ]
        ]);

    }



}

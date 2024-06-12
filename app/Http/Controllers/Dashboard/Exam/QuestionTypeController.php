<?php

namespace App\Http\Controllers\Dashboard\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\QuestionType\StoreQuestionTypeRequest;
use App\Http\Requests\Dashboard\QuestionType\UpdateQuestionTypeRequest;
use App\Http\Resources\QuestionTypeResource;
use App\Http\Trait\Paginatable;
use App\Models\QuestionType;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class QuestionTypeController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allQuestionType = QuestionType::latest()
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => QuestionTypeResource::collection($allQuestionType),
            'meta' => $this->getPaginatable($allQuestionType)
        ]);
    }

    public function store(StoreQuestionTypeRequest $request)
    {
        //store
        $questionType = QuestionType::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new QuestionTypeResource($questionType)
        ],Response::HTTP_CREATED);
    }


    public function show($questionTypeId)
    {
        //show
        $questionType = QuestionType::whereId($questionTypeId)->first();
        if($questionType){
            return response()->json([
                'Message' => "Ok",
                'data' => new QuestionTypeResource($questionType)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function showQuestionsTypeInSelection()
    {
        $allQuestionsType = QuestionType::Status()->latest()->get(['id','name']);
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $allQuestionsType
        ]);
    }


    public function update(UpdateQuestionTypeRequest $request, $questionTypeId)
    {
        //update
        $questionType = QuestionType::whereId($questionTypeId)->first();
        if($questionType){
            $questionType->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new QuestionTypeResource($questionType)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($questionTypeId)
    {
        //delete
        $questionType = QuestionType::whereId($questionTypeId)->first();
        if($questionType){
            $questionType->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

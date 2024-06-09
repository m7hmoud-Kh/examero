<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\Question\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Teacher\Question\StoreQuestionRequest;
use App\Http\Requests\Website\Teacher\Question\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class QuestionController extends Controller
{
    use Imageable, Paginatable;
    public function index()
    {
        $allQuestions = Question::latest()->with([
            'group','subject','unit','lesson',
            'questionType',
            'media',
            'teacherQuestion' => function($q){
                return $q->with('teacher')
                ->where('teacher_id',Auth::guard('teacher')->user()->id);
            },
            'options' => function($q){
            return $q->with('media');
        }])->whereHas('teacherQuestion' , function($q){
            $q->where('teacher_id',Auth::guard('teacher')->user()->id);
        })->paginate(Config::get('app.per_page'));

        return response()->json([
            'message' => 'Ok',
            'data' => QuestionResource::collection($allQuestions),
            'meta' => $this->getPaginatable($allQuestions)
        ],Response::HTTP_OK);
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->except(['options','image']));

        if($request->file('image')){
            $newImage = $this->insertImage($question->name,$request->image,Question::PATH_IMAGE);
            $this->insertImageInMeddiable($question,$newImage,'media');
        }
        $this->storeOptions($request->options,$question->id);
        $question->teacherQuestion()->create([
            'teacher_id' => Auth::guard('teacher')->user()->id,
            'question_id' => $question->id
        ]);
        return response()->json([
            'Message' => "Ok",
            'data' => new QuestionResource($question)
        ],Response::HTTP_CREATED);
    }

    public function show($questionId)
    {
        $question = Question::whereId($questionId)->with([
            'group','subject','unit','lesson',
            'questionType',
            'media',
            'options' => function($q){
            return $q->with('media');
        }])->whereHas('teacherQuestion' , function($q){
            $q->where('teacher_id',Auth::guard('teacher')->user()->id);
        })->first();

        if($question){
            return response()->json([
                'message' => 'OK',
                'question' => new QuestionResource($question)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    public function update(UpdateQuestionRequest $request, $questionId)
    {
        //update
        $question = Question::whereId($questionId)->whereHas('teacherQuestion' , function($q){
            $q->where('teacher_id',Auth::guard('teacher')->user()->id);
        })->first();
        if($question){
            $question->update(array_merge($request->except(['options','image']),[
                'status' => QuestionStatus::WAITING->value,
            ]));
            if($request->file('image')){
                //remove old Image
                $image = $question->media()->first();
                if($image){
                    $this->deleteImage(Question::DISK_NAME,$image);
                    $question->media()->delete();
                }

                //insert New Image
                $newImage = $this->insertImage($question->name,$request->image,Question::PATH_IMAGE);
                $this->insertImageInMeddiable($question,$newImage,'media');
            }
            if($request->has('options'))
            {
                $this->destoryOptions($question->id);
                $this->storeOptions($request->options,$question->id);
            }
            return response()->json([
                'Message' => "Updated",
                'data' => new QuestionResource($question)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($questionId)
    {
        $question = Question::whereHas('teacherQuestion' , function($q){
            $q->where('teacher_id',Auth::guard('teacher')->user()->id);
        })->find($questionId);
        if($question){
            if($question->media){
                $image = $question->media()->first();
                $this->deleteImage(Question::DISK_NAME,$image);
                $question->media()->delete();
            }

            $question->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    private function storeOptions($allOption, $questionId)
    {
        foreach ($allOption as $choice) {
            $newOption =  Option::create([
                'option' => $choice['option'],
                'is_correct' => $choice['is_correct'],
                'question_id' => $questionId
            ]);

            if(isset($choice['image'])){
                $newImage = $this->insertImage($newOption->id,$choice['image'],Option::PATH_IMAGE);
                $this->insertImageInMeddiable($newOption,$newImage,'media');
            }
        }

    }

    private function destoryOptions($questionId)
    {
        $options = Option::where('question_id',$questionId)->get();
            foreach ($options as $option) {
                $image = $option->media()->first();
                if($image){
                    $this->deleteImage(Option::DISK_NAME,$image);
                }
                $option->delete();
        }
    }
}

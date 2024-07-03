<?php

namespace App\Http\Controllers\Website\Student;

use App\Enums\Question\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Student\Exam\GenerateExamRequest;
use App\Http\Requests\Website\Student\Exam\SubmitExamRequest;
use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionResource;
use App\Http\Trait\Paginatable;
use App\Models\Exam;
use App\Models\Plan;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    use Paginatable;

    public function getSomeInfo()
    {
        $allExams = Exam::where('user_id',Auth::user()->id)->get();

        $percentages = [];

        foreach ($allExams as $exam) {
                $percentages[] = ($exam->result / $exam->total_score) * 100;
        }
        if($allExams->count() == 0){
            $average = 0;
        }else{
            $average = array_sum($percentages) / $allExams->count();
        }
        return response()->json([
            'exam_student_finished' => $allExams->count(),
            'exam_average' => round($average,2)
        ]);

    }

    public function getAllExams()
    {
        $allExams = Exam::with('user','group','subject','unit','lesson')
        ->where('user_id',Auth::user()->id)
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'data' => ExamResource::collection($allExams),
            'meta' => $this->getPaginatable($allExams)
        ]);
    }

    public function searchExamByName(Request $request)
    {
        $allExams = Exam::with('user','group','subject','unit','lesson')
        ->where('user_id',Auth::user()->id)
        ->where('name','like',"%$request->key%")
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'data' => ExamResource::collection($allExams),
            'meta' => $this->getPaginatable($allExams)
        ]);
    }

    public function generateExam(GenerateExamRequest $request)
    {
        if($this->checkNotExceedLimitation($request->plan_id,$request->filters_level)){
            $allQuestions = collect();
            foreach ($request->filters_level as $level) {
            $questionsLevel =
                Question::with(['media','options' => function($q){
                    return $q->with('media');
                }])
                ->where('status',QuestionStatus::ACCPTED->value)
                ->where('is_choose',true)
                ->where('group_id',$request->group_id)
                ->where('subject_id',$request->subject_id)
                ->where('semster',$request->semster)
                ->where('level',$level['level']);

                if($request->unit_id){
                    $questionsLevel = $questionsLevel->where('unit_id',$request->unit_id);
                }
                if($request->lesson_id){
                    $questionsLevel = $questionsLevel->where('lesson_id',$request->lesson_id);
                }

                $questionsLevel = $questionsLevel->inRandomOrder()
                ->take($level['number'])
                ->get();
                $allQuestions = $allQuestions->merge($questionsLevel);
            }

            $this->increaseExamUsed($request->plan_id);

            return response()->json([
                'data' => [
                    'count' => $allQuestions->count(),
                    'questions' => QuestionResource::collection($allQuestions)
                ]
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'You Exceed Limitation'
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function submitExam(SubmitExamRequest $request)
    {
        DB::beginTransaction();
        try {
            $selectedAnswers = $request->answers;
            $questions = Question::whereIn('id', array_keys($selectedAnswers))->with('options')->get();

            $totalScore = 0;
            $result = 0;

            foreach ($questions as $question) {
                $selectedOptionIds = $selectedAnswers[$question->id];
                $selectedOptionIds = array_map('intval', $selectedOptionIds);
                $correctOptionIds = $question->options->where('is_correct', 1)->pluck('id')->toArray();

                //get total
                $totalScore += $question->point;

                if (empty(array_diff($selectedOptionIds, $correctOptionIds)) && empty(array_diff($correctOptionIds, $selectedOptionIds))) {
                    $result += $question->point;
                }
            }

            $exam =  Exam::create([
                'user_id' => Auth::guard('api')->user()->id,
                'semster'  => $request->semster,
                'group_id' => $request->group_id,
                'subject_id' => $request->subject_id,
                'unit_id' => $request->unit_id,
                'lesson_id' => $request->lesson_id,
                'total_score' => $totalScore,
                'result' => $result
            ]);

            DB::commit();

            return response()->json([
                'message' => 'OK',
                'data' => [
                    'result' => $result,
                    'total_score' => $totalScore,
                ]
            ],Response::HTTP_OK);


        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'message' => $ex
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    private function increaseExamUsed($planId)
    {
        //increase exam_used
        $user = User::whereId(Auth::user()->id)->with('plans')->first();
        $user->plans()->updateExistingPivot($planId, [
            'exam_used' => DB::raw('exam_used + 1')
        ]);
    }

    private function checkNotExceedLimitation($planId,$filterLevels)
    {
        $planSelected = Plan::where('id',$planId)->first();
        $totalQuestions = 0;
        foreach ($filterLevels as $level) {
            $totalQuestions += $level['number'];
        }
        if($planSelected->allow_question < $totalQuestions){
            return false;
        }
        return true;
    }
}

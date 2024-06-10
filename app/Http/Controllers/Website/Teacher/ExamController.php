<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\Question\QuestionStatus;
use App\Enums\TeacherPoint;
use App\Enums\TeacherServicesType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Teacher\Exam\GenerateQuestionExamRequest;
use App\Http\Requests\Website\Teacher\Exam\SaveExamRequest;
use App\Http\Requests\Website\Teacher\Exam\SavePdfsInfoRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\TeacherExamResource;
use App\Http\Trait\Imageable;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\TeacherExam;
use App\Models\TeacherPlan;
use App\Models\TeacherPlanDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    use Imageable;

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

    /**
     * todo check point to do Exam
     * todo must be get Exam all Ids of exam and must not execced
     * todo store teacherPlanDetails to withdraw exam point
     */

    public function saveExam(SaveExamRequest $request)
    {
        if($request->plan_id){
            $teacherPlan = TeacherPlan::
            where('teacher_id',Auth::guard('teacher')->user()->id)
            ->where('plan_id',$request->plan_id)
            ->Status()
            ->first();
            TeacherPlanDetails::create([
                'teacher_plans_id' => $teacherPlan->id,
                'type' => TeacherServicesType::EXAM->value,
                'point' =>  TeacherPoint::EXAM->value
            ]);
        }else{
            $teacher = Teacher::find(Auth::guard('teacher')->user()->id);
            $teacher->update([
                'rewarded_point' => $teacher->rewarded_point - TeacherPoint::EXAM->value
            ]);
        }

        $allQuestions = Question::latest()
        ->with([
            'group','subject','unit','lesson',
            'questionType',
            'media',
            'options' => function($q){
                return $q->with('media');
            }
        ])
        ->whereIn('id',$request->questionIds)
        ->get();

        return response()->json([
            'message' => 'Created Exam Successfully',
            'data' => [
                'count' => $allQuestions->count(),
                'questions' => QuestionResource::collection($allQuestions)
            ]
        ],Response::HTTP_CREATED);
    }

    /**
     * todo: save all info about exam with two pdf
     */

    public function saveInfoExam(SavePdfsInfoRequest $request)
    {
        $teacherExam = TeacherExam::create(
            array_merge($request->except('mediaQuestion','mediaAnswer'),[
            'teacher_id' => Auth::guard('teacher')->user()->id,
        ]));


        $questionPdf = $this->insertImage($teacherExam->id.'Question',$request->mediaQuestion,TeacherExam::PATH_IMAGE);
        $answerPdf = $this->insertImage($teacherExam->id.'Answer',$request->mediaAnswer,TeacherExam::PATH_IMAGE);
        $this->insertImageInMeddiable($teacherExam,$questionPdf,'mediaQuestion');
        $this->insertImageInMeddiable($teacherExam,$answerPdf,'mediaAnswer');


        return response()->json([
            'message' => 'Exam Store Successfully',
        ],Response::HTTP_CREATED);
    }


    public function getAllExam()
    {
        $teacherExam = TeacherExam::where('teacher_id',Auth::guard('teacher')->user()->id)->with('subject','group','mediaQuestion','mediaAnswer')->get();

        return response()->json([
            'message' => 'OK',
            'data' => [
                'Exams' => TeacherExamResource::collection($teacherExam)
            ]
        ],Response::HTTP_OK);
    }


}

<?php

namespace App\Http\Controllers\Dashboard\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Subject\StoreSubjectRequest;
use App\Http\Requests\Dashboard\Subject\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Trait\Paginatable;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class SubjectController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allSubjects = Subject::latest()
        ->with('groups')
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => SubjectResource::collection($allSubjects),
            'meta' => $this->getPaginatable($allSubjects)
        ]);
    }

    public function store(StoreSubjectRequest $request)
    {
        //store
        $subject = Subject::create($request->only(['name']));
        $subject->groups()->sync($request->groupIds);
        return response()->json([
            'Message' => "Ok",
            'data' => new SubjectResource($subject)
        ],Response::HTTP_CREATED);
    }

    public function show($groupId)
    {
        //show
        $subject = Subject::with('groups')->whereId($groupId)->first();
        if($subject){
            return response()->json([
                'Message' => "Ok",
                'data' => new SubjectResource($subject)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function showSubjectInSelection($groupId)
    {
        $allSubject = Subject::whereHas('groups',function($q) use($groupId) {
            return $q->where('groups.id',$groupId);
        })->Status()->latest()->get(['id','name']);
        
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $allSubject
        ]);
    }
    public function update(UpdateSubjectRequest $request, $subjectId)
    {
        //update
        $subject = Subject::whereId($subjectId)->first();
        if($subject){
            $subject->update($request->except(['groupIds']));
            $subject->groups()->sync($request->groupIds);

            return response()->json([
                'Message' => "Updated",
                'data' => new SubjectResource($subject)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($subjectId)
    {
        //delete
        $subject = Subject::whereId($subjectId)->first();
        if($subject){
            $subject->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

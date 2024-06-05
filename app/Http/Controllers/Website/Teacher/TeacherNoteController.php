<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminNote\StoreAdminNoteRequest;
use App\Http\Requests\Dashboard\AdminNote\UpdateAdminNoteRequest;
use App\Http\Resources\TeacherNoteResource;
use App\Http\Resources\TeacherResource;
use App\Models\TeacherNote;
use App\Services\NoteService;
use Illuminate\Http\Request;

class TeacherNoteController extends Controller
{
    public $noteService;
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index()
    {
        $allNotes = $this->noteService->index(new TeacherNote(),'teacher','teacher_id');
        return response()->json([
            'message' => "Ok",
            'data' => TeacherNoteResource::collection($allNotes)
        ]);
    }

    public function store(StoreAdminNoteRequest $request)
    {
        $note = $this->noteService->store($request, new TeacherNote());
        return response()->json([
            'message' => 'Created',
            'data' => new TeacherNoteResource($note)
        ]);
    }

    public function show($noteId)
    {
        $data = $this->noteService->show($noteId, new TeacherNote());
        if(isset($data['data'])){
            return response()->json([
                'message' => 'Ok',
                'data' => $data['data']
            ],$data['status']);
        }else{
            return response()->json([
                'message' => $data['error']
            ],$data['status']);
        }
    }

    public function update(UpdateAdminNoteRequest $request, $noteId)
    {
        $data = $this->noteService->update($request,new TeacherNote(),$noteId);
        if(isset($data['data'])){
            return response()->json([
                'message' => 'Created',
                'data' => $data['data']
            ],$data['status']);
        }else{
            return response()->json([
                'message' => $data['error']
            ],$data['status']);
        }
    }

    public function destory($noteId)
    {
        $data = $this->noteService->destory($noteId, new TeacherNote());
        if(isset($data['data'])){
            return response()->json([
                'message' => 'Created',
                'data' => $data['data']
            ],$data['status']);
        }else{
            return response()->json([
                'message' => $data['error']
            ],$data['status']);
        }
    }
}

<?php

namespace App\Http\Controllers\Website\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminNote\StoreAdminNoteRequest;
use App\Http\Requests\Dashboard\AdminNote\UpdateAdminNoteRequest;
use App\Http\Resources\UserNoteResource;
use App\Models\UserNote;
use App\Services\NoteService;
use Illuminate\Http\Request;

class StudentNoteController extends Controller
{
    public $noteService;
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index()
    {
        $allNotes = $this->noteService->index(new UserNote(),'api','user_id');
        return response()->json([
            'message' => "Ok",
            'data' => UserNoteResource::collection($allNotes)
        ]);
    }

    public function store(StoreAdminNoteRequest $request)
    {
        $note = $this->noteService->store($request, new UserNote());
        return response()->json([
            'message' => 'Created',
            'data' => new UserNoteResource($note)
        ]);
    }

    public function show($noteId)
    {
        $data = $this->noteService->show($noteId, new UserNote());
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
        $data = $this->noteService->update($request,new UserNote(),$noteId);
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
        $data = $this->noteService->destory($noteId, new UserNote());
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

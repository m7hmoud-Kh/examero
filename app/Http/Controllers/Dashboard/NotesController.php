<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\AdminNote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminNote\StoreAdminNoteRequest;
use App\Http\Requests\Dashboard\AdminNote\UpdateAdminNoteRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminNoteResource;

class NotesController extends Controller
{
    public function index()
    {
        //index
        $adminNote = AdminNote::latest()->where('admin_id',Auth::user('admin')->id)->get();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => AdminNoteResource::collection($adminNote),
        ]);

    }

    public function store(StoreAdminNoteRequest $request)
    {
        //store
        $adminNote = AdminNote::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new AdminNoteResource($adminNote)
        ],Response::HTTP_CREATED);
    }

    public function show($adminNoteId)
    {
        //show
        $adminNote = AdminNote::whereId($adminNoteId)->first();
        if($adminNote){
            return response()->json([
                'Message' => "Ok",
                'data' => new AdminNoteResource($adminNote)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateAdminNoteRequest $request, $adminNoteId)
    {
        //update
        $adminNote = AdminNote::whereId($adminNoteId)->first();
        if($adminNote){
            $adminNote->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new AdminNoteResource($adminNote)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    public function destory($adminNoteId)
    {
        //delete
        $adminNote = AdminNote::whereId($adminNoteId)->first();
        if($adminNote){
            $adminNote->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    public function index(Model $model, $guard, $columnName)
    {
        //index
        return $model::latest()->where($columnName,Auth::guard($guard)->user()->id)->get();

    }

    public function store($request, Model $model)
    {
        //store
        return $model::create($request->validated());

    }

    public function show($noteId, Model $model)
    {
        $instance = $model::whereId($noteId)->first();
        if($instance){
            return [
                'data' => $instance,
                'status' => Response::HTTP_OK
            ];
        }else{
            return [
                'error' => 'Not Found',
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }
    }

    public function update($request,Model $model, $noteId)
    {
        $instance = $model::whereId($noteId)->first();
        if($instance){
            $instance->update($request->validated());
            return [
                'data' => $instance,
                'status' => Response::HTTP_ACCEPTED
            ];
        }else{
            return [
                'error' => 'Not Found',
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }
    }

    public function destory($noteId, Model $model)
    {
        //delete
        $note = $model::whereId($noteId)->first();
        if($note){
            $note->delete();
            return [
                'data' => '',
                'status' => Response::HTTP_NO_CONTENT
            ];
        }else{
            return [
                'error' => 'Not Found',
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }
    }
}

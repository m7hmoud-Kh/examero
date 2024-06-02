<?php

namespace App\Http\Controllers\Dashboard\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Group\StoreGroupRequest;
use App\Http\Requests\Dashboard\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Trait\Paginatable;
use App\Models\Group;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class GroupController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allGroups = Group::latest()
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => GroupResource::collection($allGroups),
            'meta' => $this->getPaginatable($allGroups)
        ]);
    }

    public function store(StoreGroupRequest $request)
    {
        //store
        $group = Group::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new GroupResource($group)
        ],Response::HTTP_CREATED);
    }

    public function showGroupInSelection()
    {
        $allGroups = Group::Status()->latest()->get(['id','name']);
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $allGroups
        ]);
    }
    public function show($groupId)
    {
        //show
        $group = Group::whereId($groupId)->first();
        if($group){
            return response()->json([
                'Message' => "Ok",
                'data' => new GroupResource($group)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateGroupRequest $request, $groupId)
    {
        //update
        $group = Group::whereId($groupId)->first();
        if($group){
            $group->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new GroupResource($group)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($groupId)
    {
        //delete
        $group = Group::whereId($groupId)->first();
        if($group){
            $group->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

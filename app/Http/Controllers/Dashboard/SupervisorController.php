<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Supervisor\StoreSupervisorRquest;
use App\Http\Requests\Dashboard\Supervisor\UpdateSupervisorRequest;
use App\Http\Resources\AdminResource;
use App\Http\Trait\Paginatable;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class SupervisorController extends Controller
{
    use Paginatable;

    public function index()
    {
        $supervisors = Admin::role('supervisor')->latest()
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => AdminResource::collection($supervisors),
            'meta' => $this->getPaginatable($supervisors)
        ]);
    }

    public function show($supervisorId)
    {
        $supervisor = Admin::role('supervisor')->whereId($supervisorId)->first();
        if($supervisor){
            return response()->json([
                'Message' => "Ok",
                'data' => new AdminResource($supervisor)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }


    public function store(StoreSupervisorRquest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->assignRole('supervisor');
        return response()->json([
            'Message' => "Ok",
            'data' => new AdminResource($admin)
        ],Response::HTTP_CREATED);
    }

    public function update(UpdateSupervisorRequest $request, $managerId)
    {
        $user = Admin::role('supervisor')->whereId($managerId)->first();

        if($user){
            $user->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new AdminResource($user)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($managerId)
    {
        $user = Admin::role('supervisor')->whereId($managerId)->first();
        if($user){
            $user->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

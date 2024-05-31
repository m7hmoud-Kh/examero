<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Manager\StoreManagerRequest;
use App\Http\Requests\Dashboard\Manager\UpdateManagerRequest;
use App\Http\Resources\AdminResource;
use App\Http\Trait\Paginatable;
use App\Models\Admin;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class ManagerController extends Controller
{
    use Paginatable;

    public function index()
    {
        $allManager = Admin::role('manager')->latest()
        ->paginate(config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => AdminResource::collection($allManager),
            'meta' => $this->getPaginatable($allManager)
        ]);
    }

    public function show($managerId)
    {
        $manager = Admin::role('manager')->whereId($managerId)->first();
        if($manager){
            return response()->json([
                'Message' => "Ok",
                'data' => new AdminResource($manager)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }


    public function store(StoreManagerRequest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->assignRole('manager');
        return response()->json([
            'Message' => "Ok",
            'data' => new AdminResource($admin)
        ],Response::HTTP_CREATED);
    }

    public function update(UpdateManagerRequest $request, $managerId)
    {
        $user = Admin::role('manager')->whereId($managerId)->first();

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
        $user = Admin::role('manager')->whereId($managerId)->first();
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

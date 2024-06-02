<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Plan\StorePlanRequest;
use App\Http\Requests\Dashboard\Plan\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Http\Trait\Paginatable;
use App\Models\Plan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class PlanController extends Controller
{
    use Paginatable;
    public function getStudentPlans()
    {
        $plans = Plan::latest()
        ->where('for_student',true)
        ->paginate(Config::get('app.per_page'));

        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => PlanResource::collection($plans),
            'meta' => $this->getPaginatable($plans)
        ]);

    }

    public function getTeacherPlans()
    {
        $plans = Plan::latest()->where('for_student',false)
        ->paginate(Config::get('app.per_page'));

        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => PlanResource::collection($plans),
            'meta' => $this->getPaginatable($plans)

        ]);
    }

    public function store(StorePlanRequest $request)
    {
        //store
        $plan = Plan::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new PlanResource($plan)
        ],Response::HTTP_CREATED);
    }

    public function show($planId)
    {
        //show
        $plan = Plan::whereId($planId)->first();
        if($plan){
            return response()->json([
                'Message' => "Ok",
                'data' => new PlanResource($plan)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdatePlanRequest $request, $planId)
    {
        //update
        $plan = Plan::whereId($planId)->first();
        if($plan){
            $plan->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new PlanResource($plan)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($planId)
    {
        //delete
        $plan = Plan::whereId($planId)->first();
        if($plan){
            $plan->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

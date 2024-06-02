<?php

namespace App\Http\Controllers\Dashboard\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Unit\StoreUnitRequest;
use App\Http\Requests\Dashboard\Unit\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Http\Trait\Paginatable;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class UnitController extends Controller
{
    //
    use Paginatable;

    public function index()
    {
        $allUnits = Unit::latest()
        ->with('group','subject')
        ->paginate(Config::get('app.per_page'));
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => UnitResource::collection($allUnits),
            'meta' => $this->getPaginatable($allUnits)
        ]);
    }

    public function store(StoreUnitRequest $request)
    {
        //store
        $unit = Unit::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new UnitResource($unit)
        ],Response::HTTP_CREATED);
    }

    public function show($unitId)
    {
        //show
        $unit = Unit::with('group','subject')->whereId($unitId)->first();
        if($unit){
            return response()->json([
                'Message' => "Ok",
                'data' => new UnitResource($unit)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function showUnitInSelection($subjectId)
    {
        $allUnit = Unit::where('subject_id',$subjectId)
        ->Status()
        ->latest()
        ->get(['id','name']);
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $allUnit
        ]);
    }
    public function update(UpdateUnitRequest $request, $unitId)
    {
        //update
        $unit = Unit::whereId($unitId)->first();
        if($unit){
            $unit->update($request->validated());
            return response()->json([
                'Message' => "Updated",
                'data' => new UnitResource($unit)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($unitId)
    {
        //delete
        $unit = Unit::whereId($unitId)->first();
        if($unit){
            $unit->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

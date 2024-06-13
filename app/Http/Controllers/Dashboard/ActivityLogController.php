<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogResource;
use App\Http\Trait\Paginatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    use Paginatable;
    public function index()
    {
        $allActivity = Activity::with('causer')
        ->withWhereHas('causer')
        ->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'message' => 'Ok',
            'data' => ActivityLogResource::collection($allActivity),
            'meta' => $this->getPaginatable($allActivity)
        ]);
    }

    public function getActivityForManager()
    {
        $allActivity = Activity::with('causer')
        ->whereHas('causer' , function($q){
            return $q->role('supervisor');
        })
        ->withWhereHas('causer')
        ->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'message' => 'Ok',
            'data' => ActivityLogResource::collection($allActivity),
            'meta' => $this->getPaginatable($allActivity)
        ]);
    }

    public function destory(Request $request)
    {
        $allActivity = Activity::whereIn('id',$request->activityIds);
        foreach ($allActivity as $activity) {
            $activity->delete();
        }
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}

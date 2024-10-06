<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogResource;
use App\Http\Trait\Paginatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Spatie\Activitylog\Models\Activity;

use function PHPUnit\Framework\isEmpty;

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

    public function getActivityManager()
    {
        $allSupervisorActivity = collect()->mapInto(ActivityLogResource::class);
        $allActivity = Activity::with('causer')
        ->withWhereHas('causer')
        ->latest()
        ->paginate(Config::get('app.per_page'));
        foreach ($allActivity as $activity) {
            $activityCauserRole = $activity->causer->roles[0]->name  ?? null;
            if($activityCauserRole == 'manager'){
                $allSupervisorActivity->push(new ActivityLogResource($activity));
            }
        }

        $perPage = Config::get('app.per_page');
        $currentPage = request()->get('page', 1);
        $allManagerActivity = new \Illuminate\Pagination\LengthAwarePaginator(
            $allSupervisorActivity->forPage($currentPage, $perPage),
            $allSupervisorActivity->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return response()->json([
            'message' => 'Ok',
            'data' => $allManagerActivity,
        ]);
    }

    public function getActivitySupervisor()
    {
        $allSupervisorActivity = collect()->mapInto(ActivityLogResource::class);
        $allActivity = Activity::with('causer')
        ->withWhereHas('causer')
        ->latest()
        ->paginate(Config::get('app.per_page'));
        foreach ($allActivity as $activity) {
            $activityCauserRole = $activity->causer->roles[0]->name  ?? null;
            if($activityCauserRole == 'supervisor'){
                $allSupervisorActivity->push(new ActivityLogResource($activity));
            }
        }

        $perPage = Config::get('app.per_page');
        $currentPage = request()->get('page', 1);
        $allSupervisorActivity = new \Illuminate\Pagination\LengthAwarePaginator(
            $allSupervisorActivity->forPage($currentPage, $perPage),
            $allSupervisorActivity->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return response()->json([
            'message' => 'Ok',
            'data' => $allSupervisorActivity,
        ]);
    }

    public function destory(Request $request)
    {
        $allActivity = Activity::whereIn('id',$request->activityIds)->get();
        foreach ($allActivity as $activity) {
            $activity->delete();
        }
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}

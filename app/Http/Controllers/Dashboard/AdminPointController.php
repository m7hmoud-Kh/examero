<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TypePoint;
use App\Models\AdminPoint;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminPointResource;
use App\Http\Requests\Dashboard\AdminPoint\StoreAdminPointRequest;
use App\Http\Trait\Paginatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AdminPointController extends Controller
{

    use Paginatable;
    public function index(Request $request)
    {
        // Fetch points data
        $pointsData = AdminPoint::with(['admin' => function($q) use ($request){
            return $q->role($request->role)->get();
        }])->whereHas('admin',function($q)use ($request){
            return $q->role($request->role);
        })->select(
            'admin_id',
            DB::raw('SUM(CASE WHEN type = '. TypePoint::REWARD->value .' THEN points ELSE 0 END) as reward_points'),
            DB::raw('SUM(CASE WHEN type = '. TypePoint::PUNISHMENT->value .' THEN points ELSE 0 END) as punishment_points'),
            DB::raw('SUM(CASE WHEN type = '. TypePoint::WARNING->value . ' THEN 1 ELSE 0 END) as warning_points')
        )
        ->groupBy('admin_id')
        ->paginate(Config::get('app.per_page'));
        
        return response()->json([
            'data' => $pointsData,
            'meta' => $this->getPaginatable($pointsData)
        ]);
    }

    public function store(StoreAdminPointRequest $request)
    {
        $point = AdminPoint::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new AdminPointResource($point)
        ],Response::HTTP_CREATED);
    }

    public function destory(Request $request)
    {
        $adminPoints = AdminPoint::whereIn('admin_id',$request->adminIds)->get();
        foreach ($adminPoints as $point) {
            $point->delete();
        }
        return response()->json([],Response::HTTP_NO_CONTENT);
    }


}

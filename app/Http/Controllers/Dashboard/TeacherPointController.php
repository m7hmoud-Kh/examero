<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TeacherTypePoint;
use App\Enums\TypePoint;
use App\Models\TeacherPoint;
use Illuminate\Http\Request;
use App\Http\Trait\Paginatable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TeacherPoint\StoreTeacherPointRequest;
use App\Http\Resources\TeacherPointResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class TeacherPointController extends Controller
{
    use Paginatable;
    public function index(Request $request)
    {
        // Fetch points data
        $pointsData = TeacherPoint::with('teacher')->select(
            'teacher_id',
            DB::raw('SUM(CASE WHEN type = '. TeacherTypePoint::REWARD->value .' THEN points ELSE 0 END) as reward_points'),
            DB::raw('SUM(CASE WHEN type = '. TeacherTypePoint::WARNING->value . ' THEN 1 ELSE 0 END) as warning_points')
        )
        ->groupBy('teacher_id')
        ->paginate(Config::get('app.per_page'));

        return response()->json([
            'data' => $pointsData,
            'meta' => $this->getPaginatable($pointsData)
        ]);
    }

    public function store(StoreTeacherPointRequest $request)
    {
        $point = TeacherPoint::create($request->validated());
        return response()->json([
            'Message' => "Ok",
            'data' => new TeacherPointResource($point)
        ],Response::HTTP_CREATED);
    }

    public function destory(Request $request)
    {
        $teacherPoints = TeacherPoint::whereIn('teacher_id',$request->teacherIds)->get();
        foreach ($teacherPoints as $point) {
            $point->delete();
        }
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

}

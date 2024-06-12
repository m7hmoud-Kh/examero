<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TeacherPoint;
use App\Enums\TeacherServicesType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OpenEmis\StoreOpenEmisRequest;
use App\Http\Requests\Dashboard\OpenEmis\UpdateOpenEmisRequest;
use App\Http\Resources\OpenEmisResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\OpenEmis;
use App\Models\Teacher;
use App\Models\TeacherPlanDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class OpenEmisController extends Controller
{
    use Paginatable, Imageable;

    public function index(Request $request)
    {
        //index
        $allOpenEmis = OpenEmis::with('media','teacher')
        ->where('status',$request->status ?? 1)
        ->latest()
        ->paginate(Config::get('app.per_page'));

        return response()->json([
            'message' => 'Ok',
            'data' => OpenEmisResource::collection($allOpenEmis),
            'meta' => $this->getPaginatable($allOpenEmis)
        ]);
    }

    public function show($openEmisId)
    {
        $openEmis = OpenEmis::whereId($openEmisId)
        ->with('media','teacher')
        ->first();
        if($openEmis){
            return response()->json([
                'message' => "ok",
                'data' => new OpenEmisResource($openEmis)
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => "Error",
            ],Response::HTTP_NOT_FOUND);
        }

    }

    public function store(StoreOpenEmisRequest $request)
    {
        if($request->plan_id){
            TeacherPlanDetails::create([
                'teacher_plans_id' => $request->teacher_plans_id,
                'type' => TeacherServicesType::OPENEMIS->value,
                'point' =>  TeacherPoint::OPENEMIS->value
            ]);
        }else{
            $teacher = Teacher::whereId($request->teacher_id)->first();
            $teacher->update([
                'rewarded_point' => $teacher->rewarded_point - TeacherPoint::OPENEMIS->value
            ]);
        }

        $openEmis = OpenEmis::create(array_merge(
            $request->except('document','plan_id','teacher_plans_id','rewarded_point','password_site'),
            ['password' => $request->password_site]
        ));
        $newImage = $this->insertImage($openEmis->user_name,$request->document,OpenEmis::PATH_IMAGE);
        $this->insertImageInMeddiable($openEmis,$newImage,'media');

        return response()->json([
            'message' => "Created",
            'data' => new OpenEmisResource($openEmis)
        ],Response::HTTP_CREATED);
    }

    public function update(UpdateOpenEmisRequest $request, $openEmisId)
    {
        //update
        $openEmis = OpenEmis::whereId($openEmisId)->first();
        if($openEmis){
            $openEmis->update($request->validated());
            return response()->json([
                'message' => "Updated",
                'data' => new OpenEmisResource($openEmis)
            ],Response::HTTP_ACCEPTED);
        }
        return response()->json([
            'message' => 'Not Found',
        ], Response::HTTP_NOT_FOUND);

    }

    public function destory(Request $request)
    {
        $allOpenEmis = OpenEmis::whereIn('id',$request->ids)->get();
        if($allOpenEmis){
            foreach ($allOpenEmis as $openEmis) {
                $image = $openEmis->media()->first();
                if($image){
                    $this->deleteImage(OpenEmis::DISK_NAME,$image);
                    $openEmis->media()->delete();
                }
                $openEmis->delete();
            }
        }
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

}

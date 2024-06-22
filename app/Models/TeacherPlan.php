<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use App\Http\Trait\Statusable;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class TeacherPlan extends Model
{
    use HasFactory, Statusable,LogsActivity, ActivityLogger ;
    protected $guarded = [];

    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Teacher Plan');
    }

    public function details()
    {
        return $this->hasMany(TeacherPlanDetails::class,'teacher_plans_id','id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}

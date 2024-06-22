<?php

namespace App\Models;

use App\Enums\TeacherTypePoint;
use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class TeacherPoint extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;
    protected $guarded = [];


    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Teacher Point');
    }


    protected $casts = [
        'type' => TeacherTypePoint::class,
    ];



    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

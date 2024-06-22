<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class TeacherExam extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;

    public const PATH_IMAGE = '/assets/TeacherExam/';
    public const DISK_NAME = 'teacher_exam';

    protected $guarded = [];
    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Teacher Exam');
    }


    public function mediaQuestion()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function mediaAnswer()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}

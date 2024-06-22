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

class Subject extends Model
{
    use HasFactory, Statusable, LogsActivity, ActivityLogger ;
    protected $guarded = [];

    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Subject');
    }

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'groups_subjects',
            'subject_id',
            'group_id'
        );
    }

}

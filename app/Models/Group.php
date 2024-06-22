<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use App\Http\Trait\Statusable;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Subset;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Group extends Model
{
    use HasFactory, Statusable, LogsActivity, ActivityLogger;
    protected $guarded = [];
    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Group');
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subset::class,
            'groups_subjects',
            'group_id',
            'subject_id'
        );
    }
}

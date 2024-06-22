<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Option extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;
    protected $guarded = [];

    public const PATH_IMAGE = '/assets/Options/';
    public const DISK_NAME = 'option';

    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Option');
    }


    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }
}

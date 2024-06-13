<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
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

    public function tapActivity(Activity $activity, string $eventName)
    {
        $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
        $activity->description = "Option has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
        $activity->properties = $activity->properties->merge([
            'causer_email'=>$causer ? $causer->email : 'unknown',
            'fullName' =>
            $causer ? $causer->first_name . ' ' . $causer->last_name : 'unkown',
            'role_user' => $causer ? $causer->roles[0]->name : 'unknown',
            'event' => $activity->event,
        ]);
    }


    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }
}

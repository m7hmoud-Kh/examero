<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Plan extends Model
{
    use HasFactory, Statusable, LogsActivity, ActivityLogger ;
    protected $guarded = [];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
        $activity->description = "Plan has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
        $activity->properties = $activity->properties->merge([
            'causer_email'=>$causer ? $causer->email : 'unknown',
            'fullName' =>
            $causer ? $causer->first_name . ' ' . $causer->last_name : 'unkown',
            'role_user' => $causer ? $causer->roles[0]->name : 'unknown',
            'event' => $activity->event,
        ]);
    }



    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'students_plans',
            'plan_id',
            'user_id'
        )->withTimestamps()->withPivot(['exam_used','status']);
    }
}

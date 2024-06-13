<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Exam extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;

    protected $guarded = [];

    public function tapActivity(Activity $activity, string $eventName)
    {
        if(Auth::guard('admin')->user()){
            $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
            $activity->description = "Exam has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
            $activity->properties = $activity->properties->merge([
                'causer_email'=>$causer ? $causer->email : 'unknown',
                'fullName' =>
                $causer ? $causer->first_name . ' ' . $causer->last_name : 'unkown',
                'role_user' => $causer ? $causer->roles[0]->name : 'unknown',
                'event' => $activity->event,
            ]);
        }else{
            $activity->description = 'null';
        }
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}

<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Teacher extends Authenticatable implements JWTSubject

{
    use HasApiTokens, HasFactory, Notifiable,LogsActivity, ActivityLogger;
    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        if(Auth::guard('admin')->user()){
            $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
            $activity->description = "Teacher has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
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

    public const PATH_IMAGE = '/assets/Teacher/';
    public const DISK_NAME = 'teacher';


    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

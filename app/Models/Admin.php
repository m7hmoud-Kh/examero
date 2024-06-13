<?php

namespace App\Models;

use App\Http\Trait\ActivityLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Admin extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CausesActivity,LogsActivity, ActivityLogger ;
    
    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
        $activity->description = "Admin has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
        $activity->properties = $activity->properties->merge([
            'causer_email'=>$causer ? $causer->email : 'unknown',
            'fullName' =>
            $causer ? $causer->first_name . ' ' . $causer->last_name : 'unkown',
            'role_user' => $causer ? $causer->roles[0]->name : 'unknown',
            'event' => $activity->event,
        ]);
    }




    public const PATH_IMAGE = '/assets/Admin/';
    public const DISK_NAME = 'admin';


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

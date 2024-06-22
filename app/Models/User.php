<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, ActivityLogger;

    protected $guarded = [];
    protected $hidden = [
        'password',
    ];
    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Student');
    }

    public const PATH_IMAGE = '/assets/Student/';
    public const DISK_NAME = 'student';

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function plans()
    {
        return $this->belongsToMany(
            Plan::class,
            'students_plans',
            'user_id',
            'plan_id'
        )->withTimestamps()->withPivot(['exam_used','status','payment_id','type']);
    }
}

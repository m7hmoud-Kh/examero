<?php

namespace App\Models;

use App\Enums\AdminTypePoint;
use App\Enums\TypePoint;
use App\Http\Trait\ActivityLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class AdminPoint extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;

    protected $guarded = [];


    public function tapActivity(Activity $activity, string $eventName)
    {
        $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
        $activity->description = "Admin Point has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
        $activity->properties = $activity->properties->merge([
            'causer_email'=>$causer ? $causer->email : 'unknown',
            'fullName' =>
            $causer ? $causer->first_name . ' ' . $causer->last_name : 'unkown',
            'role_user' => $causer ? $causer->roles[0]->name : 'unknown',
            'event' => $activity->event,
        ]);
    }


    protected $casts = [
        'type' => AdminTypePoint::class,
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}

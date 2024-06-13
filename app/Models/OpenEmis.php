<?php

namespace App\Models;

use App\Enums\OpenEmisStatus;
use App\Http\Trait\ActivityLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class OpenEmis extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;

    public const PATH_IMAGE = '/assets/OpenEmis/';
    public const DISK_NAME = 'openEmis';

    protected $guarded = [];

    public function tapActivity(Activity $activity, string $eventName)
    {
        if(Auth::guard('admin')->user()){
            $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
            $activity->description = "Open Emis has been {$eventName} by " . ($causer ? $causer->email : 'an unknown user');
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



    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }



    public static function getStatusName($status)
    {

        switch ($status) {
            case OpenEmisStatus::WAITING->value:
                return [OpenEmisStatus::WAITING->value, 'waiting'];
            break;
            case OpenEmisStatus::RECEIVED->value:
                return [OpenEmisStatus::RECEIVED->value, 'received'];
            break;
            case OpenEmisStatus::ENDED->value:
                return [OpenEmisStatus::ENDED->value, 'ended'];
            break;
            default:
                # code...
                break;
        }
    }


}

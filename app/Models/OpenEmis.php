<?php

namespace App\Models;

use App\Enums\OpenEmisStatus;
use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
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

    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'OpenEmis');
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

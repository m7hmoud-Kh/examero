<?php

namespace App\Models;

use App\Enums\AdminTypePoint;
use App\Enums\TypePoint;
use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class AdminPoint extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;

    protected $guarded = [];
    public $activity ;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Admin Point');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public static function getTypeName($type)
    {
        switch ($type) {
            case AdminTypePoint::REWARD->value:
                return [AdminTypePoint::REWARD->value, __("model.REWARD")];
            break;
            case AdminTypePoint::PUNISHMENT->value:
                return [AdminTypePoint::PUNISHMENT->value,  __("model.PUNISHMENT")];
            break;
            case AdminTypePoint::WARNING->value:
                return [AdminTypePoint::WARNING->value,  __("model.WARNING")];
            break;
            case AdminTypePoint::NOTHING->value:
                return [AdminTypePoint::NOTHING->value,  __("model.NOTHING")];
            break;
            default:
                # code...
                break;
        }
    }

}

<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;

class ActivityServices
{

    public function tapActivity(Activity $activity, string $eventName, $modelName)
    {
        if(Auth::guard('admin')->user()){
            $causer = Admin::role(['manager','supervisor','owner'])->find(Auth::guard('admin')->user()->id);
            $activity->description = __('services.has_been_by') . ' ' . ($causer ? $causer->email : 'an unknown user') . ' '. __("services.$eventName") . ' ' . __("services.$modelName");
            $activity->properties = $activity->properties->merge([
                'causer_email'=>$causer ? $causer->email : 'unknown',
                'fullName' =>
                $causer ? $causer->first_name . ' ' . $causer->last_name : 'unkown',
                'role_user' => $causer ? $causer->roles[0]->name : 'unknown',
                'event' => $activity->event,
            ]);

            $this->recordRecievedOrEndOpenEmis($activity,$eventName,$modelName,$causer);

        }else{
            $activity->description = 'null';
        }

    }

    public function recordRecievedOrEndOpenEmis(Activity $activity, string $eventName, $modelName, $causer)
    {
        if($modelName == 'OpenEmis' && $eventName == 'updated'){
            if($activity->properties['attributes']['status'] == '2' && $activity->properties['old']['status'] != 2){
                $activity->description = __('services.has_been_by') . ' ' . ($causer ? $causer->email : 'an unknown user') . ' '. __('services.received') . ' ' . __("services.$modelName");
            }elseif($activity->properties['attributes']['status'] == '3' && $activity->properties['old']['status'] != 3){
                $activity->description = __('services.has_been_by') . ' ' . ($causer ? $causer->email : 'an unknown user') . ' '. __('services.end') . ' ' . __("services.$modelName");
            }
        }
    }
}

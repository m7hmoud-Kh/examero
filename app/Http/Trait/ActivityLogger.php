<?php
namespace App\Http\Trait;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

trait ActivityLogger
{

    // Specify the events you want to log (optional)
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    // Customize the log name (optional)
    protected static $logName = 'Group';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded();
    }
}
